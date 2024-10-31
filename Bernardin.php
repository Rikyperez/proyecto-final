<?php
// Inicia la sesión
session_start();

// Verifica si el usuario está autenticado y tiene un nombre guardado en la sesión
$nombre_usuario = isset($_SESSION['nombre']) ? htmlspecialchars($_SESSION['nombre']) : '';
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>El Preferido de Palermo</title>
    <link rel="stylesheet" href="restaurante.css">
    <style>
        /* Estilo CSS para los comentarios */
        .comment {
            margin: 10px 0; /* Margen superior e inferior */
            padding: 10px; /* Espaciado interno */
            border: 1px solid #ccc; /* Borde para diferenciar los comentarios */
            border-radius: 5px; /* Bordes redondeados */
            background-color: #f9f9f9; /* Color de fondo */
        }
    </style>
</head>
<body>
    <!-- Sección principal -->
    <div class="container">
        <h1>El Preferido de Palermo</h1>

        <table class="reservation-table">
            <tr>
                <td class="image-cell">
                    <img src="El_Preferido_de_Palermo.jfif" alt="El Preferido de Palermo" class="image">
                </td>
                <td class="info-cell">
                    <h2>Descripción</h2>
                    <p class="intro-text">
                        Este es un restaurante emblemático de Buenos Aires que ofrece comida tradicional argentina.
                    </p>
                </td>
            </tr>
        </table>

        <!-- Sección de calificación y comentarios -->
        <div class="comments-container">
            <h2>Calificación</h2>
            <div class="star-image">
                <img src="estrella2.png" alt="Estrella 1" onclick="rate(0)">
                <img src="estrella2.png" alt="Estrella 2" onclick="rate(1)">
                <img src="estrella2.png" alt="Estrella 3" onclick="rate(2)">
                <img src="estrella2.png" alt="Estrella 4" onclick="rate(3)">
                <img src="estrella2.png" alt="Estrella 5" onclick="rate(4)">
            </div>

            <!-- Formulario para enviar comentario -->
            <div class="container">
                <h2>Enviar Comentario</h2>
                <form id="comentarioForm" onsubmit="submitComment(event, 'comentariosPalermo')">
                    <input type="text" name="nombre_usuario" id="nombre_usuario" 
                           value="<?php echo $nombre_usuario; ?>" 
                           placeholder="Tu nombre" style="display: none;"> <!-- Oculta el campo -->
                    <textarea name="comentario" id="comentario" placeholder="Escribe tu comentario" required></textarea>
                    <input type="submit" value="Comentar">
                    <button type="button" onclick="clearComments('comentariosPalermo')">Borrar Comentarios</button>
                    <button type="button" onclick="location.href='index.php'">Regresar</button> <!-- Botón para regresar -->
                </form>
            </div>

            <div id="commentsContainer" class="comments-section"></div>
        </div>

    </div>

    <script>
        let currentRating = 0; // Calificación actual

        function rate(index) {
            currentRating = index + 1; // Guardar la calificación real (de 1 a 5)
            const stars = document.querySelectorAll('.star-image img'); // Obtener todas las imágenes de estrellas
            
            // Actualiza las estrellas visualmente
            stars.forEach((star, i) => {
                star.src = (i < currentRating) ? 'estrella.png' : 'estrella2.png'; // Mostrar estrella llena o vacía
            });
        }

        // Función para enviar el comentario
        function submitComment(event, storageKey) {
            event.preventDefault();

            // Obtener los valores del comentario
            var nombre = document.getElementById("nombre_usuario").value;
            var comentario = document.getElementById("comentario").value;

            // Asegurarse de que hay un comentario y nombre
            if (nombre && comentario) {
                var comentariosGuardados = JSON.parse(localStorage.getItem(storageKey)) || [];

                // Crear el nuevo comentario
                var nuevoComentario = {
                    nombre: nombre,
                    comentario: comentario,
                    rating: currentRating // Añadir la calificación al nuevo comentario
                };

                // Agregar el nuevo comentario a la lista
                comentariosGuardados.push(nuevoComentario);
                localStorage.setItem(storageKey, JSON.stringify(comentariosGuardados));

                // Mostrar los comentarios actualizados
                displayComments(storageKey);
                document.getElementById("comentario").value = ""; // Limpiar el campo de comentario
            } else {
                alert("Por favor, ingresa tu comentario.");
            }
        }

        // Función para mostrar los comentarios guardados
        function displayComments(storageKey) {
            var comentariosGuardados = JSON.parse(localStorage.getItem(storageKey)) || [];
            var commentsContainer = document.getElementById("commentsContainer");
            commentsContainer.innerHTML = ""; // Limpiar contenedor antes de mostrar

            // Mostrar cada comentario en el contenedor
            comentariosGuardados.forEach(function (comentarioObj) {
                var commentDisplay = document.createElement('div');
                commentDisplay.className = 'comment'; // Agrega la clase para aplicar el estilo
                commentDisplay.innerHTML = `<strong>${comentarioObj.nombre}</strong>: ${comentarioObj.comentario} (${comentarioObj.rating} estrellas)`;
                commentsContainer.appendChild(commentDisplay);
            });
        }

        // Función para borrar todos los comentarios
        function clearComments(storageKey) {
            localStorage.removeItem(storageKey);
            document.getElementById("commentsContainer").innerHTML = "";
        }

        // Cargar comentarios al iniciar la página
        document.addEventListener("DOMContentLoaded", function() {
            displayComments('comentariosPalermo'); // Asegúrate de usar la clave correcta aquí
        });
    </script>
</body>
</html>
