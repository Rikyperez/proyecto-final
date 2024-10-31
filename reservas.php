<?php
include 'db.php'; // Asegúrate de que este archivo contiene la conexión a la base de datos

// Consulta para obtener las reservaciones
$stmt = $pdo->prepare("SELECT id, nombre, apellido, correo, fecha_reservacion, hora_reservacion, cantidad_personas, mesa_asignada, codigo 
                        FROM reservaciones
                        WHERE DATE(fecha_reservacion) = CURDATE()"); // Filtrar por las reservas del día
$stmt->execute();
$reservas = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reservas del Día</title>
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

        .table {
            margin-top: 20px;
        }
    </style>
</head>
<body>

<div class="container mt-4">
    <h2 class="text-center">Reservas del Día</h2>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>ID Reserva</th>
                <th>Nombre</th>
                <th>Apellido</th>
                <th>Correo</th>
                <th>Fecha</th>
                <th>Hora</th>
                <th>Número de Personas</th>
                <th>Mesa Asignada</th>
                <th>Código</th>
            </tr>
        </thead>
        <tbody>
            <?php if (count($reservas) > 0): ?>
                <?php foreach ($reservas as $reserva): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($reserva['id'] ?? 'N/A'); ?></td>
                        <td><?php echo htmlspecialchars($reserva['nombre'] ?? 'N/A'); ?></td>
                        <td><?php echo htmlspecialchars($reserva['apellido'] ?? 'N/A'); ?></td>
                        <td><?php echo htmlspecialchars($reserva['correo'] ?? 'N/A'); ?></td>
                        <td><?php echo date('Y-m-d', strtotime($reserva['fecha_reservacion'])); ?></td>
                        <td><?php echo htmlspecialchars($reserva['hora_reservacion'] ?? 'N/A'); ?></td>
                        <td><?php echo htmlspecialchars($reserva['cantidad_personas'] ?? 'N/A'); ?></td>
                        <td><?php echo htmlspecialchars($reserva['mesa_asignada'] ?? 'N/A'); ?></td>
                        <td><?php echo htmlspecialchars($reserva['codigo'] ?? 'N/A'); ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="9" class="text-center">No hay reservas disponibles.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
    <a href="inicio.html" class="btn btn-secondary">Regresar</a>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.0.7/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
