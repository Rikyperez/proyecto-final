<?php
include 'db.php';

function asignarMesa($numero_personas) {
    global $pdo;
    $stmt = $pdo->prepare("SELECT mesa_asignada FROM Mesas WHERE estado = 'disponible' AND capacidad >= ? LIMIT 1");
    $stmt->execute([$numero_personas]);
    return $stmt->fetchColumn();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $correo = $_POST['correo'];
    $fecha_reservacion = $_POST['fecha_reservacion'];
    $hora_reservacion = $_POST['hora_reservacion'];
    $cantidad_personas = $_POST['cantidad_personas'];
    $codigo = $_POST['codigo'];

    $mesa_asignada = asignarMesa($cantidad_personas);

    if ($mesa_asignada) {
        $stmt = $pdo->prepare("INSERT INTO reservaciones (nombre, apellido, correo, fecha_reservacion, hora_reservacion, cantidad_personas, mesa_asignada, codigo) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([$nombre, $apellido, $correo, $fecha_reservacion, $hora_reservacion, $cantidad_personas, $mesa_asignada, $codigo]);

        // Actualizar el estado de la mesa
        $pdo->prepare("UPDATE Mesas SET estado = 'reservada' WHERE mesa_asignada = ?")->execute([$mesa_asignada]);

        echo "<div class='alert alert-success'>Reservación creada con éxito. Mesa asignada: $mesa_asignada.</div>";
    } else {
        echo "<div class='alert alert-danger'>No hay mesas disponibles para esa cantidad de personas.</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nueva Reservación</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #2bf382;
        }
        .container {
            margin-top: 30px;
        }
        h2 {
            text-align: center;
        }
        .alert {
            margin-top: 20px;
        }
    </style>
</head>
<body>

<div class="container mt-4">
    <h2 class="text-center">Nueva Reservación</h2>
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
            <label for="codigo">Código de Reservación:</label>
            <input type="text" class="form-control" name="codigo" required>
        </div>
        <button type="submit" class="btn btn-primary">Reservar</button>
        <a href="inicio.html" class="btn btn-secondary">Regresar</a>
    </form>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="cdn.jsdelivr.net/npm/@popperjs/core@2.0.7/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
