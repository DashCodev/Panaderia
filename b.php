<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panadería Delicious Bread</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #e3d7bf;
            border-top: 70px solid #3F2817;
            margin: 0;
            padding: 0;
        }

        #menu-sidebar {
            width: 220px;
            padding: 20px;
            position: fixed;
            top: 80px;
            left: 0;
            bottom: 0;
            overflow-y: auto;
            z-index: 1;
            background-color: #c7b69f;
            border-radius: 0 10px 10px 0;
        }

        #menu-sidebar h2 {
            text-align: center;
            margin-top: 0;
            color: #2E1503;
            font-size: 20px;
            margin-bottom: 20px;
        }

        #menu-sidebar ul {
            list-style-type: none;
            padding: 0;
            margin: 0;
            text-align: left;
        }

        #menu-sidebar li {
            margin-bottom: 10px;
            border: 2px solid #2E1503;
            border-radius: 5px;
            background-color: #fff;
            padding: 10px;
        }

        #menu-sidebar a {
            text-decoration: none;
            color: #2E1503;
            font-size: 16px;
            display: block;
            transition: background-color 0.3s;
        }

        #menu-sidebar a:hover {
            background-color: #f9f9f9;
        }

        .precio {
            font-size: 14px;
            color: #2E1503;
            float: right;
            margin-left: 10px;
        }
    </style>
</head>
<body>
    <!-- Sección b: Menú lateral -->
    <div id="menu-sidebar">
        <h2>PANES</h2>
        <ul>
            <li>
                <a href="imagenes/pandebono.png" data-nombre="Pandebono" data-precio="4000">
                    <span>Pandebono</span>
                    <span class="precio">$4.000</span>
                </a>
            </li>
            <li>
                <a href="imagenes/pan-de-queso.png" data-nombre="Pan de Queso" data-precio="2500">
                    <span>Pan de Queso</span>
                    <span class="precio">$2.500</span>
                </a>
            </li>
            <li>
                <a href="imagenes/pan-tajado.png" data-nombre="Pan Tajado" data-precio="2000">
                    <span>Pan Tajado</span>
                    <span class="precio">$2.000</span>
                </a>
            </li>
            <li>
                <a href="imagenes/pan-de-leche.png" data-nombre="Pan de Leche" data-precio="2500">
                    <span>Pan de Leche</span>
                    <span class="precio">$2.500</span>
                </a>
            </li>
        </ul>
        <br>
        <h2>POSTRES</h2>
        <ul>
            <li>
                <a href="imagenes/croissant.png" data-nombre="Croissant" data-precio="2000">
                    <span>Croissant</span>
                    <span class="precio">$2.000</span>
                </a>
            </li>
            <li>
                <a href="imagenes/alfajor.png" data-nombre="Alfajor" data-precio="2500">
                    <span>Alfajor</span>
                    <span class="precio">$2.500</span>
                </a>
            </li>
            <li>
                <a href="imagenes/brownie.png" data-nombre="Brownie" data-precio="4500">
                    <span>Brownie</span>
                    <span class="precio">$4.500</span>
                </a>
            </li>
            <li>
                <a href="imagenes/flan.png" data-nombre="Flan" data-precio="3000">
                    <span>Flan</span>
                    <span class="precio">$3.000</span>
                </a>
            </li>
        </ul>
    </div>
   
    <script>
        // Función para enviar un mensaje con el URL de la imagen, nombre y precio del producto al carrito
        function enviarMensaje(urlImagen, nombreProducto, precioProducto) {
            console.log("Enviando mensaje con URL de imagen:", urlImagen);
            // Acceder al marco "centerFrame" que contiene c.htm y enviar un mensaje con el URL de la imagen, nombre y precio
            window.parent.frames['centerFrame'].postMessage({ type: 'cambio_imagen', urlImagen, nombreProducto, precioProducto }, '*');
        }

        // Obtener todos los elementos de la lista de productos
        const productos = document.querySelectorAll('#menu-sidebar a');

        // Agregar un controlador de eventos clic a cada elemento de la lista de productos
        productos.forEach(producto => {
            producto.addEventListener('click', function(event) {
                // Evitar que el enlace se siga cuando se hace clic
                event.preventDefault();
                
                // Obtener la URL de la imagen del atributo href del enlace
                const urlImagen = this.getAttribute('href');
                const nombreProducto = this.dataset.nombre;
                const precioProducto = parseFloat(this.dataset.precio);
                
                // Llamar a la función para enviar el mensaje con el URL de la imagen, nombre y precio del producto al carrito
                enviarMensaje(urlImagen, nombreProducto, precioProducto);
            });
        });

        // Escuchar mensajes enviados desde otras ventanas (no se necesita modificar)
        window.addEventListener('message', function(event) {
            if (event.data && event.data.type === 'cambio_imagen') {
                // Actualizar la imagen de fondo con la URL recibida (no se necesita modificar)
                document.body.style.backgroundImage = `url(${event.data.urlImagen})`;
            }
        });
    </script>
</body>
</html>
