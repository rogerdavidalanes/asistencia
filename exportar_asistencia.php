<?php
header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=asistencia.xls");
header("Pragma: no-cache");
header("Expires: 0");

echo "<table border='1'>";
echo "<tr><th>ID</th><th>DNI</th><th>NOMBRE Y APELLIDO</th><th>Fecha Asistencia</th></tr>";

$conexion = new mysqli("localhost", "root", "", "asistencia");
if ($conexion->connect_error) {
    die("Conexión fallida: " . $conexion->connect_error);
}

$sql = "SELECT id, dni, nombre, fecha FROM asistencia_registro";
$result = $conexion->query($sql);

while ($row = $result->fetch_assoc()) {
    echo "<tr>";
    echo "<td>" . $row['id'] . "</td>";
    echo "<td>" . $row['dni'] . "</td>";
    echo "<td>" . $row['nombre'] . "</td>";
    echo "<td>" . $row['fecha'] . "</td>";
    echo "</tr>";
}

echo "</table>";
exit;
?>
