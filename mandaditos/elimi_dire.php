<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
include("conexion.php");
$data = json_decode(file_get_contents('php://input'), true);

$idDireccion = $data['idre'];

$sql = "DELETE FROM direcciones WHERE id_dire = $idDireccion";

$response = array();

if ($conn->query($sql) === TRUE) {
    $response['message'] = "Dirección eliminada correctamente";
} else {
    $response['message'] = "Error al eliminar dirección: " . $conn->error;
}
echo json_encode($response);
$conn->close();
?>
