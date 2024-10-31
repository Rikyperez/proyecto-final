<?php
session_start();
include 'conexion.php'; // Asegúrate de incluir tu archivo de conexión

if (isset($_SESSION['correo'])) {
    $correo = $_SESSION['correo'];

    // Consulta para obtener los datos del usuario
    $query = "SELECT * FROM Usuarios WHERE correo = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $correo);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $usuario = $result->fetch_assoc();
        $nombre = $usuario['nombre'];
        $edad = $usuario['edad'];
        $foto = $usuario['foto'];
    } else {
        echo "Usuario no encontrado.";
    }
} else {
    echo "Inicie sesión para ver su perfil.";
}
?>
