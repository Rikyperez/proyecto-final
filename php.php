<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "Reservaciones";

// Conexión
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Enlace al archivo CSS
echo '<link rel="stylesheet" type="text/css" href="css-php.css">';

// Función para generar código único de 4 dígitos
function generarCodigoUnico($conn) {
    do {
        // Generar un código aleatorio de 4 dígitos
        $codigo = rand(1000, 9999);

        // Verificar si el código ya existe en la base de datos
        $sql = "SELECT codigo FROM Reservaciones WHERE codigo = $codigo";
        $result = $conn->query($sql);
    } while ($result->num_rows > 0); // Repetir hasta que se genere un código único

    return $codigo;
}

// Procesar la acción de reservar
$accion = isset($_POST['accion']) ? $_POST['accion'] : '';

if ($accion == 'reservar') {
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $correo = $_POST['correo'];
    $fecha = $_POST['fecha'];
    $hora = $_POST['hora'];
    $cantidad_personas = $_POST['cantidad_personas'];

    // Seleccionar mesa disponible según la cantidad de personas
    $sql = "SELECT id FROM Mesas WHERE capacidad >= $cantidad_personas AND disponible = TRUE LIMIT 1";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $mesa_id = $row['id'];

        // Generar un código único de reservación
        $codigoUnico = generarCodigoUnico($conn);

        // Insertar la reservación con el código generado
        $sql = "INSERT INTO Reservaciones (nombre, apellido, correo, fecha_reservacion, hora_reservacion, cantidad_personas, mesa_asignada, codigo)
                VALUES ('$nombre', '$apellido', '$correo', '$fecha', '$hora', $cantidad_personas, $mesa_id, $codigoUnico)";

        if ($conn->query($sql) === TRUE) {
            // Actualizar disponibilidad de la mesa
            $sql = "UPDATE Mesas SET disponible = FALSE WHERE id = $mesa_id";
            $conn->query($sql);

            // Mostrar el código único generado
            echo "
            <div class='container'>
                <h1>Reservación exitosa!</h1>
                <p>Su código único de reservación es:</p>
                <p class='codigo'>$codigoUnico</p>
                <p>Por favor, guarde este código para futuras consultas.</p>
            </div>";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    } else {
        echo "No hay mesas disponibles para esa cantidad de personas.";
    }
}

$conn->close();
?>
