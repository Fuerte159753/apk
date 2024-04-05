<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json; charset=UTF-8");
include 'conexion.php';

$id = $_GET['id']; // Obtén el ID del cliente desde la solicitud GET

$sql = "SELECT nombre FROM clientes WHERE cliente_id = $id"; // Query para obtener solo el nombre del cliente

$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);

echo json_encode($row['nombre']); // Devuelve solo el nombre como respuesta
?>