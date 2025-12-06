<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>GAMELEGACY - Vender juegos</title>
    <link rel="stylesheet" href="paginaVentas.css" />
</head>
<body>
    <!--Menú de navegación principal -->
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

    <main class="container">
        <h1>GAMELEGACY</h1>
        <p>Vende tus videojuegos retro y comparte tu colección 🎮</p>

        <?php
        // Mostrar mensaje de éxito si existe
        if (isset($_GET['success']) && $_GET['success'] == 1) {
            echo '<p style="color: green; font-weight: bold; text-align: center;">✅ ¡Juego publicado exitosamente!</p>';
        }
        ?>

        <!-- Formulario -->
        <section id="vender">
            <h2>Formulario de venta</h2>

            <form action="procesar_venta.php" method="POST" enctype="multipart/form-data" class="formulario">
                <!-- Datos del vendedor -->
                <h3>Datos del vendedor</h3>

                <label for="nombre">Nombre completo:</label>
                <input type="text" id="nombre" name="nombre" required />

                <label for="correo">Correo electrónico:</label>
                <input type="email" id="correo" name="correo" required />

                <label for="telefono">Teléfono:</label>
                <input type="tel" id="telefono" name="telefono" placeholder="Ej: +57 300 123 4567" />

                <label for="direccion">Dirección:</label>
                <input type="text" id="direccion" name="direccion" placeholder="Ej: Calle 10 #20-30, Medellín" />

                <!-- Datos del videojuego -->
                <h3>Detalles del videojuego</h3>

                <label for="titulo">Título del juego:</label>
                <input type="text" id="titulo" name="titulo" required />

                <label for="ano">Año de lanzamiento:</label>
                <input type="number" id="ano" name="ano" min="1970" max="2025" placeholder="Ej: 1985" />

                <label for="consola">Consola / Plataforma:</label>
                <select id="consola" name="consola" required>
                    <option value="">--Selecciona una opción--</option>
                    <option value="NES">NES</option>
                    <option value="SNES">Super Nintendo (SNES)</option>
                    <option value="Mega Drive">SEGA Mega Drive</option>
                    <option value="Game Boy">Game Boy</option>
                    <option value="PlayStation">PlayStation</option>
                    <option value="Arcade">Arcade</option>
                    <option value="Atari">Atari</option>
                    <option value="MSX2">MSX2</option>
                    <option value="Otro">Otro</option>
                </select>

                <label for="genero">Género:</label>
                <select id="genero" name="genero" required>
                    <option value="">--Selecciona una opción--</option>
                    <option value="Plataformas">Plataformas</option>
                    <option value="Aventura">Aventura</option>
                    <option value="Acción">Acción</option>
                    <option value="RPG">RPG</option>
                    <option value="Lucha">Lucha</option>
                    <option value="Puzzle">Puzzle</option>
                    <option value="Arcade">Arcade</option>
                    <option value="Deportes">Deportes</option>
                    <option value="Carreras">Carreras</option>
                    <option value="Otro">Otro</option>
                </select>

                <label for="precio">Precio (USD):</label>
                <input type="number" id="precio" name="precio" min="1" step="0.01" required />

                <label for="descripcion">Descripción:</label>
                <textarea id="descripcion" name="descripcion" rows="4" placeholder="Descripción breve del juego..." required></textarea>

                <!-- Imagen del videojuego -->
                <label for="imagen">Imagen del videojuego:</label>
                <input type="file" id="imagen" name="imagen" accept="image/*" required />

                <!-- Botones -->
                <div class="botones">
                    <input type="submit" value="Publicar juego" class="btn" />
                    <input type="reset" value="Borrar todo" class="btn cancelar" />
                </div>
            </form>
        </section>
    </main>

    <!-- Pie de página -->
    <footer>
        <p>© 2025 GAMELEGACY | Comparte, juega y conserva el legado retro 🎮</p>
    </footer>
</body>
</html>
