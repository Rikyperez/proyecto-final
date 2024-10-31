<?php
session_start(); // Inicia la sesión

// Destruir la sesión
session_destroy();

// Redirigir a bienvenida.html
header("Location: bienvenida.html");
exit(); // Termina el script
?>
