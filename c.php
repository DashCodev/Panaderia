<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Compra de Producto</title>
    <link rel="stylesheet" href="estilos.css">
</head>

<body>
    <!-- Elementos para agregar productos -->
    <button id="botonAgregar" style="display: none;">Agregar al carrito</button>
    <input type="number" id="cantidadInput" value="1" min="1" style="display: none;">

    <!-- Formulario de compra -->
    <div id="formularioCompra" style="display: none;">
        <!-- Botón para cerrar el formulario -->
        <button id="cerrarFormulario" style="float: right;">×</button>
        <h2>Detalles de Compra</h2>
        <ul id="listaProductos"></ul>
        <div id="resumenCompra">
            <span id="monto">Monto Total de la Compra: </span><br>
            <span id="descuento">Monto a Pagar con Descuento: </span><br> <!-- Nuevo campo -->
        </div>
        
        <!-- Botones en línea -->
        <div class="botones">
            <button id="botonObtenerDescuento">Obtener Descuento</button>
            <input type="button" id="botonPagar" value="Pagar">
        </div>
    </div>

    <script>
        // Variables globales para el monto total y los productos
        let montoTotal = 0;
        const productos = {};

        // Función para mostrar el formulario de compra
        function mostrarFormularioCompra() {
            document.getElementById('formularioCompra').style.display = 'block';
        }

        // Oculta el formulario de compra
        function ocultarFormularioCompra() {
            document.getElementById('formularioCompra').style.display = 'none';
        }

        // Muestra el botón para agregar productos
        function mostrarBotonAgregar() {
            document.getElementById('botonAgregar').style.display = 'block';
            document.getElementById('cantidadInput').style.display = 'inline-block';
        }

        // Formatea el precio con separadores de miles
        function formatearPrecio(precio) {
            return precio.toLocaleString('es-CO', { style: 'currency', currency: 'COP' });
        }

        // Actualiza el monto total formateado en el campo correspondiente
        function actualizarMontoTotal() {
            const montoElement = document.getElementById('monto');
            montoElement.textContent = `Monto Total de la Compra: ${formatearPrecio(montoTotal)}`;
        }

        // Maneja los mensajes recibidos desde otras ventanas
        window.addEventListener('message', function(event) {
            if (event.data && event.data.type === 'abrir_formulario_compra') {
                // Mostrar el formulario de compra cuando se reciba el mensaje
                mostrarFormularioCompra();
            } else if (event.data && event.data.type === 'cambio_imagen') {
                document.body.style.backgroundImage = `url(${event.data.urlImagen})`;
                mostrarBotonAgregar();
                window.localStorage.setItem('nombreProducto', event.data.nombreProducto);
                window.localStorage.setItem('precioProducto', event.data.precioProducto);
            } else if (event.data && event.data.type === 'restablecer_imagen') {
                document.body.style.backgroundImage = 'url("imagenes/presentación.png")';
                document.getElementById('botonAgregar').style.display = 'none';
                document.getElementById('cantidadInput').style.display = 'none';
                ocultarFormularioCompra();
            }
        });

        // Agrega un producto al carrito
        function agregarProductoAlCarrito() {
            const cantidad = parseInt(document.getElementById('cantidadInput').value);
            const nombreProducto = window.localStorage.getItem('nombreProducto');
            const precioProducto = parseFloat(window.localStorage.getItem('precioProducto'));

            if (productos[nombreProducto]) {
                productos[nombreProducto] += cantidad;
            } else {
                productos[nombreProducto] = cantidad;
            }

            montoTotal += precioProducto * cantidad;
            actualizarListaProductos();
            // Actualiza el monto total
            actualizarMontoTotal();
            mostrarFormularioCompra();
        }

        // Actualiza la lista de productos en el formulario de compra
        function actualizarListaProductos() {
            const listaProductos = document.getElementById('listaProductos');
            listaProductos.innerHTML = '';

            for (const producto in productos) {
                if (productos.hasOwnProperty(producto)) {
                    const cantidad = productos[producto];
                    const listItem = document.createElement('li');
                    listItem.textContent = `${producto}: ${cantidad}`;

                    // Crear botones de suma y resta para ajustar la cantidad de productos
                    const btnMenos = document.createElement('button');
                    btnMenos.textContent = '-';
                    btnMenos.className = 'btnCantidad';
                    btnMenos.addEventListener('click', () => restarCantidad(producto));

                    const btnMas = document.createElement('button');
                    btnMas.textContent = '+';
                    btnMas.className = 'btnCantidad';
                    btnMas.addEventListener('click', () => sumarCantidad(producto));

                    listItem.appendChild(btnMenos);
                    listItem.appendChild(btnMas);

                    listaProductos.appendChild(listItem);
                }
            }
        }

        // Suma la cantidad de un producto
        function sumarCantidad(producto) {
            productos[producto]++;
            const precioProducto = parseFloat(window.localStorage.getItem('precioProducto'));
            montoTotal += precioProducto;

            actualizarListaProductos();
            // Actualizar el monto total
            actualizarMontoTotal();
        }

        // Resta la cantidad de un producto
        function restarCantidad(producto) {
            if (productos[producto] > 0) {
                productos[producto]--;
                const precioProducto = parseFloat(window.localStorage.getItem('precioProducto'));
                montoTotal -= precioProducto;
                 
                if (productos[producto] === 0) {
                    //Elimina el producto si la cantidad llega a cero
                    delete productos[producto];
                }

                actualizarListaProductos();
                // Actualizar el monto total
                actualizarMontoTotal();
            }
        }

        // Maneja el pago
        function manejarPago(event) {
            event.preventDefault();
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = 'logica/registrar_compra.php';

            const totalCompraInput = document.createElement('input');
            totalCompraInput.type = 'hidden';
            totalCompraInput.name = 'total_compra';
            totalCompraInput.value = montoTotal;
            form.appendChild(totalCompraInput);

            document.body.appendChild(form);
            form.submit();

            document.getElementById('mensajeExito').style.display = 'block';
            setTimeout(() => {
                document.getElementById('mensajeExito').style.display = 'none';
            }, 3000);
        }

        // Función para obtener el descuento del usuario
        function obtenerDescuento() {
            fetch('logica/obtener_descuento.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ monto_total: montoTotal })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    const montoConDescuento = montoTotal - (montoTotal * data.descuento);
                    alert(`Tipo de cliente: ${data.tipo_cliente}\nDescuento: ${data.descuento * 100}%`);
                    const descuentoElement = document.getElementById('descuento');
                    descuentoElement.textContent = `Monto a Pagar con Descuento: ${formatearPrecio(montoConDescuento)}`;
                } else {
                    alert(`Error al obtener el descuento: ${data.message}`);
                }
            })
            .catch(error => {
                alert(`Error de conexión: ${error}`);
            });
        }

        document.getElementById('botonObtenerDescuento').addEventListener('click', obtenerDescuento);
        document.getElementById('cerrarFormulario').addEventListener('click', ocultarFormularioCompra); // Botón para cerrar el formulario

        document.getElementById('botonAgregar').addEventListener('click', agregarProductoAlCarrito);
        document.getElementById('botonPagar').addEventListener('click', manejarPago);

        actualizarMontoTotal();
    </script>
</body>

</html>
