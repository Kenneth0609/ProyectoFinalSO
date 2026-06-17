<?php
session_start();

$usuarios = [
    "kenneth" => "kenneth",
    "daniel" => "daniel",
    "brandon" => "brandon",
    "fernanda" => "fernanda"
];

$error = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $usuario = strtolower(trim($_POST["usuario"]));
    $password = strtolower(trim($_POST["password"]));

    if (isset($usuarios[$usuario]) && $usuarios[$usuario] === $password) {
        $_SESSION["usuario"] = $usuario;
        header("Location: index.php");
        exit;
    } else {
        $error = "Usuario o contraseña incorrectos.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Login - Proyecto Banana Pi</title>
    <link rel="stylesheet" href="estilos.css">
</head>
<body>
    <main class="login-contenedor">
        <section class="login-card">
            <h1>Acceso al sistema</h1>
            <p>Proyecto servidor web en Banana Pi</p>

            <?php if ($error !== ""): ?>
                <div class="mensaje-error">
                    <?php echo htmlspecialchars($error); ?>
                </div>
            <?php endif; ?>

            <form method="POST" action="login.php">
                <label>Usuario</label>
                <input type="text" name="usuario" required placeholder="Ejemplo: kenneth">

                <label>Contraseña</label>
                <input type="password" name="password" required placeholder="Ejemplo: kenneth">

                <button type="submit">Ingresar</button>
            </form>

            <div class="usuarios-demo">
                <strong>Usuarios de prueba:</strong>
                <p>kenneth / kenneth</p>
                <p>daniel / daniel</p>
                <p>brandon / brandon</p>
                <p>fernanda / fernanda</p>
            </div>
        </section>
    </main>
</body>
</html>