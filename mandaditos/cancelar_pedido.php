<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
include 'conexion.php';

// Verifica si se proporcionó el ID del pedido
if (isset($_POST['pedido_id'])) {
    $pedidoId = $_POST['pedido_id'];
    $sql = "UPDATE pedidos SET estado_pedido = 'cancelado' WHERE pedido_id = '$pedidoId'";

    if ($conn->query($sql) == TRUE) {
        $response['success'] = true;
        $response['message'] = 'Pedido cancelado exitosamente';
    } else {
        $response['success'] = false;
        $response['message'] = 'Error al cancelar el pedido: ' . $conn->error;
    }
} else {
    $response['success'] = false;
    $response['message'] = 'Error: No se proporcionó el ID del pedido en el cuerpo de la solicitud.';
}

$conn->close();
header('Content-Type: application/json');
echo json_encode($response);
?>
