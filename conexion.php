<?php
$host = "localhost";
$dbname = "dblab01";

if (strtoupper(substr(PHP_OS, 0, 3)) === "WIN") {
    // XAMPP en Windows
    $port = "3307";
    $user = "root";
    $password = "";
} else {
    // Banana Pi / Linux
    $port = "3306";
    $user = "usuario_lab";
    $password = "12345";
}

try {
    $conexion = new PDO(
        "mysql:host=$host;port=$port;dbname=$dbname;charset=utf8",
        $user,
        $password
    );

    $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

} catch (PDOException $e) {
    die("Error de conexión: " . $e->getMessage());
}
?>