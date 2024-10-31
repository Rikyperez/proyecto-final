// Función de búsqueda de restaurantes
function searchRestaurants() {
    const input = document.getElementById('searchInput').value.toLowerCase();
    const restaurants = document.getElementsByClassName('restaurant');
    let found = false;

    for (let restaurant of restaurants) {
        const restaurantName = restaurant.innerText.toLowerCase();
        restaurant.style.display = restaurantName.includes(input) ? 'block' : 'none';
        if (restaurant.style.display === 'block') found = true;
    }

    // Mensaje si no se encuentran resultados
    document.getElementById('noResults').style.display = found ? 'none' : 'block';
}

// Manejo de la calificación con estrellas
let currentRating = 0;

function rate(index) {
    currentRating = index + 1; // Guardar la calificación real (de 1 a 5)
    updateStarImages(); // Actualiza las imágenes de las estrellas
}

// Actualiza las imágenes de las estrellas
function updateStarImages() {
    const stars = document.querySelectorAll('.star-image img');
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

    const comentario = document.getElementById('comentario').value;

    // Almacena el comentario en localStorage
    let comentarios = JSON.parse(localStorage.getItem('comentarios')) || [];
    comentarios.push({ nombre: 'Usuario', comentario, estrellas: currentRating }); // Usar 'Usuario' como nombre predeterminado
    localStorage.setItem('comentarios', JSON.stringify(comentarios));

    // Limpia el formulario y reinicia la calificación
    this.reset();
    rate(-1); // Reiniciar estrellas

    // Carga los comentarios actualizados
    loadComments();
});

// Función para cargar y mostrar los comentarios
function loadComments() {
    const comentarios = JSON.parse(localStorage.getItem('comentarios')) || [];
    const commentsContainer = document.getElementById('commentsContainer');
    commentsContainer.innerHTML = ''; // Limpia el contenedor

    comentarios.forEach((c) => {
        const div = document.createElement('div');
        div.innerHTML = `<strong>${c.nombre}</strong>: ${c.comentario} (${c.estrellas} estrellas)`;
        commentsContainer.appendChild(div);
    });
}

// Función para borrar todos los comentarios
function clearComments() {
    localStorage.removeItem('comentarios'); // Eliminar los comentarios del localStorage
    loadComments(); // Cargar comentarios actualizados (vacío)
}

// Llama a loadComments y updateStarImages al cargar la página
document.addEventListener('DOMContentLoaded', () => {
    loadComments();
    updateStarImages(); // Asegúrate de que las estrellas se muestren correctamente
});

// Asignar el evento al botón de borrar
document.getElementById('clearButton').addEventListener('click', clearComments);
