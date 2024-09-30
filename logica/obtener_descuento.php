<?php
// Incluir el archivo de conexión a la base de datos
require_once 'conexion.php';
session_start();

// Verificar si el usuario está autenticado
if (!isset($_SESSION['username'])) {
    echo json_encode(['success' => false, 'message' => 'Usuario no autenticado']);
    exit();
}

// Obtener el nombre de usuario de la sesión
$username = $_SESSION['username'];

// Consultar el ID del usuario y la cantidad de compras
$query = "SELECT id_usuario, cantidad_compras FROM registro WHERE usuario = ?";
$stmt = mysqli_prepare($conexion, $query);
mysqli_stmt_bind_param($stmt, 's', $username);
mysqli_stmt_execute($stmt);
mysqli_stmt_bind_result($stmt, $id_usuario, $cantidad_compras);
mysqli_stmt_fetch($stmt);
mysqli_stmt_close($stmt);

// Obtener el monto total de la compra de la solicitud POST
$input = file_get_contents("php://input");
$body = json_decode($input, true);
$monto_total = isset($body['monto_total']) ? floatval($body['monto_total']) : 0;

// Inicializar variables para el descuento y el tipo de cliente
$descuento = 0;
$tipo_cliente = 'nuevo';

// Calcular el descuento y determinar el tipo de cliente
if ($cantidad_compras >= 10) {
    // Cliente permanente con 20% de descuento
    $descuento = 0.20;
    $tipo_cliente = 'permanente';
} elseif ($cantidad_compras >= 5) {
    // Cliente intermitente con 10% de descuento
    $descuento = 0.10;
    $tipo_cliente = 'intermitente';
} elseif ($monto_total > 50000) {
    // Cliente nuevo con compra superior a 50,000 COP: 5% de descuento
    $descuento = 0.05;
    $tipo_cliente = 'nuevo';
} else {
    // Cliente nuevo con compra inferior a 50,000 COP: Sin descuento
    $descuento = 0;
}

// Devolver el tipo de cliente y el descuento en formato JSON
echo json_encode(['success' => true, 'tipo_cliente' => $tipo_cliente, 'descuento' => $descuento]);
?>
