<?php
// Iniciar la sesión para almacenar los datos del usuario
session_start();

// Conexión a la base de datos
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "registro_usuarios"; // Nombre de tu base de datos

$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Verificar si se envió el formulario de inicio de sesión
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['correo']) && isset($_POST['contraseña'])) {
    $correo = $_POST['correo'];
    $contraseña = $_POST['contraseña'];

    // Consulta para verificar el correo y obtener los datos del usuario
    $sql = "SELECT nombre, apellido, edad, contraseña FROM usuarios WHERE correo = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $correo);
    $stmt->execute();
    $result = $stmt->get_result();

    // Verificar si el usuario existe
    if ($result->num_rows > 0) {
        $usuario = $result->fetch_assoc();

        // Verificar la contraseña
        if (password_verify($contraseña, $usuario['contraseña'])) {
            // Guardar los datos del usuario en variables de sesión
            $_SESSION['nombre'] = $usuario['nombre'];
            $_SESSION['apellido'] = $usuario['apellido'];
            $_SESSION['edad'] = $usuario['edad'];
            $_SESSION['correo'] = $correo;

            // Redirigir a index.html
            header("Location: index.html");
            exit(); // Termina el script para evitar que continúe
        } else {
            echo "Contraseña incorrecta.";
        }
    } else {
        echo "No se encontró ningún usuario con ese correo.";
    }

    $stmt->close();
} else {
    echo "Faltan datos de inicio de sesión.";
}

$conn->close();
?>
