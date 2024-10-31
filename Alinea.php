<?php
// Bloque de inicio de sesión
session_start();

// Verifica si el usuario está autenticado y obtiene el nombre del usuario desde $_SESSION
$nombre_usuario = isset($_SESSION['nombre']) ? htmlspecialchars($_SESSION['nombre']) : '';
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alinea</title>

    <!-- Conexión con el archivo CSS externo para estilos generales -->
    <link rel="stylesheet" href="restaurante1.css">

    <!-- Estilo CSS para los comentarios en línea -->
    <style>
        .comment {
            margin: 10px 0;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            background-color: #f9f9f9;
        }
    </style>
</head>

<body>
    <!-- Botón para regresar a 'index.php' -->
    <button type="button" onclick="location.href='index.php'">Regresar</button>

    <!-- Sección principal -->
    <div class="container">
        <h1>Alinea</h1>

        <!-- Tabla con imagen del restaurante y descripción -->
        <table class="reservation-table">
            <tr>
                <td class="image-cell">
                    <!-- Imagen del restaurante -->
                    <img src="Alinea.jfif" alt="Alinea" class="image">
                </td>
                <td class="info-cell">
                    <h2>Descripción</h2>
                    <p class="intro-text">
                        Alinea es un restaurante de Chicago que ofrece una experiencia culinaria innovadora, fusionando técnicas modernas y sabores sorprendentes en un ambiente elegante y contemporáneo.
                    </p>

                    <!-- Botón para ir a formulario.html -->
                    <button type="button" onclick="location.href='formulario.html'">Reservar Mesa</button>
                </td>
            </tr>
        </table>

        <!-- Bloque de calificación y comentarios -->
        <div class="comments-container">
            <h2>Calificación</h2>
            <div class="star-image">
                <!-- Imágenes de estrellas para seleccionar la calificación (5 estrellas) -->
                <img src="estrella2.png" alt="Estrella 1" onclick="rate(0)">
                <img src="estrella2.png" alt="Estrella 2" onclick="rate(1)">
                <img src="estrella2.png" alt="Estrella 3" onclick="rate(2)">
                <img src="estrella2.png" alt="Estrella 4" onclick="rate(3)">
                <img src="estrella2.png" alt="Estrella 5" onclick="rate(4)">

                <h2>Enviar Comentario</h2>
                <form id="comentarioForm" onsubmit="submitComment(event, 'comentariosAlinea')">
                    <input type="text" name="nombre_usuario" id="nombre_usuario" 
                           value="<?php echo $nombre_usuario; ?>" 
                           placeholder="Tu nombre" style="display: none;">
                    <textarea name="comentario" id="comentario" placeholder="Escribe tu comentario" required></textarea>
                    <input type="submit" value="Comentar">
                    <button type="button" onclick="clearComments('comentariosAlinea')">Borrar Comentarios</button>
                </form>
            </div>

            <!-- Contenedor para mostrar los comentarios guardados -->
            <div id="commentsContainer" class="comments-section"></div>
        </div>
    </div>

    <!-- JavaScript para funciones de calificación, envío y visualización de comentarios -->
    <script>
       let currentRating = 0;

       function rate(index) {
           currentRating = index + 1;
           const stars = document.querySelectorAll('.star-image img');
           stars.forEach((star, i) => {
               star.src = (i < currentRating) ? 'estrella.png' : 'estrella2.png';
           });
       }

       function submitComment(event, storageKey) {
           event.preventDefault();
           var nombre = document.getElementById("nombre_usuario").value;
           var comentario = document.getElementById("comentario").value;

           if (nombre && comentario) {
               var comentariosGuardados = JSON.parse(localStorage.getItem(storageKey)) || [];
               var nuevoComentario = {
                   nombre: nombre,
                   comentario: comentario,
                   rating: currentRating
               };

               comentariosGuardados.push(nuevoComentario);
               localStorage.setItem(storageKey, JSON.stringify(comentariosGuardados));
               displayComments(storageKey);
               document.getElementById("comentario").value = "";
               resetStars();
           } else {
               alert("Por favor, ingresa tu comentario.");
           }
       }

       function displayComments(storageKey) {
           var comentariosGuardados = JSON.parse(localStorage.getItem(storageKey)) || [];
           var commentsContainer = document.getElementById("commentsContainer");
           commentsContainer.innerHTML = "";

           comentariosGuardados.forEach(function (comentarioObj) {
               var commentDisplay = document.createElement('div');
               commentDisplay.className = 'comment';
               commentDisplay.innerHTML = `<strong>${comentarioObj.nombre}</strong>: ${comentarioObj.comentario} (${comentarioObj.rating} estrellas)`;
               commentsContainer.appendChild(commentDisplay);
           });
       }

       function clearComments(storageKey) {
           localStorage.removeItem(storageKey);
           document.getElementById("commentsContainer").innerHTML = "";
       }

       function resetStars() {
           currentRating = 0;
           const stars = document.querySelectorAll('.star-image img');
           stars.forEach((star) => {
               star.src = 'estrella2.png';
           });
       }

       document.addEventListener("DOMContentLoaded", function() {
           displayComments('comentariosAlinea');
       });
    </script>
</body>
</html>
