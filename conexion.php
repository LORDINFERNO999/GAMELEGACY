<?php
$host = 'localhost';
$user = 'root';
$pass = '';
$db = 'gamelegacy';

$conexion = new mysqli($host, $user, $pass, $db);

if ($conexion->connect_errno) {
    die('Error al conectar a la base de datos: ' . $conexion->connect_error);
}


$conexion->set_charset('utf8mb4');
?>