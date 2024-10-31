<?php
// Conexión a la base de datos
$servername = "localhost";
$username = "tu_usuario"; // Cambia esto
$password = "tu_contraseña"; // Cambia esto
$dbname = "mi_base_de_datos"; // Cambia esto

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

$sql = "SELECT nombre_usuario, comentario, reg_date FROM comentarios ORDER BY reg_date DESC";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        echo "<div class='comment'>";
        echo "<strong>" . htmlspecialchars($row["nombre_usuario"]) . "</strong>: " . htmlspecialchars($row["comentario"]);
        echo "<br><em>" . $row["reg_date"] . "</em>";
        echo "</div>";
    }
} else {
    echo "No hay comentarios.";
}

$conn->close();
?>
