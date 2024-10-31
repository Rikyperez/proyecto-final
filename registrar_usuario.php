<?php
// Conexión a la base de datos
$host = 'localhost'; // o la IP de tu servidor
$user = 'root'; // nombre de usuario de MySQL
$password = ''; // contraseña de MySQL
$dbname = 'registro_usuarios';

// Crear una nueva conexión a la base de datos
$conn = new mysqli($host, $user, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Error en la conexión: " . $conn->connect_error);
}

// Obtener los datos del formulario y sanitizar entradas
$nombre = trim($_POST['nombre']);
$apellido = trim($_POST['apellido']);
$edad = intval($_POST['edad']);
$correo = trim($_POST['correo']);
$contraseña = password_hash(trim($_POST['contraseña']), PASSWORD_DEFAULT); // Hash de la contraseña

// Validar datos
if (!filter_var($correo, FILTER_VALIDATE_EMAIL)) {
    mostrarError("Correo electrónico no válido.");
}
if ($edad <= 0) {
    mostrarError("La edad debe ser un número positivo.");
}

// Preparar la consulta SQL
$stmt = $conn->prepare("INSERT INTO usuarios (nombre, apellido, edad, correo, contraseña) VALUES (?, ?, ?, ?, ?)");
$stmt->bind_param("ssiss", $nombre, $apellido, $edad, $correo, $contraseña); // "ssiss" significa: string, string, int, string, string

// Ejecutar la consulta
if ($stmt->execute()) {
    // Redirigir a index.html después de un registro exitoso
    header("Location: bienvenida.html");
    exit(); // Termina el script después de redirigir
} else {
    mostrarError("Error al registrar el usuario: " . $stmt->error);
}

// Función para mostrar error
function mostrarError($mensaje) {
    echo "
    <!DOCTYPE html>
    <html lang='es'>
    <head>
        <meta charset='UTF-8'>
        <meta name='viewport' content='width=device-width, initial-scale=1.0'>
        <title>Error de Registro</title>
        <link rel='stylesheet' href='css_de_registro.css'>
    </head>
    <body>
        <h1>Error</h1>
        <p>$mensaje</p>
        <a href='bienvenida.html'>
            <button>Regresar</button>
        </a>
    </body>
    </html>
    ";
    exit(); // Termina el script después de mostrar el error
}

// Cerrar la conexión
$stmt->close();
$conn->close();
?>
