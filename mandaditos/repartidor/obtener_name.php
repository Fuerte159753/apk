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
    
    // Realiza la consulta para obtener el nombre y el apellido del repartidor por su ID
    $sqlNombreRepartidor = "SELECT nombre, apellido FROM repartidores WHERE repartidor_id = '$repartidorId'";
    $resultNombreRepartidor = $conn->query($sqlNombreRepartidor);
    
    if ($resultNombreRepartidor->num_rows > 0) {
        $rowNombreRepartidor = $resultNombreRepartidor->fetch_assoc();
        $nombreRepartidor = $rowNombreRepartidor['nombre'];
        $apellidoRepartidor = $rowNombreRepartidor['apellido'];

        // Envía el nombre y el apellido del repartidor en la respuesta
        $response['nombre_repartidor'] = $nombreRepartidor;
        $response['apellido_repartidor'] = $apellidoRepartidor;
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
