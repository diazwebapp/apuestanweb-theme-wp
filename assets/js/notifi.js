// Función para realizar la llamada AJAX
function check_vip_forecasts() {

    jQuery.ajax({        
        url: dcms_vars.ajaxurl, // URL generada por WordPress
        type: 'POST',
        data: {
            action: 'get_vip_forecasts_transient', // Nombre de la acción a llamar
        },
        success: function(response) {
            // Procesa la respuesta
            if (response.length) {
                // Si hay publicaciones con la categoría VIP, se muestra una notificación
                show_notification(response);
            } else {
                // Si no hay publicaciones con la categoría VIP, se oculta la notificación
                hide_notification();
            }
        }
    });
}

// Función para mostrar la notificación
function show_notification(forecasts) {
    // Crea el elemento de la notificación
    var notification = document.createElement('div');
    notification.id = 'vip-forecasts-notification';
    notification.innerHTML = 'Hay nuevos pronósticos VIP disponibles!';
    notification.classList.add('vip-forecasts-notification');

    // Agrega la notificación a la página
    document.getElementById("notification-container").appendChild(notification);
}

// Función para ocultar la notificación
function hide_notification() {
    var notification = document.getElementById('vip-forecasts-notification');
    if (notification) {
        notification.remove();
    }
}

// Ejecuta la función para comprobar las publicaciones VIP cada 10 segundos
setInterval(check_vip_forecasts, 10000);
