<?php
require_once "conexion.php";

$sql = "SELECT id, identificacion, nombre, correo FROM estudiantes ORDER BY id ASC";
$stmt = $conexion->prepare($sql);
$stmt->execute();
$estudiantes = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Listado de Estudiantes</title>
    <link rel="stylesheet" href="estilos.css">
</head>
<body>
    <main class="contenedor">
        <h1>Listado de Estudiantes</h1>
        <p>Aplicación web ejecutándose en Banana Pi con Apache, PHP y MariaDB.</p>

        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Identificación</th>
                    <th>Nombre</th>
                    <th>Correo</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($estudiantes as $estudiante): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($estudiante["id"]); ?></td>
                        <td><?php echo htmlspecialchars($estudiante["identificacion"]); ?></td>
                        <td><?php echo htmlspecialchars($estudiante["nombre"]); ?></td>
                        <td><?php echo htmlspecialchars($estudiante["correo"]); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </main>
</body>
</html>