<?php
include 'db.php';

$sql = "SELECT * FROM inventario";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "<table border='1'>
    <tr>
    <th>Código</th>
    <th>Nombre del Activo</th>
    <th>Ubicación</th>
    <th>Estado Físico</th>
    <th>Fuente de Compra</th>
    </tr>";

    while($row = $result->fetch_assoc()) {
        echo "<tr>
        <td>" . $row["Codigo"] . "</td>
        <td>" . $row["NombreActivo"] . "</td>
        <td>" . $row["Ubicacion"] . "</td>
        <td>" . $row["EstadoFisico"] . "</td>
        <td>" . $row["FuenteCompra"] . "</td>
        </tr>";
    }

    echo "</table>";
} else {
    echo "0 resultados";
}
$conn->close();
?>