<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json; charset=UTF-8");

include 'conexion.php';
$data = json_decode(file_get_contents("php://input"), true);
$id = $data['id'];
$sql = "SELECT nombre, apellido, telefono, correo, localidad, password FROM clientes WHERE cliente_id = '$id'";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    $cl = $result->fetch_assoc();
    echo json_encode($cl);
} else {
    echo "Cliente no encontrado";
}
$conn->close();
?>