<?php
// Iniciar la sesión
session_start();

// Incluir el archivo de conexión a la base de datos
include 'conexion (1).php'; // Asegúrate de tener un archivo de conexión adecuado

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $codigo = $_POST['codigo']; // Obtener el código de reserva enviado

    // Consulta para verificar si el código existe en la tabla 'reservaciones'
    $consulta = $conn->prepare("SELECT * FROM reservaciones WHERE codigo = ?");
    
    if (!$consulta) {
        die("Error en la consulta: " . $conn->error); // Detectar si la consulta no se preparó correctamente
    }
    
    $consulta->bind_param("s", $codigo);
    $consulta->execute();
    $resultado = $consulta->get_result();

    // Verifica si se encontró alguna reserva con el código
    if ($resultado->num_rows > 0) {
        // Código existe, obtenemos la información de la mesa asignada
        $fila = $resultado->fetch_assoc();
        $mesa_id = $fila['mesa_asignada']; // Usamos 'mesa_asignada' en lugar de 'id_mesa'

        // Eliminar la reservación
        $eliminar = $conn->prepare("DELETE FROM reservaciones WHERE codigo = ?");
        
        if (!$eliminar) {
            die("Error en la eliminación: " . $conn->error); // Detectar si la consulta no se preparó correctamente
        }
        
        $eliminar->bind_param("s", $codigo);
        
        if ($eliminar->execute()) {
            // Actualizar el estado de la mesa a disponible (1) en la tabla 'mesas'
            $actualizarEstado = $conn->prepare("UPDATE mesas SET disponible = 1 WHERE id = ?");
            
            if (!$actualizarEstado) {
                die("Error al actualizar el estado de disponibilidad: " . $conn->error); // Detectar si la consulta no se preparó correctamente
            }

            $actualizarEstado->bind_param("i", $mesa_id); // Se usa el ID de la mesa para actualizar
            $actualizarEstado->execute();
            $actualizarEstado->close();

            echo "Reserva eliminada.";
        } else {
            echo "Error al eliminar la reserva: " . $eliminar->error;
        }
        
        // Cerrar la declaración de eliminación
        $eliminar->close();
    } else {
        // No se encontró ninguna reserva con ese código
        echo "No hay ninguna reserva con este código.";
    }

    // Cerrar la declaración de consulta
    $consulta->close();
}

// Cerrar la conexión
$conn->close();

echo '<link rel="stylesheet" type="text/css" href="css-eliminar.css">';
?>
