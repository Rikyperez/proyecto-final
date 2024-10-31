<?php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $codigo = $_POST['codigo'];
    $nombre = $_POST['nombre'];
    $ubicacion = $_POST['ubicacion'];
    $estado = $_POST['estado'];
    $fuente = $_POST['fuente'];

    $sql = "INSERT INTO inventario (Codigo, NombreActivo, Ubicacion, EstadoFisico, FuenteCompra)
            VALUES ('$codigo', '$nombre', '$ubicacion', '$estado', '$fuente')";

    if ($conn->query($sql) === TRUE) {
        echo "Nuevo bien almacenado con éxito";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}
?>