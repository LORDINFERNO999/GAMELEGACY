<?php
require_once 'conexion.php';

$query = "SELECT * FROM juego ORDER BY nombre ASC";
$resultado = $conexion->query($query);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>GAMELEGACY - Juegos</title>
    <link rel="stylesheet" href="paginaJuegos.css" />
    <link rel="stylesheet" href="css/filtros.css" />
    <link rel="stylesheet" href="css/modal.css" />
</head>
<body>
    <!-- Menú principal -->
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
        <h1>GAMELEGACY</h1>
        <p>🎮 Catálogo de videojuegos retro</p>

        <hr />

        <section id="catalogo">
            <h2>Explora los clásicos</h2>
            <p>
                Descubre algunos de los videojuegos retro más recordados de la
                historia. Consulta su consola, año de lanzamiento y una breve
                descripción.
            </p>

            <!-- PANEL DE FILTROS -->
            <div class="filtros-container">
                <h3>🔎 Filtrar juegos</h3>
                
                <div class="filtros-grid">
                    <!-- Búsqueda por nombre -->
                    <div class="filtro-grupo">
                        <label for="buscador">🎮 Buscar por nombre</label>
                        <input type="text" id="buscador" placeholder="Ej: Mario, Sonic...">
                    </div>

                    <!-- Filtro por consola -->
                    <div class="filtro-grupo">
                        <label for="filtro-consola">🕹️ Consola</label>
                        <select id="filtro-consola">
                            <option value="">Todas las consolas</option>
                            <option value="NES">NES</option>
                            <option value="SNES">SNES</option>
                            <option value="Mega Drive">Mega Drive</option>
                            <option value="Game Boy">Game Boy</option>
                            <option value="PlayStation">PlayStation</option>
                            <option value="Arcade">Arcade</option>
                            <option value="Atari">Atari</option>
                        </select>
                    </div>

                    <!-- Filtro por género -->
                    <div class="filtro-grupo">
                        <label for="filtro-genero">🎯 Género</label>
                        <select id="filtro-genero">
                            <option value="">Todos los géneros</option>
                            <option value="Plataformas">Plataformas</option>
                            <option value="Acción">Acción</option>
                            <option value="Aventura">Aventura</option>
                            <option value="RPG">RPG</option>
                            <option value="Deportes">Deportes</option>
                            <option value="Lucha">Lucha</option>
                            <option value="Carreras">Carreras</option>
                            <option value="Puzzle">Puzzle</option>
                            <option value="Arcade">Arcade</option>
                            <option value="Disparos">Disparos</option>
                        </select>
                    </div>

                    <!-- Precio mínimo -->
                    <div class="filtro-grupo">
                        <label for="precio-min">💰 Precio mínimo</label>
                        <input type="number" id="precio-min" placeholder="$0" min="0" step="0.01">
                    </div>

                    <!-- Precio máximo -->
                    <div class="filtro-grupo">
                        <label for="precio-max">💰 Precio máximo</label>
                        <input type="number" id="precio-max" placeholder="$999" min="0" step="0.01">
                    </div>
                </div>

                <!-- Acciones y contador -->
                <div class="filtros-acciones">
                    <div id="contador-resultados">Cargando...</div>
                    <button id="resetear-filtros">🔄 Limpiar filtros</button>
                </div>
            </div>

            <!-- 🔥 Lista de juegos desde la base de datos -->
            <div class="juegos-grid">
                <?php 
                if ($resultado && $resultado->num_rows > 0) {
                    while ($juego = $resultado->fetch_assoc()): 
                        // Construir la ruta de la imagen
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
                <article class="juego-card">
                    <h3><?php echo htmlspecialchars($juego['nombre']); ?></h3>

                    <img src="<?php echo htmlspecialchars($ruta_imagen); ?>" 
                         alt="<?php echo htmlspecialchars($juego['nombre']); ?>"
                         onerror="this.src='IMAGENES/default.jpg'; this.onerror=null;"
                         loading="lazy">

                    <p><strong>Consola:</strong> <?php echo htmlspecialchars($juego['consola']); ?></p>
                    <p><strong>Año:</strong> <?php echo htmlspecialchars($juego['ano_lanzamiento']); ?></p>
                    <p><strong>Género:</strong> <?php echo htmlspecialchars($juego['genero']); ?></p>
                    <p><strong>Precio:</strong> $<?php echo number_format($juego['precio'], 2); ?> USD</p>
                    <p><?php echo htmlspecialchars($juego['descripcion']); ?></p>
                </article>
                <?php 
                    endwhile;
                } else {
                    echo '<p>No hay juegos disponibles en este momento.</p>';
                }
                ?>
            </div>
        </section>
    </main>

    <footer>
        © 2025 GAMELEGACY | Conservando el legado de los videojuegos retro 🕹️
    </footer>
    
    <script src="js/filtros.js"></script>
    <script src="js/modal.js"></script>
</body>
</html>
<?php 
if ($resultado) {
    $resultado->free();
}
$conexion->close(); 
?>