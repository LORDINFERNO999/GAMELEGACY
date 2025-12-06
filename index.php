<?php
require_once 'conexion.php';

$query = "SELECT * FROM juego ORDER BY id_juego ASC LIMIT 5";
$resultado = $conexion->query($query);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>GAMELEGACY - Inicio</title>
    <link rel="stylesheet" href="paginaPrinsipal.css" />
    <link rel="stylesheet" href="css/typewriter.css" />
    <link rel="stylesheet" href="css/carrusel.css" />
</head>
<body>
    <header>
        <nav>
            <ul>
                <li><a href="index.php">Inicio</a></li>
                <li><a href="juegos.php">Juegos</a></li>
                <li><a href="ventas.php">Ventas</a></li>
                <li><a href="contacto.php">Contacto</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <div class="titulo-container">
            <video autoplay muted loop playsinline class="video-fondo">
                <source src="IMAGENES/video2.mp4" type="video/mp4" />
            </video>
            <h1>GAMELEGACY</h1>
        </div>

        <p>
            🎮 Revive la historia de los videojuegos clásicos y comparte tu legado retro
        </p>

        <hr />

        <section id="presentacion">
            <h2>Bienvenido a GAMELEGACY</h2>
            <p>
                En <strong>GAMELEGACY</strong> preservamos la historia de los videojuegos clásicos.
                Explora títulos retro, vende tus propios juegos y conecta con otros coleccionistas apasionados.
            </p>
            <p>Descubre joyas del pasado. ¡Mantén vivo el legado gamer! 👾</p>
        </section>

        <hr />

        <section id="destacados">
            <h2>Juegos destacados</h2>
            
            <?php while ($juego = $resultado->fetch_assoc()): 
                $imagen = $juego['imagen'];
                if (!empty($imagen)) {
                    if (strpos($imagen, 'IMAGENES/') === 0) {
                        $ruta_imagen = $imagen;
                    } else {
                        $ruta_imagen = 'IMAGENES/' . $imagen;
                    }
                } else {
                    $ruta_imagen = 'IMAGENES/default.jpg';
                }
            ?>
            <figure>
                <img src="<?php echo htmlspecialchars($ruta_imagen); ?>" 
                    alt="<?php echo htmlspecialchars($juego['nombre']); ?>"
                    onerror="this.src='IMAGENES/default.jpg'">
                <figcaption>
                    <?php echo htmlspecialchars($juego['nombre']); ?><br>
                    <small><?php echo htmlspecialchars($juego['consola']); ?> (<?php echo $juego['ano_lanzamiento']; ?>)</small>
                </figcaption>
            </figure>
            <?php endwhile; ?>
        </section>
    </main>

    <footer>
        © 2025 GAMELEGACY | Reviviendo los clásicos, un juego a la vez 🎮
    </footer>

    <script src="js/typewriter.js"></script>
    <script src="js/carrusel.js"></script>
</body>
</html>
<?php $conexion->close(); ?>
