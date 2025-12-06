<?php
require_once 'conexion.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: contacto.php');
    exit;
}

$nombre = trim($_POST['nombre'] ?? '');
$correo = trim($_POST['correo'] ?? '');
$mensaje = trim($_POST['mensaje'] ?? '');

if (empty($nombre) || empty($correo) || empty($mensaje)) {
    die('<p style="color: red;">❌ Error: Todos los campos son obligatorios.</p>
         <p><a href="contacto.php">Volver</a></p>');
}


if (!filter_var($correo, FILTER_VALIDATE_EMAIL)) {
    die('<p style="color: red;">❌ Error: El correo electrónico no es válido.</p>
         <p><a href="contacto.php">Volver</a></p>');
}


$stmt = $conexion->prepare("INSERT INTO contacto (nombre, correo, mensaje) VALUES (?, ?, ?)");
$stmt->bind_param("sss", $nombre, $correo, $mensaje);


if ($stmt->execute()) {

    header('Location: contacto.php?success=1');
    exit;
} else {
    echo '<p style="color: red;">❌ Error al guardar el mensaje: ' . $stmt->error . '</p>';
    echo '<p><a href="contacto.php">Volver</a></p>';
}

$stmt->close();
$conexion->close();
?>