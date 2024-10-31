// Función de búsqueda de restaurantes
function searchRestaurants() {
    const input = document.getElementById('searchInput').value.toLowerCase(); // Obtener el texto de búsqueda
    const restaurants = document.getElementsByClassName('restaurant'); // Obtener todos los elementos de restaurantes
    let found = false; // Variable para verificar si se encontró algún restaurante

    // Iterar sobre todos los restaurantes
    for (let restaurant of restaurants) {
        const restaurantName = restaurant.innerText.toLowerCase(); // Nombre del restaurante en minúsculas
        restaurant.style.display = restaurantName.includes(input) ? 'block' : 'none'; // Mostrar o esconder el restaurante
        if (restaurant.style.display === 'block') found = true; // Verificar si se encontró algún restaurante
    }

    // Mensaje si no se encuentran resultados
    document.getElementById('noResults').style.display = found ? 'none' : 'block'; // Mostrar u ocultar mensaje de no resultados
}

let currentRating = 0; // Calificación actual

// Función para calificar un restaurante
function rate(index) {
    currentRating = index + 1; // Guardar la calificación real (de 1 a 5)
    const stars = document.querySelectorAll('.star-image img'); // Obtener todas las imágenes de estrellas

    // Actualiza las estrellas visualmente
    stars.forEach((star, i) => {
        star.src = (i < currentRating) ? 'estrella.png' : 'estrella2.png'; // Mostrar estrella llena si el índice es menor a la calificación
    });
}

// Asignar el evento 'click' a las estrellas
document.querySelectorAll('.star-image img').forEach((star, index) => {
    star.addEventListener('click', () => rate(index)); // Cuando se hace clic en una estrella, se actualiza la calificación
});

// Función para enviar comentario
document.getElementById('comentarioForm').addEventListener('submit', function(e) {
    e.preventDefault(); // Evita el envío normal del formulario

    const nombre = document.getElementById('nombre_usuario').value; // Obtener el nombre del usuario
    const comentario = document.getElementById('comentario').value; // Obtener el comentario

    // Almacena el comentario en localStorage
    let comentarios = JSON.parse(localStorage.getItem('comentarios')) || []; // Obtener los comentarios existentes o inicializar un array vacío
    comentarios.push({ nombre, comentario, estrellas: currentRating }); // Agregar el nuevo comentario
    localStorage.setItem('comentarios', JSON.stringify(comentarios)); // Guardar los comentarios en localStorage

    // Limpia el formulario y reinicia la calificación
    this.reset(); // Reiniciar el formulario
    rate(-1); // Reiniciar estrellas

    // Carga los comentarios actualizados
    loadComments();
});

// Función para cargar y mostrar los comentarios
function loadComments() {
    const comentarios = JSON.parse(localStorage.getItem('comentarios')) || []; // Obtener comentarios del localStorage
    const commentsContainer = document.getElementById('commentsContainer'); // Obtener contenedor de comentarios
    commentsContainer.innerHTML = ''; // Limpiar el contenedor

    // Iterar sobre los comentarios y mostrarlos
    comentarios.forEach((c) => {
        const div = document.createElement('div'); // Crear un nuevo div para cada comentario
        div.className = 'comment-box'; // Añadir clase para el cuadro
        div.innerHTML = `<strong>${c.nombre}</strong>: ${c.comentario} (${c.estrellas} estrellas)`; // Formato del comentario
        commentsContainer.appendChild(div); // Agregar el comentario al contenedor
    });
}

// Función para borrar todos los comentarios
function clearComments() {
    localStorage.removeItem('comentarios'); // Eliminar los comentarios del localStorage
    loadComments(); // Cargar comentarios actualizados (vacío)
}

// Llama a loadComments al cargar la página
document.addEventListener('DOMContentLoaded', () => {
    loadComments(); // Cargar comentarios al cargar la página

    // Asignar el evento al botón de borrar
    document.getElementById('clearButton').addEventListener('click', clearComments); // Evento para el botón de borrar
});
