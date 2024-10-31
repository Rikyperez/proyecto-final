<?php
include 'db.php';

$mensaje = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $reserva_id = $_POST['reserva_id'];
    $accion = $_POST['accion'];

    if ($accion == 'cancelar') {
        // Actualizar el estado de la reserva a 'cancelada'
        $stmt = $pdo->prepare("UPDATE reservaciones SET estado = 'cancelada' WHERE id = ?");
        $stmt->execute([$reserva_id]);
        $mensaje = "Reserva cancelada.";
    } elseif ($accion == 'modificar') {
        $fecha_reservacion = $_POST['fecha_reservacion'];
        $hora_reservacion = $_POST['hora_reservacion'];
        $cantidad_personas = $_POST['cantidad_personas'];

        // Cambiar la reserva
        $stmt = $pdo->prepare("UPDATE reservaciones SET fecha_reservacion = ?, hora_reservacion = ?, cantidad_personas = ?, estado = 'modificada' WHERE id = ?");
        $stmt->execute([$fecha_reservacion, $hora_reservacion, $cantidad_personas, $reserva_id]);
        $mensaje = "Reserva modificada.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modificar o Cancelar Reserva</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #2bf382; /* Color de fondo verde */
        }

        .container {
            margin-top: 30px; /* Espacio superior para el contenedor */
            padding: 20px; /* Espaciado interno */
            background-color: #4666f6; /* Color de fondo del contenedor */
            border-radius: 8px; /* Bordes redondeados */
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1); /* Sombra */
        }

        h2 {
            text-align: center; /* Centrar el título */
            color: #ffff; /* Color del texto del título */
        }

        div {
            color: #ffff; /* Color del texto de los divs */
        }

        .alert {
            margin-top: 20px; /* Espacio superior para las alertas */
        }

        .form-group label {
            font-weight: bold; /* Texto en negrita para etiquetas */
        }

        .btn {
            margin: 5px; /* Margen para botones */
        }
    </style>
</head>
<body>

<div class="container mt-4">
    <h2 class="text-center">Modificar o Cancelar Reserva</h2>
    
    <?php if ($mensaje): ?>
        <div class="alert alert-info"><?php echo $mensaje; ?></div>
    <?php endif; ?>

    <form method="POST">
        <div class="form-group">
            <label for="reserva_id">ID Reserva:</label>
            <input type="number" class="form-control" name="reserva_id" required>
        </div>
        <div class="form-group">
            <label for="accion">Acción:</label>
            <select class="form-control" name="accion" required>
                <option value="modificar">Modificar</option>
                <option value="cancelar">Cancelar</option>
            </select>
        </div>
        <div class="form-group">
            <label for="fecha_reservacion">Nueva Fecha:</label>
            <input type="date" class="form-control" name="fecha_reservacion">
        </div>
        <div class="form-group">
            <label for="hora_reservacion">Nueva Hora:</label>
            <input type="time" class="form-control" name="hora_reservacion">
        </div>
        <div class="form-group">
            <label for="cantidad_personas">Nuevo Número de Personas:</label>
            <input type="number" class="form-control" name="cantidad_personas" min="1">
        </div>
        <button type="submit" class="btn btn-primary">Ejecutar</button>
        <a href="inicio.html" class="btn btn-secondary">Regresar</a>
    </form>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.0.7/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
