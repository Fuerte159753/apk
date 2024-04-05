<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json; charset=UTF-8");

include 'conexion.php';

$data = json_decode(file_get_contents("php://input"));

$id = $data->id;
$codigo_verificacion = $data->codigo;

$sql = "SELECT * FROM clientes WHERE cliente_id = '$id' AND codigo_verificacion = '$codigo_verificacion'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $update_sql = "UPDATE clientes SET verificado = 0 WHERE cliente_id = '$id'";
    if ($conn->query($update_sql) === TRUE) {
        echo json_encode(array("success" => true, "message" => "Código de verificación correcto. El cliente ha sido verificado."));
    } else {
        echo json_encode(array("success" => false, "message" => "Error al actualizar el estado de verificación del cliente: " . $conn->error));
    }
} else {
    echo json_encode(array("success" => false, "message" => "Código de verificación incorrecto."));
}

$conn->close();
?>