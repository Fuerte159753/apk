<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json; charset=UTF-8");

include 'conexion.php';

$data = json_decode(file_get_contents("php://input"));

$nombre = $data->registroData->nombre;
$apellido = $data->registroData->apellido;
$ruta = $data->registroData->rutaSeleccionada;
$direccion = $data->registroData->direccion;
$telefono = $data->registroData->telefono;
$correo = $data->registroData->correo;
$password = password_hash($data->registroData->password, PASSWORD_DEFAULT);

$sql_check_email = "SELECT * FROM clientes WHERE correo = '$correo'";
$result_check_email = $conn->query($sql_check_email);

if ($result_check_email->num_rows > 0) {
    echo json_encode(array("message" => "El correo electrónico ya está registrado"));
    exit();
}

$verificado = 1;
$codigo_verificacion = generateRandomNumber(100000, 999999);

$query_last_id = "SELECT MAX(cliente_id) AS max_id FROM clientes";
$result = $conn->query($query_last_id);
$row = $result->fetch_assoc();
$last_id = $row['max_id'];
$next_id = $last_id + 1;

$sql = "INSERT INTO clientes (cliente_id, nombre, apellido, localidad, telefono, correo, password, verificado, codigo_verificacion) VALUES ('$next_id', '$nombre','$apellido','$ruta','$telefono','$correo', '$password', '$verificado', '$codigo_verificacion')";

if ($conn->query($sql) == TRUE) {
    $sql_direccion = "INSERT INTO direcciones (cliente_id, direccion) VALUES ('$next_id', '$direccion')";
    if ($conn->query($sql_direccion) == TRUE) {
        require_once('mail/enviarmail.php');
        $envio_correo = enviarCorreo($nombre, $correo, $codigo_verificacion);

        if ($envio_correo === "success") {
            echo json_encode(array("message" => "success"));
        } else {
            $eliminar_cliente = "DELETE FROM clientes WHERE correo = '$correo'";
            $conn->query($eliminar_cliente);

            echo json_encode(array("message" => "Error al enviar el correo"));
        }
    } else {
        echo json_encode(array("message" => "Error al registrar dirección: " . $conn->error));
    }
} else {
    echo json_encode(array("message" => "Error al registrar usuario: " . $conn->error));
}
$conn->close();

function generateRandomNumber($min, $max) {
    return mt_rand($min, $max);
}
?>
