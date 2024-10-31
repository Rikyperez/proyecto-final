<?php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $codigo = $_POST['codigo'];

    $sql = "DELETE FROM inventario WHERE Codigo='$codigo'";

    if ($conn->query($sql) === TRUE) {
        echo "Bien eliminado con éxito";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}
?>