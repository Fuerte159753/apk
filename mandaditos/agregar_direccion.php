<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json; charset=UTF-8");

include 'conexion.php';

$data = json_decode(file_get_contents("php://input"));
if (isset($data->id) && isset($data->nd)) {
    $clienteId = $data->id;
    $direccion = $data->nd;

    $sql = "INSERT INTO direcciones (cliente_id, direccion) VALUES ('$clienteId', '$direccion')";
    if ($conn->query($sql) === TRUE) {
        echo json_encode(array("message" => "Nueva dirección agregada correctamente"));
    } else {
        echo json_encode(array("message" => "Error al agregar dirección: " . $conn->error));
    }
    $conn->close();
} else {
    echo json_encode(array("message" => "No se recibieron datos o están incompletos."));
}
?>
