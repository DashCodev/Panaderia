<?php
// Habilitar la visualización de errores
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Verificar si se han enviado datos del formulario
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['registro'])) {
    // Incluir el archivo de conexión
    include('logica/conexion.php');

    // Recibir datos del formulario
    $nombre = $_POST['nombre'];
    $usuario = $_POST['usuario'];
    $contraseña = $_POST['contraseña'];

    // Preparar la consulta SQL para insertar los datos en la tabla de registro
    $sql = "INSERT INTO registro (nombre, usuario, contraseña) VALUES ('$nombre', '$usuario', '$contraseña')";

    // Ejecutar la consulta y verificar si fue exitosa
    if (mysqli_query($conexion, $sql)) {
        // Registro exitoso, mostrar mensaje de alerta y redirigir a login.html
        echo "<script>
                alert('Te has registrado correctamente');
                window.location.href = 'login.html';
              </script>";
        exit(); // Detener la ejecución del script después de redirigir
    } else {
        // Si hay un error, mostrar mensaje de error
        echo "Error: " . $sql . "<br>" . mysqli_error($conexion);
    }

    // Cerrar la conexión
    mysqli_close($conexion);
}
?>
