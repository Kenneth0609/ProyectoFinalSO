<?php
require_once "auth.php";
require_once "conexion.php";

$mensaje = "";
$estudianteEditar = null;

// Eliminar estudiante
if (isset($_GET["eliminar"])) {
    $id = intval($_GET["eliminar"]);

    try {
        $sql = "DELETE FROM estudiantes WHERE id = :id";
        $stmt = $conexion->prepare($sql);
        $stmt->bindParam(":id", $id, PDO::PARAM_INT);
        $stmt->execute();

        header("Location: index.php?mensaje=eliminado");
        exit;
    } catch (PDOException $e) {
        $mensaje = "Error al eliminar: " . $e->getMessage();
    }
}

// Cargar datos para editar
if (isset($_GET["editar"])) {
    $id = intval($_GET["editar"]);

    $sql = "SELECT id, identificacion, nombre, correo 
            FROM estudiantes 
            WHERE id = :id";

    $stmt = $conexion->prepare($sql);
    $stmt->bindParam(":id", $id, PDO::PARAM_INT);
    $stmt->execute();

    $estudianteEditar = $stmt->fetch(PDO::FETCH_ASSOC);
}

// Insertar o actualizar estudiante
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $id = isset($_POST["id"]) ? intval($_POST["id"]) : 0;
    $identificacion = trim($_POST["identificacion"]);
    $nombre = trim($_POST["nombre"]);
    $correo = trim($_POST["correo"]);

    if ($identificacion === "" || $nombre === "" || $correo === "") {
        $mensaje = "Todos los campos son obligatorios.";
    } else {
        try {
            if ($id > 0) {
                $sql = "UPDATE estudiantes
                        SET identificacion = :identificacion,
                            nombre = :nombre,
                            correo = :correo
                        WHERE id = :id";

                $stmt = $conexion->prepare($sql);
                $stmt->bindParam(":id", $id, PDO::PARAM_INT);
                $stmt->bindParam(":identificacion", $identificacion);
                $stmt->bindParam(":nombre", $nombre);
                $stmt->bindParam(":correo", $correo);
                $stmt->execute();

                header("Location: index.php?mensaje=actualizado");
                exit;
            } else {
                $sql = "INSERT INTO estudiantes (identificacion, nombre, correo)
                        VALUES (:identificacion, :nombre, :correo)";

                $stmt = $conexion->prepare($sql);
                $stmt->bindParam(":identificacion", $identificacion);
                $stmt->bindParam(":nombre", $nombre);
                $stmt->bindParam(":correo", $correo);
                $stmt->execute();

                header("Location: index.php?mensaje=insertado");
                exit;
            }
        } catch (PDOException $e) {
            $mensaje = "Error al guardar: " . $e->getMessage();
        }
    }
}

// Mensajes por URL
if (isset($_GET["mensaje"])) {
    if ($_GET["mensaje"] === "insertado") {
        $mensaje = "Estudiante insertado correctamente.";
    } elseif ($_GET["mensaje"] === "actualizado") {
        $mensaje = "Estudiante actualizado correctamente.";
    } elseif ($_GET["mensaje"] === "eliminado") {
        $mensaje = "Estudiante eliminado correctamente.";
    }
}

// Listar estudiantes
$sql = "SELECT id, identificacion, nombre, correo 
        FROM estudiantes 
        ORDER BY id ASC";

$stmt = $conexion->prepare($sql);
$stmt->execute();

$estudiantes = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>CRUD de Estudiantes</title>
    <link rel="stylesheet" href="estilos.css">
</head>
<body>
    <header class="barra-superior">
        <div>
            <strong>Proyecto Banana Pi</strong>
        </div>

        <nav>
            <span>Usuario: <?php echo htmlspecialchars($_SESSION["usuario"]); ?></span>
            <a href="consumir_api.html">Consumir API</a>
            <a href="api_estudiantes.php" target="_blank">API JSON</a>
            <a href="logout.php">Cerrar sesión</a>
        </nav>
    </header>

    <main class="contenedor">
        <h1>CRUD de Estudiantes</h1>
        <p>Aplicación web ejecutándose con Apache, PHP y MariaDB.</p>

        <?php if ($mensaje !== ""): ?>
            <div class="mensaje">
                <?php echo htmlspecialchars($mensaje); ?>
            </div>
        <?php endif; ?>

        <section class="formulario">
            <h2>
                <?php echo $estudianteEditar ? "Editar estudiante" : "Agregar estudiante"; ?>
            </h2>

            <form method="POST" action="index.php">
                <input 
                    type="hidden" 
                    name="id" 
                    value="<?php echo $estudianteEditar ? htmlspecialchars($estudianteEditar["id"]) : ""; ?>"
                >

                <label>Identificación</label>
                <input 
                    type="text" 
                    name="identificacion" 
                    required
                    value="<?php echo $estudianteEditar ? htmlspecialchars($estudianteEditar["identificacion"]) : ""; ?>"
                >

                <label>Nombre</label>
                <input 
                    type="text" 
                    name="nombre" 
                    required
                    value="<?php echo $estudianteEditar ? htmlspecialchars($estudianteEditar["nombre"]) : ""; ?>"
                >

                <label>Correo</label>
                <input 
                    type="email" 
                    name="correo" 
                    required
                    value="<?php echo $estudianteEditar ? htmlspecialchars($estudianteEditar["correo"]) : ""; ?>"
                >

                <div class="acciones-form">
                    <button type="submit">
                        <?php echo $estudianteEditar ? "Actualizar" : "Guardar"; ?>
                    </button>

                    <?php if ($estudianteEditar): ?>
                        <a class="btn-secundario" href="index.php">Cancelar</a>
                    <?php endif; ?>
                </div>
            </form>
        </section>

        <section>
            <h2>Listado de estudiantes</h2>

            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Identificación</th>
                        <th>Nombre</th>
                        <th>Correo</th>
                        <th>Acciones</th>
                    </tr>
                </thead>

                <tbody>
                    <?php foreach ($estudiantes as $estudiante): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($estudiante["id"]); ?></td>
                            <td><?php echo htmlspecialchars($estudiante["identificacion"]); ?></td>
                            <td><?php echo htmlspecialchars($estudiante["nombre"]); ?></td>
                            <td><?php echo htmlspecialchars($estudiante["correo"]); ?></td>
                            <td class="acciones">
                                <a 
                                    class="btn-editar" 
                                    href="index.php?editar=<?php echo $estudiante["id"]; ?>"
                                >
                                    Editar
                                </a>

                                <a 
                                    class="btn-eliminar" 
                                    href="index.php?eliminar=<?php echo $estudiante["id"]; ?>"
                                    onclick="return confirm('¿Seguro que desea eliminar este estudiante?');"
                                >
                                    Eliminar
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </section>
    </main>
</body>
</html>