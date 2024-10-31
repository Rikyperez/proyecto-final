<?php
session_start(); // Iniciar sesión para manejar usuarios

$servername = "localhost";
$username = "tu_usuario"; // Cambia esto
$password = "tu_contraseña"; // Cambia esto
$dbname = "tu_base_de_datos"; // Cambia esto

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Comprobar si el usuario está logueado
if (!isset($_SESSION['usuario_id'])) {
    die("Acceso no autorizado.");
}

$comentario = $_POST['comentario'];
$usuario_id = $_SESSION['usuario_id'];

// Insertar comentario en la base de datos
$sql = "INSERT INTO comentarios (usuario_id, comentario) VALUES ('$usuario_id', '$comentario')";
if ($conn->query($sql) === TRUE) {
    echo "Comentario guardado.";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>
