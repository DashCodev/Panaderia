<?php
session_start(); // Inicia la sesión

// Verifica si el usuario ha iniciado sesión
$usuarioConectado = isset($_SESSION['username']);
?>

<!DOCTYPE html>
<html>

<head>
    <title>Panadería Delicious Bread</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"> <!-- Hoja de estilos de Font Awesome -->
    <style>
        /* Estilos generales */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        header {
            background-color: #fff;
            padding: 20px;
            text-align: center;
            position: relative;
        }

        /* Logo y menú */
        #logo {
            width: 150px;
            height: auto;
            position: absolute;
            top: 10px;
            left: 50%;
            transform: translateX(-50%);
            cursor: pointer;
        }

        /* Menú */
        .menu-left {
            position: absolute;
            top: 40px;
            left: 20px;
        }

        nav {
            position: absolute;
            top: 40px;
            right: 300px;
        }

        .menu-link {
            margin: 0 30px;
            text-decoration: none;
            color: #2E1503;
            font-weight: normal;
            font-size: 15px;
        }

        /* Icono del carrito */
        .cart-icon {
            position: absolute;
            top: 35px;
            right: 150px;
            font-size: 24px;
            color: #2E1503;
            cursor: pointer;
        }

        /* Conexión / Cierre de sesión */
        .connect-button {
            position: absolute;
            top: 35px;
            left: 50px;
        }

        .connect-button__button {
            background-color: #2E1503;
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }

        .connect-button__button i {
            margin-right: 5px;
        }
    </style>
</head>

<body>
    <header>
        <!-- Menú izquierdo -->
        <div class="menu-left">
            <a href="#menu" class="menu-link">NUESTRO MENÚ</a>
        </div>
        <a href="e.htm" class="menu-link">Cotizar</a> <!-- Enlace para cotizar -->
        <!-- Logo -->
        <img id="logo" src="imagenes/logo_delicious_bread.png" alt="Logo de Panadería Delicious Bread">
        <!-- Menú de navegación -->
        <nav>
            <a href="#about" class="menu-link">SOBRE NOSOTROS</a>
            <a href="#contact" class="menu-link">CONTÁCTENOS</a>
        </nav>
        <!-- Icono del carrito -->
        <div class="cart-icon" onclick="abrirCarrito()">
            <i class="fas fa-shopping-cart"></i>
        </div>

        <!-- Botón de conexión o cerrar sesión -->
        <div class="connect-button">
            <?php if ($usuarioConectado) { ?>
                <!-- Formulario para cerrar sesión -->
                <form method="post" action="logica/salir.php">
                    <button type="submit" class="connect-button__button">
                        <i class="fas fa-sign-out-alt"></i> Cerrar Sesión
                    </button>
                </form>
            <?php } else { ?>
                <!-- Botón de conexión -->
                <button class="connect-button__button" onclick="window.parent.location.href = 'login.html';">
                    <i class="fas fa-user"></i> Conectarse
                </button>
            <?php } ?>
        </div>
    </header>

    <script>
        // Función para enviar un mensaje al marco central para restablecer la imagen de fondo
        function restablecerImagen() {
            console.log("Restableciendo imagen original");
            window.parent.frames['centerFrame'].postMessage({ type: 'restablecer_imagen' }, '*');
        }

        document.getElementById('logo').addEventListener('click', function(event) {
            restablecerImagen();
        });

        // Función para abrir el formulario de compra en c.php
        function abrirCarrito() {
            console.log("Abriendo formulario de compra...");
            // Obtener el iframe que contiene c.php
            const cFrame = window.parent.frames['centerFrame'];
            
            // Enviar un mensaje al iframe de c.php
            cFrame.postMessage({ type: 'abrir_formulario_compra' }, '*');
        }
    </script>
</body>
</html>
