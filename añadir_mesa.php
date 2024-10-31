<?php
// Incluir el archivo de conexión a la base de datos
include 'db.php';

// Variable para almacenar mensajes de éxito o error
$mensaje = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Recibir los valores del formulario
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $correo = $_POST['correo'];
    $fecha_reservacion = $_POST['fecha_reservacion'];
    $hora_reservacion = $_POST['hora_reservacion'];
    $cantidad_personas = $_POST['cantidad_personas'];
    $mesa_asignada = $_POST['mesa_asignada'];
    $codigo = $_POST['codigo'];

    // Preparar la consulta SQL para insertar una nueva reservación
    $stmt = $pdo->prepare("INSERT INTO reservaciones (nombre, apellido, correo, fecha_reservacion, hora_reservacion, cantidad_personas, mesa_asignada, codigo) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    
    // Ejecutar la consulta y mostrar el mensaje correspondiente
    if ($stmt->execute([$nombre, $apellido, $correo, $fecha_reservacion, $hora_reservacion, $cantidad_personas, $mesa_asignada, $codigo])) {
        $mensaje = "Reservación añadida con éxito.";
    } else {
        $mensaje = "Error al añadir la reservación.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Añadir Reservación</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-4">
    <h2 class="text-center">Añadir Reservación</h2>

    <!-- Mostrar el mensaje de éxito o error -->
    <?php if ($mensaje): ?>
        <div class="alert alert-info"><?php echo $mensaje; ?></div>
    <?php endif; ?>

    <!-- Formulario para añadir una nueva reservación -->
    <form method="POST">
        <div class="form-group">
            <label for="nombre">Nombre:</label>
            <input type="text" class="form-control" name="nombre" required>
        </div>
        <div class="form-group">
            <label for="apellido">Apellido:</label>
            <input type="text" class="form-control" name="apellido" required>
        </div>
        <div class="form-group">
            <label for="correo">Correo:</label>
            <input type="email" class="form-control" name="correo" required>
        </div>
        <div class="form-group">
            <label for="fecha_reservacion">Fecha de Reservación:</label>
            <input type="date" class="form-control" name="fecha_reservacion" required>
        </div>
        <div class="form-group">
            <label for="hora_reservacion">Hora de Reservación:</label>
            <input type="time" class="form-control" name="hora_reservacion" required>
        </div>
        <div class="form-group">
            <label for="cantidad_personas">Cantidad de Personas:</label>
            <input type="number" class="form-control" name="cantidad_personas" required>
        </div>
        <div class="form-group">
            <label for="mesa_asignada">Mesa Asignada:</label>
            <input type="number" class="form-control" name="mesa_asignada" required>
        </div>
        <div class="form-group">
            <label for="codigo">Código:</label>
            <input type="text" class="form-control" name="codigo" required>
        </div>
        <!-- Botón para enviar el formulario -->
        <button type="submit" class="btn btn-primary">Añadir Reservación</button>
        <!-- Botón para regresar al inicio -->
        <a href="index.php" class="btn btn-secondary">Regresar</a>
    </form>
</div>

<!-- Enlace a las librerías de Bootstrap y jQuery -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.0.7/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
