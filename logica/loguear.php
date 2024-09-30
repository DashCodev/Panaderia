<?php

require 'conexion.php';
session_start();

$usuario = $_POST['usuario'];
$contraseña = $_POST['contraseña'];

// Consulta a la base de datos para verificar el usuario y la contraseña
$q = "SELECT id_usuario FROM registro WHERE usuario = ? AND contraseña = ?";
$stmt = mysqli_prepare($conexion, $q);
mysqli_stmt_bind_param($stmt, 'ss', $usuario, $contraseña);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$usuarioData = mysqli_fetch_assoc($result);

if ($usuarioData) {
    // Usuario y contraseña correctos
    $_SESSION['id_usuario'] = $usuarioData['id_usuario']; // Guardar el id_usuario en la sesión
    $_SESSION['username'] = $usuario; // Guardar el nombre de usuario en la sesión

    // Mostrar mensaje de éxito y redirigir a la página principal
    echo "<script>
        alert('Has iniciado sesión correctamente.');
        window.location.href = '../principal.php'; // Redirigir a la página principal
    </script>";
} else {
    // Usuario o contraseña incorrectos
    echo "<script>
        alert('Datos incorrectos. Por favor, inténtelo de nuevo.');
        window.location.href = '../login.html'; // Redirigir a la página de inicio de sesión
    </script>";
}

// Cerrar la conexión y declaración preparada
mysqli_stmt_close($stmt);
mysqli_close($conexion);

?>
