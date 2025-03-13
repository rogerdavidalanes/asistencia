<?php
header("Content-Type: application/json");
$dato = json_decode(file_get_contents("php://input"), true);

if (!isset($dato["dni"])) {
    echo json_encode(["mensaje" => "Error: DNI no recibido!"]);
    exit;
}

$dni = $dato["dni"];

$conexion = new mysqli("localhost", "root", "", "asistencia");

if ($conexion->connect_error) {
    die(json_encode(["mensaje" => "Error de conexión a la base de datos"]));
}

// buscar el nombre del alumno segun el DNI
$query = $conexion->prepare("SELECT nombre FROM alumnos WHERE dni = ?"); //prepare() para evitar inyecciones SQL
//? indica que el valor del DNI se insertara desp
$query->bind_param("s", $dni); //bind_param() para asociar el ? con la variable $dni / s indica que el dato es un string
$query->execute();
$resultado = $query->get_result();

if ($resultado->num_rows == 0) {
    echo json_encode(["mensaje" => "DNI no encontrado"]);
    exit;
}

$alumno = $resultado->fetch_assoc(); //extrae el primer resultado como un array asociativo
$nombre = $alumno["nombre"];

// registrar la asistencia
$fecha = date("Y-m-d");
$hora = date("H:i:s");

$query = $conexion->prepare("INSERT INTO asistencia_registro (dni, nombre, fecha, hora) VALUES (?, ?, ?, ?)");
$query->bind_param("ssss", $dni, $nombre, $fecha, $hora);
$query->execute();

echo json_encode(["mensaje" => "¡Si crees en ti mismo ya has ganado!\n$nombre PRESENTE"]);


?>
