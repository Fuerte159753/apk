<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json; charset=UTF-8");

include 'conexion.php';

$data = json_decode(file_get_contents("php://input"));
if (isset($data->id)) {
    $clienteId = $data->id;

    $sql = "SELECT id_dire, direccion FROM direcciones WHERE cliente_id = '$clienteId'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $direcciones = array();
        while ($row = $result->fetch_assoc()) {
            $direcciones[] = $row;
        }
        echo json_encode($direcciones);
    } else {
        echo json_encode(array("message" => "No se encontraron direcciones para el cliente con ID: $clienteId"));
    }
} else {
    echo json_encode(array("message" => "No se recibió el ID del cliente"));
}

$conn->close();
?>
