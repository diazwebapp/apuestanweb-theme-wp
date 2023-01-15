
if (typeof jQuery == 'undefined') {
    console.log('jQuery is not loaded');
} else {
    console.log('jQuery is loaded');

let notificationCount = 0;

function check_vip_forecasts() {

    jQuery.ajax({        
        url: dcms_vars.ajaxurl, // URL generada por WordPress
        type: 'POST',
        data: {
            action: 'get_vip_forecasts_transient_callback', // Nombre de la acción a llamar
        },
        success: function(response) {
            // Procesa la respuesta
            if (response.isVip) {
                // Si hay publicaciones con la categoría VIP, se muestra una notificación
                for (var i = 0; i < response.titles.length; i++) {
                  show_notification(response.titles[i]);
                }
            } else {
                // Si no hay publicaciones con la categoría VIP, se oculta la notificación
                hide_notification();
            }
        },
        error: function(xhr, status, error) {
            console.log(error);
        }
    });
}


// Función para mostrar la notificación
function show_notification(title) {
  var dropdown = document.getElementById("notification-dropdown");
  notificationCount++;
  updateNotificationCount();
  // Crea el elemento de la notificación
  var item = document.createElement('a');
  item.classList.add('dropdown-item');
  item.innerHTML = 'Pick VIP: ' + title;
  item.href = "#";

  // Agrega la notificación al dropdown
  dropdown.appendChild(item);
}

const notificationButton = document.getElementById("notification-button");
const notificationCounter = document.getElementById("notification-counter");

notificationButton.addEventListener("click", function() {
    notificationCounter.innerHTML = 0; // Pasar el contador a cero
    jQuery.ajax({
        url: dcms_vars.ajaxurl,
        type: 'POST',
        data: {
            action: 'mark_notifications_as_read_callback'
        },
        success: function(response) {
            console.log("Notificaciones marcadas como leídas");
        },
        error: function(xhr, status, error) {
            console.log(error);
        }
    });
});

document.getElementById("clear-btn").addEventListener("click", function(){
    jQuery.ajax({
        url: dcms_vars.ajaxurl,
        type: 'POST',
        data: {
            action: 'clear_notifications'
        },
        success: function(response) {
            // vaciar el contenedor de las notificaciones
            document.getElementById("notification-dropdown").innerHTML = "";
            // o ocultar el boton de "clear all"
            document.getElementById("clear-btn").style.display = "none";
        }
    });
});

function hide_notification() {
  var notification = document.getElementById('notification-counter');
  if (notification) {
      notification.remove();
  }

  notificationCount--;
  updateNotificationCount();
}

function updateNotificationCount() {
  document.getElementById("notification-counter").innerHTML = notificationCount;
}



}

document.addEventListener('DOMContentLoaded', check_vip_forecasts);
