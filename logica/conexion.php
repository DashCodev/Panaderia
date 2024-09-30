<?php
$host = "localhost";
$usuario = "root";
$contraseña = "pa123456";
$bd = "delicious_bread";

$conexion = mysqli_connect($host,$usuario,$contraseña,$bd);

if (!$conexion) {
    die("La conexión falló: " . mysqli_connect_error());
}
?>
 