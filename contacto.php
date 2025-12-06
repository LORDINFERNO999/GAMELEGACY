<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Contacto | GameLegacy</title>
    <link rel="stylesheet" href="paginaContactos.css" />
</head>
<body>

<header>
    <h1>GAMELEGACY</h1>
    <nav>
        <ul>
            <li><a href="index.php">Inicio</a></li>
            <li><a href="juegos.php">Juegos</a></li>
            <li><a href="ventas.php">Ventas</a></li>
            <li><a href="contacto.php" class="activo">Contacto</a></li>
        </ul>
    </nav>
</header>

<main>
    <div class="container">

        <h2>Formulario de Contacto</h2>

        <?php
        if (isset($_GET['success']) && $_GET['success'] == 1) {
            echo '<p style="color: green; font-weight: bold;">✅ ¡Mensaje enviado correctamente! Te responderemos pronto.</p>';
        }
        ?>

        <form id="contactoForm" class="formulario" action="procesar_contacto.php" method="POST">
            <label>Nombre:</label>
            <input type="text" name="nombre" id="nombre" required />

            <label>Email:</label>
            <input type="email" name="correo" id="correo" required />

            <label>Mensaje:</label>
            <textarea name="mensaje" id="mensaje" rows="5" required></textarea>

            <div class="botones">
                <input type="submit" value="Enviar" />
                <input type="reset" value="Limpiar" id="btnLimpiar" />
            </div>
        </form>
    </div>
</main>

<footer>
    <p>© 2025 GAMELEGACY. Todos los derechos reservados.</p>
</footer>

<script>

document.getElementById("correo").addEventListener("input", function () {
    const email = this.value;
    const valido = /^[^@]+@[^@]+\.[a-zA-Z]{2,}$/.test(email);

    this.style.borderColor = valido ? "#4CAF50" : "#ff4747";
});

const msg = document.getElementById("mensaje");
const texto = "Escribe tu mensaje aquí...";
let i = 0;

function escribir() {
    if (i < texto.length) {
        msg.placeholder += texto.charAt(i);
        i++;
        setTimeout(escribir, 40);
    }
}

msg.placeholder = "";
escribir();

document.getElementById("contactoForm").addEventListener("submit", function (e) {
    e.preventDefault();

    if (!confirm("¿Deseas enviar este mensaje?")) {
        return;
    }

    const submitBtn = this.querySelector('input[type="submit"]');
    submitBtn.value = "Enviando...";
    submitBtn.disabled = true;

    this.submit();
});

document.getElementById("btnLimpiar").addEventListener("click", () => {
    setTimeout(() => {
        msg.placeholder = "";
        i = 0;
        escribir();
    }, 300);
});
</script>

</body>
</html>
