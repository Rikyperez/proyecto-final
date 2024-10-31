<?php
// Configuración de la conexión a la base de datos
$host = 'localhost';
$db = 'reservaciones'; // Nombre de la base de datos igual a la tabla
$user = 'root'; // Cambia si tu usuario es diferente
$pass = ''; // Cambia si tienes una contraseña

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Error de conexión: " . $e->getMessage();
    exit;
}

// Prepara la consulta para obtener todas las reservaciones
$stmt = $pdo->prepare("SELECT id, nombre, apellido, correo, fecha_reservacion, hora_reservacion, cantidad_personas, mesa_asignada, codigo 
                        FROM reservaciones");
$stmt->execute();
$reservas = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reservas</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .container {
            margin-top: 30px;
        }
        h2 {
            text-align: center;
        }
    </style>
</head>
<body>

<div class="container">
    <h2 class="text-center">Reservas</h2>
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
                        <td><?php echo htmlspecialchars($reserva['id']); ?></td>
                        <td><?php echo htmlspecialchars($reserva['nombre']); ?></td>
                        <td><?php echo htmlspecialchars($reserva['apellido']); ?></td>
                        <td><?php echo htmlspecialchars($reserva['correo']); ?></td>
                        <td><?php echo date('Y-m-d', strtotime($reserva['fecha_reservacion'])); ?></td>
                        <td><?php echo htmlspecialchars($reserva['hora_reservacion']); ?></td>
                        <td><?php echo htmlspecialchars($reserva['cantidad_personas']); ?></td>
                        <td><?php echo htmlspecialchars($reserva['mesa_asignada']); ?></td>
                        <td><?php echo htmlspecialchars($reserva['codigo']); ?></td>
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
