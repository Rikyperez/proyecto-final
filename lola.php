<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "Reservaciones";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Consulta de mesas disponibles
$sql = "SELECT id, capacidad FROM Mesas WHERE disponible = TRUE";
$result = $conn->query($sql);

// CSS dentro de PHP para ajustarlo
echo "
<style>
   body {
    font-family: 'Arial', sans-serif;
    background-color: #1c1f2b; /* Fondo oscuro para buen contraste */
    color: #f0c94d; /* Color dorado para el texto */
    margin: 0;
    padding: 0;
}

.container {
    width: 90%;
    max-width: 1000px;
    margin: 20px auto;
    background-color: #2b2f3e; /* Fondo oscuro para el contenedor */
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0px 0px 15px rgba(0, 0, 0, 0.5); /* Sombra para darle profundidad */
}

h1 {
    text-align: center;
    font-size: 2.5em; /* Tamaño de fuente aumentado para más impacto */
    color: #f0c94d; /* Dorado para el título */
    margin-bottom: 20px;
}

.table-wrapper {
    display: flex;
    flex-wrap: wrap;
    justify-content: space-between;
}

table {
    width: 48%;
    margin-bottom: 20px;
    border-collapse: collapse;
    background-color: #3b3f52; /* Fondo oscuro para las tablas */
}

table, th, td {
    border: 1px solid #f0c94d; /* Borde dorado */
}

th, td {
    padding: 10px;
    text-align: center;
}

th {
    background-color: #f0c94d; /* Fondo dorado para los encabezados */
    color: #1c1f2b; /* Texto oscuro en los encabezados */
}

td {
    background-color: #4b4f66; /* Color de fondo más claro para las celdas */
    color: #ffffff; /* Texto blanco para mejor contraste */
}

@media screen and (max-width: 768px) {
    table {
        width: 100%; /* Ajustar las tablas a pantalla completa en dispositivos pequeños */
    }
}

</style>
";

// Mostrar mesas en dos columnas
if ($result && $result->num_rows > 0) {
    echo "<div class='container'>
            <h1>Mesas Disponibles</h1>
            <div class='table-wrapper'>";

    // Mostrar primera mitad de mesas
    echo "<table>
            <tr>
                <th>ID</th>
                <th>Capacidad</th>
            </tr>";

    $counter = 0;
    $total = $result->num_rows;
    while ($row = $result->fetch_assoc()) {
        $counter++;
        if ($counter <= ceil($total / 2)) {
            echo "<tr>
                    <td>{$row['id']}</td>
                    <td>{$row['capacidad']}</td>
                  </tr>";
        }
    }
    echo "</table>";

    // Volver a empezar el resultado para mostrar la segunda mitad
    $result->data_seek(ceil($total / 2));

    // Mostrar segunda mitad de mesas
    echo "<table>
            <tr>
                <th>ID</th>
                <th>Capacidad</th>
            </tr>";
    while ($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>{$row['id']}</td>
                <td>{$row['capacidad']}</td>
              </tr>";
    }

    echo "</table>
          </div>
          </div>";
} else {
    echo "<div class='container'><h1>No hay mesas disponibles</h1></div>";
}

$conn->close();
?>
