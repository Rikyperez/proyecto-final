<?php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $codigo = $_POST['codigo'];
    $nombre = $_POST['nombre'];
    $ubicacion = $_POST['ubicacion'];
    $estado = $_POST['estado'];
    $fuente = $_POST['fuente'];

    $sql = "UPDATE inventario 
            SET NombreActivo='$nombre', Ubicacion='$ubicacion', EstadoFisico='$estado', FuenteCompra='$fuente' 
            WHERE Codigo='$codigo'";

    if ($conn->query($sql) === TRUE) {
        echo "Bien modificado con éxito";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}
?>