<?php
// Define la clave correcta
$clave_correcta = "24112005";

// Verifica si el formulario ha sido enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtiene la clave ingresada por el usuario
    $clave_ingresada = trim($_POST['clave']);

    // Compara la clave ingresada con la clave correcta
    if ($clave_ingresada === $clave_correcta) {
        // Redirige a inicio.html si la clave es correcta
        header("Location: tabla-de-registrosh.php");
        exit();
    } else {
        // Mensaje de error si la clave es incorrecta
        $error = "Clave errónea. Inténtelo de nuevo.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verificación de Clave</title>
</head>
<body>
    <h2>Ingrese la Clave de Entrada</h2>

    <!-- Muestra el mensaje de error si la clave es incorrecta -->
    <?php if (isset($error)) { ?>
        <p style="color: red;"><?php echo htmlspecialchars($error); ?></p>
    <?php } ?>

    <!-- Formulario para ingresar la clave -->
    <form action="" method="POST">
        <label for="clave">Digite la clave de entrada:</label>
        <input type="password" id="clave" name="clave" required>
        <button type="submit">Ingresar</button>
    </form>

    <!-- Botón de regreso -->
    <form action="index.php" method="GET" style="margin-top: 10px;">
        <button type="submit">Regresar</button>
    </form>
</body>
</html>
