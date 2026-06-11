<?php
header("Content-Type: application/json; charset=utf-8");

require_once "conexion.php";

try {
    $identificacion = isset($_GET["identificacion"]) ? trim($_GET["identificacion"]) : "";

    if ($identificacion !== "") {
        $sql = "SELECT id, identificacion, nombre, correo 
                FROM estudiantes 
                WHERE identificacion = :identificacion";

        $stmt = $conexion->prepare($sql);
        $stmt->bindParam(":identificacion", $identificacion);
        $stmt->execute();
    } else {
        $sql = "SELECT id, identificacion, nombre, correo 
                FROM estudiantes 
                ORDER BY id ASC";

        $stmt = $conexion->prepare($sql);
        $stmt->execute();
    }

    $estudiantes = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode([
        "estado" => "ok",
        "total" => count($estudiantes),
        "datos" => $estudiantes
    ], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);

} catch (PDOException $e) {
    http_response_code(500);

    echo json_encode([
        "estado" => "error",
        "mensaje" => "Error al consultar la base de datos",
        "detalle" => $e->getMessage()
    ], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
}
?>