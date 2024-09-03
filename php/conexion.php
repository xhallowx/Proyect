<?php
$conexion = mysqli_connect("localhost", "root", "", "login_Ry");

if (!$conexion) {
    die("Conexión fallida: " . mysqli_connect_error());
}
?>
