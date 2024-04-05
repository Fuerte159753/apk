<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type");

// Incluir el archivo de conexión
include '../conexion.php';
$data = json_decode(file_get_contents("php://input"));
// Verificar si se recibió un cuerpo de solicitud y si contiene el ID del pedido
if (isset($data->pedidoId)) {
    $pedido_id = $data->pedidoId;

    // Consulta SQL para actualizar el estado del pedido a "entregado"
    $sql = "UPDATE pedidos SET estado_pedido = 'entregado' WHERE pedido_id = $pedido_id";

    // Ejecutar la consulta
    if ($conn->query($sql) === TRUE) {
        // La consulta se ejecutó correctamente
        $response['success'] = true;
        $response['message'] = "El estado del pedido con ID $pedido_id se actualizó correctamente a 'entregado'.";
    } else {
        // Error al ejecutar la consulta
        $response['success'] = false;
        $response['message'] = "Error al actualizar el estado del pedido: " . $conn->error;
    }
} else {
    // No se recibió el ID del pedido correctamente
    $response['success'] = false;
    $response['message'] = "No se ha recibido el ID del pedido correctamente.";
}

// Cerrar la conexión
$conn->close();

// Devolver la respuesta en formato JSON
header('Content-Type: application/json');
echo json_encode($response);
?>
