<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "Reservaciones";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $codigo = $_POST['codigo'];

    // Verificar si el código existe en la base de datos
    $sql = "SELECT * FROM Reservaciones WHERE codigo = '$codigo'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Si el código existe, redirigir al formulario de modificación
        header("Location: modificar_reserva.php?codigo=$codigo");
        exit();
    } else {
        // Si el código no existe, mostrar un mensaje de error
        echo "No hay ninguna reserva con este código.";
    }
}

$conn->close();
?>
