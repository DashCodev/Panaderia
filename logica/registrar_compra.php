<?php
// Incluir el archivo de conexión a la base de datos
require_once 'conexion.php';
session_start();

// Verificar si el usuario está autenticado
if (!isset($_SESSION['username'])) {
    echo '<script>alert("Usuario no autenticado"); window.history.back();</script>';
    exit();
}

// Obtener el ID del usuario a partir de su nombre de usuario
$username = $_SESSION['username'];
$query = "SELECT id_usuario, cantidad_compras FROM registro WHERE usuario = ?";
$stmt = mysqli_prepare($conexion, $query);
mysqli_stmt_bind_param($stmt, 's', $username);
mysqli_stmt_execute($stmt);
mysqli_stmt_bind_result($stmt, $usuario_id, $cantidad_compras);
mysqli_stmt_fetch($stmt);
mysqli_stmt_close($stmt);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtener los datos del formulario
    $total_compra = isset($_POST['total_compra']) ? floatval($_POST['total_compra']) : 0;

    // Verificar si el monto total de la compra es válido
    if ($total_compra > 0) {
        // Inicializar variables para el descuento y el tipo de cliente
        $descuento = 0;
        $tipo_cliente = 'nuevo';

        // Determinar el tipo de cliente y aplicar el descuento correspondiente
        if ($cantidad_compras >= 10) {
            $descuento = 0.20; // 20% de descuento para clientes permanentes
            $tipo_cliente = 'permanente';
        } elseif ($cantidad_compras >= 5) {
            $descuento = 0.10; // 10% de descuento para clientes intermitentes
            $tipo_cliente = 'intermitente';
        } elseif ($total_compra > 50000) {
            $descuento = 0.05; // 5% de descuento para clientes nuevos con compras superiores a $50,000
            $tipo_cliente = 'nuevo';
        }

        // Calcular el total de la compra después de aplicar el descuento
        $total_con_descuento = $total_compra - ($total_compra * $descuento);

        // Establecer la fecha actual para la compra
        $fecha_compra = date('Y-m-d H:i:s');

        // Iniciar una transacción para mayor seguridad
        mysqli_begin_transaction($conexion);

        try {
            // Insertar los datos de la compra en la tabla `compras`
            $sql = "INSERT INTO compras (id_usuario, total_compra, fecha_compra) VALUES (?, ?, ?)";
            $stmt = mysqli_prepare($conexion, $sql);
            mysqli_stmt_bind_param($stmt, 'ids', $usuario_id, $total_con_descuento, $fecha_compra);
            mysqli_stmt_execute($stmt);

            // Actualizar la cantidad de compras realizadas por el usuario
            $update_query = "UPDATE registro SET cantidad_compras = cantidad_compras + 1 WHERE id_usuario = ?";
            $stmt_update = mysqli_prepare($conexion, $update_query);
            mysqli_stmt_bind_param($stmt_update, 'i', $usuario_id);
            mysqli_stmt_execute($stmt_update);

            // Si todo salió bien, confirmar la transacción
            mysqli_commit($conexion);

            // Mostrar un mensaje de alerta de éxito y regresar atrás
            echo '<script>alert("Compra realizada con éxito."); window.history.back();</script>';

            // Si el cliente es nuevo y la compra es superior a $50,000, redirigir al formulario de registro
            if ($tipo_cliente == 'nuevo' && $total_compra > 50000) {
                echo '<script>window.location.href = "formulario_registro_cliente_nuevo.php";</script>';
            }

        } catch (Exception $e) {
            // Si ocurre un error, revertir la transacción
            mysqli_rollback($conexion);

            // Mostrar un mensaje de alerta de error y regresar atrás
            echo '<script>alert("Error al registrar la compra: ' . addslashes($e->getMessage()) . '"); window.history.back();</script>';
        } finally {
            // Cerrar las declaraciones preparadas
            mysqli_stmt_close($stmt);
            mysqli_stmt_close($stmt_update);

            // Cerrar la conexión a la base de datos
            mysqli_close($conexion);
        }
    } else {
        // Mostrar un mensaje de alerta de error y regresar atrás si el monto total de la compra no es válido
        echo '<script>alert("Selecciona un producto"); window.history.back();</script>';
    }
} else {
    // Mostrar un mensaje de alerta de error y regresar atrás si no se recibió una solicitud POST
    echo '<script>alert("Solicitud inválida."); window.history.back();</script>';
}
?>
