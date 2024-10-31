<?php
// Conexión a la base de datos
$servername = "localhost";
$username = "tu_usuario"; // Cambia esto
$password = "tu_contraseña"; // Cambia esto
$dbname = "mi_base_de_datos"; // Cambia esto

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre_usuario = $_POST['nombre_usuario'];
    $comentario = $_POST['comentario'];
    $reg_date = date('Y-m-d H:i:s'); // Fecha actual

    $stmt = $conn->prepare("INSERT INTO comentarios (nombre_usuario, comentario, reg_date) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $nombre_usuario, $comentario, $reg_date);

    if ($stmt->execute()) {
        echo "Comentario guardado exitosamente.";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();

// Redireccionar de nuevo a la página de comentarios
header("Location: comentarios.html");
exit();
?>
