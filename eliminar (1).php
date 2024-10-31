<?php
// Iniciar la sesión (si es necesario)
session_start();

// Incluir el archivo de conexión a la base de datos
include 'conexion.php'; // Asegúrate de tener un archivo de conexión adecuado

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $codigo = $_POST['codigo']; // Obtener el código de reserva enviado

    // Consulta para verificar si el código existe y obtener la mesa asociada
    $consulta = $conn->prepare("SELECT id_mesa FROM reservas WHERE codigo = ?");
    $consulta->bind_param("s", $codigo); // Asegúrate de que el tipo sea el correcto
    $consulta->execute();
    $resultado = $consulta->get_result();

    // Verifica si se encontró alguna reserva con el código
    if ($resultado->num_rows > 0) {
        // Obtener el id_mesa de la reserva
        $fila = $resultado->fetch_assoc();
        $id_mesa = $fila['id_mesa'];

        // Eliminar la reserva
        $eliminar = $conn->prepare("DELETE FROM reservas WHERE codigo = ?");
        $eliminar->bind_param("s", $codigo);
        if ($eliminar->execute()) {
            // Actualizar la mesa como disponible (disponible = 1)
            $actualizar_mesa = $conn->prepare("UPDATE Mesas SET disponible = 1 WHERE id = ?");
            $actualizar_mesa->bind_param("i", $id_mesa); // El ID de la mesa
            if ($actualizar_mesa->execute()) {
                echo "Reserva eliminada y mesa $id_mesa marcada como disponible.";
            } else {
                echo "Error al actualizar la mesa: " . $conn->error;
            }
        } else {
            echo "Error al eliminar la reserva: " . $conn->error;
        }
    } else {
        // No se encontró ninguna reserva con ese código
        echo "No hay ninguna reserva con este código.";
    }

    // Cerrar las conexiones
    $consulta->close();
    $eliminar->close();
    $actualizar_mesa->close();
    $conn->close();
}
?>
