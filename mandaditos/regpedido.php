<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json; charset=UTF-8");

include 'conexion.php';
$data = json_decode(file_get_contents("php://input"));
 $new = $data->datos;
 $fecha = obtenerFechaHoraActual();
 $sql ="INSERT INTO pedidos (cliente_id, fecha_pedido, direccion, descripcion, cantidad, categoria, subcategoria, estado_pedido) 
 VALUES ('$new->id', '$fecha', '$new->direccion', '$new->pedidoTexto1', '1', '$new->cat', '$new->subcategoria' 'en espera')";
if ($conn->query($sql) === TRUE) {
    echo json_encode(array("message" => "Pedido agregado correctamente"));
} else {
    echo json_encode(array("message" => "Error al agregar el pedido: " . $conn->error));
}
 function obtenerFechaHoraActual() {
    date_default_timezone_set('America/Mexico_City'); // Por ejemplo: 'America/Mexico_City'
    $fecha = date("d-m-y H:i");

    return $fecha;
}
 $conn->close();
?>