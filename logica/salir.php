<?php
session_start();
session_destroy();
?>
<script>
    // Redirigir al marco superior a la página de inicio de sesión
    window.top.location.href = '../principal.php';
    // Mostrar un mensaje al usuario
    alert("Has cerrado sesión");
</script>
