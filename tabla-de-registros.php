<?php
// Configuración de la conexión a la base de datos
$host = 'localhost';
$db = 'reservaciones'; // Nombre de la base de datos
$user = 'root'; // Cambia si tu usuario es diferente
$pass = ''; // Cambia si tienes una contraseña

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Error de conexión: " . $e->getMessage();
    exit;
}

// Función para guardar todas las reservas en el historial
function guardarReservasEnHistorial($pdo) {
    // Obtener todas las reservas actuales
    $stmt = $pdo->prepare("SELECT * FROM reservaciones");
    $stmt->execute();
    $reservas = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($reservas as $reserva) {
        // Guardar en el historial
        $stmtHistorial = $pdo->prepare("INSERT INTO historial_reservas (nombre, apellido, correo, fecha_reservacion, 
                                        hora_reservacion, cantidad_personas, mesa_asignada, codigo, estado) 
                                        VALUES (:nombre, :apellido, :correo, :fecha_reservacion, 
                                        :hora_reservacion, :cantidad_personas, :mesa_asignada, :codigo, :estado)");

        // Marcar todas las reservas como "actual" al guardarlas en el historial
        $stmtHistorial->execute(array_merge($reserva, ['estado' => 'actual']));
    }

    echo "Todas las reservas han sido guardadas en el historial.";
}

// Llamar a la función para guardar reservas en el historial
guardarReservasEnHistorial($pdo);
?>
