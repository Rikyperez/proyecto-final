<?php
// Conexión a la base de datos
$host = 'localhost'; // o la IP de tu servidor
$user = 'root'; // nombre de usuario de MySQL
$password = ''; // contraseña de MySQL
$dbname = 'registro_usuarios';

$conn = new mysqli($host, $user, $password, $dbname);

if ($conn->connect_error) {
    die("Error en la conexión: " . $conn->connect_error);
}

// Obtener los datos del formulario
$correo = $_POST['correo'];
$contraseña = $_POST['contraseña'];

// Consulta para obtener el usuario
$sql = "SELECT * FROM usuarios WHERE correo = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $correo);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $usuario = $result->fetch_assoc();
    // Verificar la contraseña
    if (password_verify($contraseña, $usuario['contraseña'])) {
        // Redirigir a index.html
        header("Location: index.php");
        exit(); // Termina el script después de redirigir
    } else {
        echo "Contraseña incorrecta.";
    }
} else {
    echo "No se encontró ningún usuario con ese correo.";
}

$stmt->close();
$conn->close();
?>
