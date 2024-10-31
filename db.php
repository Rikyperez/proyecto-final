<?php
$host = 'localhost'; // Dirección del servidor MySQL
$db = 'reservaciones'; // Nombre de la base de datos
$user = 'root'; // Nombre de usuario de MySQL
$pass = ''; // Contraseña de MySQL

try {
    // Crear una instancia de PDO para la conexión a la base de datos
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8", $user, $pass);
    // Configurar PDO para que lance excepciones en caso de errores
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    // Manejar el error de conexión
    echo "Error de conexión: " . $e->getMessage();
}
?>
