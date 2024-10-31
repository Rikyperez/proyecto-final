<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Restaurantes</title>
    <link rel="stylesheet" href="index.css">
</head>
<body>

<div class="container">
    <div class="profile-container">
        <h2>Perfil de Usuario</h2>

        <div id="userProfile">
            <?php
            session_start(); // Inicia la sesión

            // Conexión a la base de datos
            $host = 'localhost'; // o la IP de tu servidor
            $user = 'root'; // nombre de usuario de MySQL
            $password = ''; // contraseña de MySQL
            $dbname = 'registro_usuarios';

            $conn = new mysqli($host, $user, $password, $dbname);

            if ($conn->connect_error) {
                die("Error en la conexión: " . $conn->connect_error);
            }

            // Verificar si el usuario ya está autenticado
            if (isset($_SESSION['nombre'])) {
                // Mostrar la información del usuario
                echo "<p><strong>Nombre:</strong> " . htmlspecialchars($_SESSION['nombre']) . "</p>";
                echo "<p><strong>Apellido:</strong> " . htmlspecialchars($_SESSION['apellido']) . "</p>";
                echo "<p><strong>Edad:</strong> " . htmlspecialchars($_SESSION['edad']) . "</p>";
                
                // Botones de acción
                echo '<form method="post" action="cerrar_sesion.php" style="display:inline;">
                        <input type="submit" value="Cerrar Sesión">
                      </form>';

                // Agregar el nombre a la sesión para los comentarios
                $_SESSION['nombre_usuario'] = htmlspecialchars($_SESSION['nombre']); // Almacena el nombre en la sesión
            } else {
                // Mensaje para el usuario si no ha iniciado sesión
                echo "<p>Por favor inicia sesión para acceder a tu perfil.</p>";
                echo '<form action="bienvenida.html">
                        <input type="submit" value="Iniciar Sesión">
                      </form>';
            }

            // Verificar si se enviaron los datos del formulario
            if (isset($_POST['correo']) && isset($_POST['contraseña'])) {
                // Obtener los datos del formulario
                $correo = $_POST['correo'];
                $contraseña = $_POST['contraseña'];

                // Consulta para obtener el usuario
                $sql = "SELECT * FROM usuarios WHERE correo = ?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("s", $correo);
                $stmt->execute();
                $result = $stmt->get_result();

                if ($result->num_rows > 0) {
                    $usuario = $result->fetch_assoc();
                    // Verificar la contraseña
                    if (password_verify($contraseña, $usuario['contraseña'])) {
                        // Almacenar datos del usuario en la variable de sesión
                        $_SESSION['nombre'] = htmlspecialchars($usuario['nombre']);
                        $_SESSION['apellido'] = htmlspecialchars($usuario['apellido']);
                        $_SESSION['edad'] = htmlspecialchars($usuario['edad']);
                        $_SESSION['nombre_usuario'] = htmlspecialchars($usuario['nombre']); // Almacena el nombre en la sesión
                        // Redirigir a la misma página para mostrar el perfil
                        header("Location: index.php");
                        exit();
                    } else {
                        // Redirigir a contra_mala.php si la contraseña es incorrecta
                        header("Location: contra_mala.php");
                        exit(); // Termina el script después de redirigir
                    }
                } else {
                    // Redirigir a no_usuario.php si no se encuentra el usuario
                    header("Location: no_usuario.php");
                    exit(); // Termina el script después de redirigir
                }

                $stmt->close();
            }

            $conn->close();
            ?>
        </div>

        <div class="comments-container">
            <h2>Calificación</h2>
            <div class="star-image">
                <img src="estrella2.png" onclick="rate(1)" alt="1 estrella">
                <img src="estrella2.png" onclick="rate(2)" alt="2 estrellas">
                <img src="estrella2.png" onclick="rate(3)" alt="3 estrellas">
                <img src="estrella2.png" onclick="rate(4)" alt="4 estrellas">
                <img src="estrella2.png" onclick="rate(5)" alt="5 estrellas">
            </div>

            <form id="comentarioForm" onsubmit="return submitComment();">
                <input type="hidden" name="nombre_usuario" id="nombre_usuario" value="<?php echo isset($_SESSION['nombre_usuario']) ? htmlspecialchars($_SESSION['nombre_usuario']) : ''; ?>">
                <textarea name="comentario" id="comentario" placeholder="Escribe tu comentario" required></textarea>
                <input type="submit" value="Comentar">
                <button type="button" onclick="clearComments()">Borrar Comentarios</button>
            </form>
            <div id="commentsContainer"></div> <!-- Contenedor para los comentarios -->
        </div>
    </div>

    <div>  <!-- Contenido principal de la página -->
        <div class="main-content">
            <h1 class="center-text">Búsqueda de Restaurantes</h1>
            <div id="searchContainer">
                <input type="text" id="searchInput" onkeyup="searchRestaurants()" placeholder="Buscar restaurante...">
            </div>
            
            <div id="noResults" style="display:none;">No se encontraron resultados.</div>
           
            <div class="restaurant-container" id="restaurantContainer">
                <ul>
                    <li class="restaurant">
                        <img src="El_Preferido_de_Palermo.jfif" alt="El Preferido de Palermo" class="restaurant-image">
                        <a href="El_Preferido_de_Palermo.php">El Preferido de Palermo (Buenos Aires)</a>
                    </li>
                    <li class="restaurant">
                        <img src="Tegui.jfif" alt="Tegui" class="restaurant-image">
                        <a href="Tegui.php">Tegui (Buenos Aires)</a>
                    </li>
                    <li class="restaurant">
                        <img src="El_Pobre_Luis.jfif" alt="El Pobre Luis" class="restaurant-image">
                        <a href="El_Pobre_Luis.php">El Pobre Luis (Buenos Aires)</a>
                    </li>
                    <li class="restaurant">
                        <img src="Fogo_de_chao.jfif" alt="Fogo de Chão" class="restaurant-image">
                        <a href="Fogo_de_chao.php">Fogo de Chão (São Paulo)</a>
                    </li>
                    <li class="restaurant">
                        <img src="Oro.jfif" alt="Oro" class="restaurant-image">
                        <a href="Oro.php">Oro (Río de Janeiro)</a>
                    </li>
                    <li class="restaurant">
                        <img src="D.O.M..jfif" alt="D.O.M." class="restaurant-image">
                        <a href="D.O.M..php">D.O.M. (São Paulo)</a>
                    </li>
                    <li class="restaurant">
                        <img src="Mani.jfif" alt="Maní" class="restaurant-image">
                        <a href="Mani.php">Maní (São Paulo)</a>
                    </li>
                    <li class="restaurant">
                        <img src="Joe_beef.jfif" alt="Joe Beef" class="restaurant-image">
                        <a href="Joe_beef.php">Joe Beef (Montreal)</a>
                    </li>
                    <li class="restaurant">
                        <img src="Alo_Restaurant.jfif" alt="Alo Restaurant" class="restaurant-image">
                        <a href="Alo_Restaurant.php">Alo Restaurant (Toronto)</a>
                    </li>
                    <li class="restaurant">
                        <img src="Langdon_Hall.jfif" alt="Langdon Hall" class="restaurant-image">
                        <a href="Langdon_Hall.php">Langdon Hall (Cambridge)</a>
                    </li>
                    <li class="restaurant">
                        <img src="Buca.jfif" alt="Buca" class="restaurant-image">
                        <a href="Buca.php">Buca (Toronto)</a>
                    </li>

                    <li class="restaurant">
                        <img src="Borago.jfif" alt="Boragó" class="restaurant-image">
                        <a href="Borago.php">Boragó (Santiago)</a>
                    </li>
                    <li class="restaurant">
                <img src="Castillo_Forestal.jfif" alt="Castillo Forestal" class="restaurant-image">
                <a href="Castillo_Forestal.php">Castillo Forestal (Santiago)</a>
            </li>
            <li class="restaurant">
                <img src="La_Mar.jfif" alt="La Mar" class="restaurant-image">
                <a href="La_Mar.php">La Mar (Santiago)</a>
            </li>
            <li class="restaurant">
                <img src="Pergolas_de_las_Flores.jfif" alt="Pérgola de las Flores" class="restaurant-image">
                <a href="Pergolas_de_las_Flores.php">Pérgola de las Flores (Santiago)</a>
            </li>

            <li class="restaurant">
                <img src="Carne_de_Res.jfif" alt="Andrés Carne de Res" class="restaurant-image">
                <a href="Carne_de_Res.php">Andrés Carne de Res (Chía)</a>
            </li>
            <li class="restaurant">
                <img src="Leo.jfif" alt="Leo" class="restaurant-image">
                <a href="Leo.php">Leo (Bogotá)</a>
            </li>
            <li class="restaurant">
                <img src="Harry_Sasson.jfif" alt="Harry Sasson" class="restaurant-image">
                <a href="Harry_Sasson.php">Harry Sasson (Bogotá)</a>
            </li>
            <li class="restaurant">
                <img src="El_Cielo.jfif" alt="El Cielo" class="restaurant-image">
                <a href="El_Cielo.php">El Cielo (Medellín)</a>
            </li>

            <li class="restaurant">
                <img src="La_Guarida.jfif" alt="La Guarida" class="restaurant-image">
                <a href="La_Guarida.php">La Guarida (La Habana)</a>
            </li>
            <li class="restaurant">
                <img src="Paladar_Los_Marcaderes.jfif" alt="Paladar Los Mercaderes" class="restaurant-image">
                <a href="Paladar_Los_Mercaderes.php">Paladar Los Mercaderes (La Habana)</a>
            </li>
            <li class="restaurant">
                <img src="El_Cocinero.jfif" alt="El Cocinero" class="restaurant-image">
                <a href="El_Cocinero.php">El Cocinero (La Habana)</a>
            </li>
            <li class="restaurant">
                <img src="San_Cristobal_Paladar.jfif" alt="San Cristóbal Paladar" class="restaurant-image">
                <a href="San_Cristobal_Paladar.php">San Cristóbal Paladar (La Habana)</a>
            </li>
            <li class="restaurant">
                <img src="La_Casa.jfif" alt="La Casa" class="restaurant-image">
                <a href="La_Casa.php">La Casa (La Habana)</a>
            </li>
            <li class="restaurant">
                <img src="Abou_El_Sid.jfif" alt="Abou El Sid" class="restaurant-image">
                <a href="Abou_El_Sid.php">Abou El Sid (El Cairo)</a>
            </li>
            <li class="restaurant">
                <img src="Sequoia.jfif" alt="Sequoia" class="restaurant-image">
                <a href="Sequoia.php">Sequoia (El Cairo)</a>
            </li>
            <li class="restaurant">
                <img src="Felfela.jfif" alt="Felfela" class="restaurant-image">
                <a href="Felfela.php">Felfela (El Cairo)</a>
            </li>
            <li class="restaurant">
                <img src="Zooba.jfif" alt="Zooba" class="restaurant-image">
                <a href="Zooba.php">Zooba (El Cairo)</a>
            </li>
            <li class="restaurant">
                <img src="Fishawi's_Cafe.jfif" alt="Fishawi's Café" class="restaurant-image">
                <a href="Fishawi's_Cafe.php">Fishawi's Café (El Cairo)</a>
            </li>
            <li class="restaurant">
                <img src="La_Pampa.jfif" alt="La Pampa" class="restaurant-image">
                <a href="La_Pampa.php">La Pampa (San Salvador)</a>
            </li>
            <li class="restaurant">
                <img src="El_Zocalo.jfif" alt="El Zocalo" class="restaurant-image">
                <a href="El_Zocalo.php">El Zocalo (San Salvador)</a>
            </li>
            <li class="restaurant">
                <img src="EL_bodegon.jfif" alt="El Bodegón" class="restaurant-image">
                <a href="El_bodegon.php">El Bodegón (San Salvador)</a>
            </li>
        
            <li class="restaurant">
                <img src="La_Hola.jfif" alt="La Hola" class="restaurant-image">
                <a href="La_Hola.php">La Hola (San Salvador)</a>
            </li>

            <li class="restaurant">
                <img src="Arzak.jfif" alt="Arzak" class="restaurant-image">
                <a href="Arzak.php">Arzak (San Sebastián)</a>
            </li>

            <li class="restaurant">
                <img src="DiverXO.jfif" alt="DiverXO" class="restaurant-image">
                <a href="DiverXO.php">DiverXO (Madrid)</a>
            </li>
            <li class="restaurant">
                <img src="Calima.jfif" alt="Calima" class="restaurant-image">
                <a href="Calima.php">Calima (Marbella)</a>
            </li>
            <li class="restaurant">
                <img src="Eleven_Madison_Park.jfif" alt="Eleven Madison Park" class="restaurant-image">
                <a href="Eleven_Madison_Park.php">Eleven Madison Park (Nueva York)</a>
            </li>

        </div>



    <!-- Botones para Consultar y Registrar -->
    <div class="action-buttons">
        <form action="cosultar_clave.php">
            <input type="submit" value="Consultar Registro">
        </form>
    </div>

</div>

<script src="script_1.js"></script>
</body>
</html>
