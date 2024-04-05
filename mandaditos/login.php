<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json; charset=UTF-8");

$postdata = file_get_contents("php://input");
$request = json_decode($postdata);

if(isset($request->email) && isset($request->password)) {
  $email = $request->email;
  $pass = $request->password;

  include 'conexion.php';

  $sql_clientes = "SELECT * FROM clientes WHERE correo = '$email'";
  $result_clientes = $conn->query($sql_clientes);

  $sql_repartidores = "SELECT * FROM repartidores WHERE correo = '$email'";
  $result_repartidores = $conn->query($sql_repartidores);

  if ($result_clientes->num_rows > 0) {
    $cliente = $result_clientes->fetch_assoc();
    if (password_verify($pass, $cliente['password'])) {
      echo json_encode(["success" => true, "tipo" => 0, "id" => $cliente['cliente_id'],"code"=>$cliente['verificado'], "message" => "Inicio de sesión exitoso para el cliente"]);
    } else {
      echo json_encode(["ERROR" => true, "message" => "Verifica tu información"]);
    }
  } elseif ($result_repartidores->num_rows > 0) {
    $repartidor = $result_repartidores->fetch_assoc();
    if (password_verify($pass, $repartidor['password'])) {
      echo json_encode(["success" => true, "tipo" => 1, "id" => $repartidor['repartidor_id'], "message" => "Inicio de sesión exitoso"]);
    } else {
      echo json_encode(["ERROR" => true, "message" => "Verifica tu información"]);
    }
  } else {
    echo json_encode(["ERROR" => true, "message" => "Usuario no encontrado"]);
  }
} else {
  echo json_encode(["ERROR" => true, "message" => "Datos no proporcionados"]);
}
$conn->close();
?>
