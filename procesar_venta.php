<?php
require_once 'conexion.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ventas.php');
    exit;
}

$nombre = trim($_POST['nombre'] ?? '');
$correo = trim($_POST['correo'] ?? '');
$telefono = trim($_POST['telefono'] ?? '');
$direccion = trim($_POST['direccion'] ?? '');

if (empty($nombre) || empty($correo)) {
    die('<p style="color: red;">❌ Error: El nombre y correo del vendedor son obligatorios.</p>
         <p><a href="ventas.php">Volver</a></p>');
}

if (!filter_var($correo, FILTER_VALIDATE_EMAIL)) {
    die('<p style="color: red;">❌ Error: Correo inválido.</p>
         <p><a href="ventas.php">Volver</a></p>');
}

$stmt = $conexion->prepare("SELECT id_cliente FROM cliente WHERE correo = ?");
$stmt->bind_param("s", $correo);
$stmt->execute();
$resultado = $stmt->get_result();

if ($resultado->num_rows > 0) {
    $id_cliente = $resultado->fetch_assoc()['id_cliente'];
} else {
    $stmt = $conexion->prepare("INSERT INTO cliente (nombre, correo, telefono, direccion) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $nombre, $correo, $telefono, $direccion);

    if (!$stmt->execute()) {
        die('<p style="color: red;">❌ Error al registrar cliente.</p>');
    }

    $id_cliente = $conexion->insert_id;
}

$archivo_imagen = $_FILES['imagen'] ?? null;
$nombre_imagen = "default.jpg"; // por si falla

if ($archivo_imagen && $archivo_imagen['error'] === 0) {

    $permitidos = ['image/jpeg', 'image/png', 'image/webp'];
    if (!in_array($archivo_imagen['type'], $permitidos)) {
        die("<p style='color:red;'>❌ Solo se permiten JPG, PNG o WebP.</p>");
    }

    if ($archivo_imagen['size'] > 5 * 1024 * 1024) { // 5MB
        die("<p style='color:red;'>❌ La imagen supera los 5MB permitidos.</p>");
    }

    // Crear carpeta uploads si no existe
    if (!is_dir('uploads')) {
        mkdir('uploads', 0777, true);
    }

    // Nombre único
    $nombre_imagen = time() . "_" . basename($archivo_imagen['name']);
    $ruta_destino = "uploads/" . $nombre_imagen;

    if (!move_uploaded_file($archivo_imagen['tmp_name'], $ruta_destino)) {
        die("<p style='color:red;'>❌ Error al guardar la imagen.</p>");
    }
}

$titulo = trim($_POST['titulo']);
$ano = trim($_POST['ano']);
$consola = trim($_POST['consola']);
$genero = trim($_POST['genero']);
$descripcion = trim($_POST['descripcion']);
$precio = trim($_POST['precio']);

if (empty($titulo) || empty($consola) || empty($genero) || empty($precio)) {
    die('<p style="color:red;">❌ Todos los campos del juego son obligatorios.</p>');
}

$stmt = $conexion->prepare(
    "INSERT INTO juego (nombre, ano_lanzamiento, consola, genero, descripcion, precio, imagen)
     VALUES (?, ?, ?, ?, ?, ?, ?)"
);
$stmt->bind_param("sisssds", $titulo, $ano, $consola, $genero, $descripcion, $precio, $nombre_imagen);

if (!$stmt->execute()) {
    die('<p style="color: red;">❌ Error al registrar juego.</p>');
}

$id_juego = $conexion->insert_id;

$fecha_actual = date('Y-m-d');
$total = $precio;

$stmt = $conexion->prepare("INSERT INTO venta (fecha, total, id_cliente) VALUES (?, ?, ?)");
$stmt->bind_param("sdi", $fecha_actual, $total, $id_cliente);
$stmt->execute();

$id_venta = $conexion->insert_id;

$cantidad = 1;
$subtotal = $precio;

$stmt = $conexion->prepare("INSERT INTO detalle_venta (id_venta, id_juego, cantidad, subtotal) VALUES (?, ?, ?, ?)");
$stmt->bind_param("iiid", $id_venta, $id_juego, $cantidad, $subtotal);
$stmt->execute();

$stmt->close();
$conexion->close();

header('Location: ventas.php?success=1');
exit;
?>
