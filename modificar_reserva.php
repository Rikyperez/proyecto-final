<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "Reservaciones";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

$codigo = $_GET['codigo'];

// Obtener los datos actuales de la reservación
$sql = "SELECT * FROM Reservaciones WHERE codigo = '$codigo'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $fecha = $row['fecha_reservacion'];
    $hora = $row['hora_reservacion'];
    $cantidad_personas = $row['cantidad_personas'];
} else {
    echo "Error: No se encontró la reserva.";
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recoger los datos modificados
    $nueva_fecha = $_POST['fecha'];
    $nueva_hora = $_POST['hora'];
    $nueva_cantidad_personas = $_POST['cantidad_personas'];

    // Actualizar la base de datos
    $sql = "UPDATE Reservaciones 
            SET fecha_reservacion = '$nueva_fecha', hora_reservacion = '$nueva_hora', cantidad_personas = $nueva_cantidad_personas 
            WHERE codigo = '$codigo'";

    if ($conn->query($sql) === TRUE) {
        echo "Reservación actualizada exitosamente.";
    } else {
        echo "Error al actualizar la reservación: " . $conn->error;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modificar Reservación</title>
    <link rel="stylesheet" href="estilos.css">

    <style>
        form { margin: 20px; }
        input { margin: 5px; }
    </style>
</head>
<body>
    <br>
    <br>
    <br>
    <h1>Modificar Reservación</h1>
    <form action="" method="post">
        <label for="fecha">Nueva Fecha de Reservación:</label><br>
        <input type="date" id="fecha" name="fecha" value="<?php echo $fecha; ?>" required><br>
        
        <label for="hora">Nueva Hora de Reservación:</label><br>
        <input type="time" id="hora" name="hora" value="<?php echo $hora; ?>" required><br>
        
        <label for="cantidad_personas">Nueva Cantidad de Personas:</label><br>
        <input type="number" id="cantidad_personas" name="cantidad_personas" value="<?php echo $cantidad_personas; ?>" required><br><br>
        
        <button type="submit">Guardar Cambios</button>
    </form>
</body>
</html>
