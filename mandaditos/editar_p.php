<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json; charset=UTF-8");

include 'conexion.php';

$data = json_decode(file_get_contents("php://input"));

$id = $data->id;
$newData = $data->newData;

$sql = "UPDATE clientes SET nombre = '$newData->nombre', apellido = '$newData->apellido', localidad ='$newData->ruta', telefono = '$newData->telefono' WHERE cliente_id = '$id'";

if ($conn->query($sql) === TRUE) {
    echo json_encode(array("message" => "success"));
} else {
    echo json_encode(array("message" => "Error al actualizar el perfil: " . $conn->error));
}

$conn->close();
?>
