let currentRating = 0; // Calificación actual

function rate(index) {
    currentRating = index + 1; // Guardar la calificación real (de 1 a 5)
    const stars = document.querySelectorAll('.star-image img'); // Obtener todas las imágenes de estrellas
    
    // Actualiza las estrellas visualmente
    stars.forEach((star, i) => {
        if (i < currentRating) {
            star.src = 'estrella.png'; // Mostrar estrella llena si el índice es menor o igual a la calificación actual
        } else {
            star.src = 'estrella2.png'; // Mostrar estrella vacía si el índice es mayor a la calificación actual
        }
    });
}

// Asignar el evento 'click' a las estrellas
document.querySelectorAll('.star-image img').forEach((star, index) => {
    star.addEventListener('click', () => rate(index)); // Cuando se hace clic en una estrella, se actualiza la calificación
});


// Función para enviar el comentario
function submitComment(event, storageKey) {
    // Evita el envío del formulario
    event.preventDefault();

    // Obtener los valores del comentario
    var nombre = document.getElementById("nombre_usuario").value;
    var comentario = document.getElementById("comentario").value;

    // Asegurarse de que hay un comentario y nombre
    if (nombre && comentario) {
        // Obtener los comentarios anteriores del localStorage usando la clave específica del restaurante
        var comentariosGuardados = JSON.parse(localStorage.getItem(storageKey)) || [];

        // Crear el nuevo comentario
        var nuevoComentario = {
            nombre: nombre,
            comentario: comentario
        };

        // Agregar el nuevo comentario a la lista
        comentariosGuardados.push(nuevoComentario);

        // Guardar la lista actualizada en localStorage
        localStorage.setItem(storageKey, JSON.stringify(comentariosGuardados));

        // Mostrar los comentarios actualizados
        displayComments(storageKey);

        // Limpiar el campo de comentario
        document.getElementById("comentario").value = "";
    } else {
        alert("Por favor, ingresa tu comentario.");
    }
}

// Función para mostrar los comentarios guardados
function displayComments(storageKey) {
    // Obtener los comentarios guardados del localStorage
    var comentariosGuardados = JSON.parse(localStorage.getItem(storageKey)) || [];

    // Contenedor donde se mostrarán los comentarios
    var commentsContainer = document.getElementById("commentsContainer");
    commentsContainer.innerHTML = ""; // Limpiar contenedor antes de mostrar

    // Mostrar cada comentario en el contenedor
    comentariosGuardados.forEach(function (comentarioObj) {
        var commentDisplay = document.createElement('div');
        commentDisplay.innerHTML = `<strong>${comentarioObj.nombre}</strong>: ${comentarioObj.comentario}`;
        commentsContainer.appendChild(commentDisplay);
    });
}

// Función para borrar todos los comentarios
function clearComments(storageKey) {
    // Limpiar el localStorage para la clave específica del restaurante
    localStorage.removeItem(storageKey);

    // Limpiar el contenedor de comentarios visualmente
    document.getElementById("commentsContainer").innerHTML = "";
}

// Cargar comentarios al iniciar la página
document.addEventListener("DOMContentLoaded", function() {
    displayComments('comentariosPalermo'); // Asegúrate de usar la clave correcta aquí
});
