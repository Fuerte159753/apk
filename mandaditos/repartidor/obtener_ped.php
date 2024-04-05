<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
include '../conexion.php';

// Lee los datos del cuerpo de la solicitud
$data = json_decode(file_get_contents("php://input"));

// Verifica si se proporcionó el ID del repartidor en los datos recibidos
if (isset($data->id)) {
    $repartidorId = $data->id;

    // Realiza la consulta para obtener la ruta asignada al repartidor
    $sqlRuta = "SELECT ruta_asignada FROM repartidores WHERE repartidor_id = '$repartidorId'";
    $resultRuta = $conn->query($sqlRuta);

    if ($resultRuta->num_rows > 0) {
        $rowRuta = $resultRuta->fetch_assoc();
        $rutaAsignada = $rowRuta['ruta_asignada'];

        // Realiza la consulta para obtener el nombre de la ruta asignada
        $sqlNombreRuta = "SELECT nombre FROM rutas WHERE id = '$rutaAsignada'";
        $resultNombreRuta = $conn->query($sqlNombreRuta);

        if ($resultNombreRuta->num_rows > 0) {
            $rowNombreRuta = $resultNombreRuta->fetch_assoc();
            $nombreRuta = $rowNombreRuta['nombre'];

            // Realiza la consulta para obtener el cliente_id de los clientes con la misma localidad que la ruta asignada
            $sqlClienteId = "SELECT cliente_id FROM clientes WHERE localidad = '$nombreRuta'";
            $resultClienteId = $conn->query($sqlClienteId);

            if ($resultClienteId->num_rows > 0) {
                $pedidosPendientes = array();

                // Itera sobre los resultados para cada cliente
                while ($rowClienteId = $resultClienteId->fetch_assoc()) {
                    $clienteId = $rowClienteId['cliente_id'];

                    // Realiza la consulta para obtener los datos del cliente, incluyendo el número de teléfono
                    $sqlCliente = "SELECT * FROM clientes WHERE cliente_id = '$clienteId'";
                    $resultCliente = $conn->query($sqlCliente);

                    // Verifica si se encontró el cliente
                    if ($resultCliente->num_rows > 0) {
                        $rowCliente = $resultCliente->fetch_assoc();

                        // Realiza la consulta para obtener los pedidos pendientes del cliente
                        $sqlPedidos = "SELECT * FROM pedidos WHERE cliente_id = '$clienteId' AND estado_pedido = 'pendiente'";
                        $resultPedidos = $conn->query($sqlPedidos);

                        // Itera sobre los resultados para cada pedido pendiente
                        while ($rowPedido = $resultPedidos->fetch_assoc()) {
                            // Estructura los detalles del pedido
                            $detallesPedidoArray = array(
                                'pedido_id' => $rowPedido['pedido_id'],
                                'cliente_id' => $rowPedido['cliente_id'],
                                'fecha_pedido' => $rowPedido['fecha_pedido'],
                                'direccion' => $rowPedido['direccion'],
                                'descripcion' => $rowPedido['descripcion'],
                                'cantidad' => $rowPedido['cantidad'],
                                'estado_pedido' => $rowPedido['estado_pedido'],
                                'telefono_cliente' => $rowCliente['telefono'] // Agrega el número de teléfono del cliente
                            );

                            // Agrega los detalles del pedido al array de pedidos pendientes
                            $pedidosPendientes[] = $detallesPedidoArray;
                        }
                    }
                }

                // Envia los datos de los pedidos pendientes en la respuesta
                $response['pedidos_pendientes'] = $pedidosPendientes;
            } else {
                // Maneja el caso donde no se encontraron clientes con la misma localidad que la ruta asignada
                $response['success'] = false;
                $response['message'] = 'No se encontraron clientes con la misma localidad que la ruta asignada.';
            }
        } else {
            // Maneja el caso donde no se encontró la ruta asignada
            $response['success'] = false;
            $response['message'] = 'No se encontró la ruta asignada.';
        }
    } else {
        // Maneja el caso donde no se encontró el repartidor con el ID proporcionado
        $response['success'] = false;
        $response['message'] = 'No se encontró el repartidor con el ID proporcionado.';
    }
} else {
    // Maneja el caso donde no se proporcionó el ID del repartidor en los datos recibidos
    $response['success'] = false;
    $response['message'] = 'No se proporcionó el ID del repartidor en los datos recibidos.';
}

$conn->close();
header('Content-Type: application/json');
echo json_encode($response);
?>
