document.addEventListener('DOMContentLoaded', function () {
    // Obtén elementos DOM
    var openModalBtn = document.getElementById('open-search-modal');
    var closeModalBtn = document.getElementById('close-search-modal');
    var modal = document.getElementById('search-modal');

    // Abrir la ventana modal al hacer clic en el icono de búsqueda
    openModalBtn.addEventListener('click', function () {
        modal.style.display = 'block';
    });

    // Cerrar la ventana modal al hacer clic en el botón de cierre
    closeModalBtn.addEventListener('click', function () {
        modal.style.display = 'none';
    });

    // Cerrar la ventana modal al hacer clic fuera de ella
    window.addEventListener('click', function (event) {
        if (event.target === modal) {
            modal.style.display = 'none';
        }
    });

    // Captura el evento keyup en el campo de búsqueda
    $('#search').on('keyup', function () {
        // Obtén el valor del campo de búsqueda
        var search_query = $(this).val();

        // Realiza la solicitud AJAX solo si hay al menos 3 caracteres
        if (search_query.length >= 3) {
            // Realiza la solicitud AJAX
            $.ajax({
                type: 'POST',
                url: frontendajax.url,
                data: {
                    action: 'custom_search',
                    search_query: search_query,
                },
                success: function (response) {
                    response = JSON.parse(response);

                    if (response.success) {
                        // Muestra los resultados en la ventana modal
                        $('#search-results').html(response.results);
                    } else {
                        // Muestra un mensaje de error si no hay resultados
                        $('#search-results').html(response.message);
                    }
                },
            });
        } else {
            // Si el campo de búsqueda tiene menos de 3 caracteres, vacía los resultados
            $('#search-results').html('');
        }
    });
    // Evitar que se envíe el formulario al presionar Enter
    $('#search-modal').on('keydown', '#search', function (e) {
        if (e.key === 'Enter') {
            e.preventDefault(); // Previene el envío del formulario
            // Puedes agregar aquí más lógica si es necesario
        }
    });
});
