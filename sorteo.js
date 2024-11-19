document.addEventListener('DOMContentLoaded', function() {
    let numeros = Array.from({length: 20}, (_, i) => i + 1);
    let reservas = window.sorteoReservas || {};

    // Mostrar los números disponibles
    let numerosDiv = document.getElementById('numeros-disponibles');
    numeros.forEach(numero => {
        let numeroDiv = document.createElement('div');
        numeroDiv.textContent = numero;
        numeroDiv.id = `numero-${numero}`;
        numerosDiv.appendChild(numeroDiv);
    });

    document.getElementById('sorteo-form').addEventListener('submit', function(event) {
        event.preventDefault();
        
        let nombre = document.getElementById('nombre').value;
        let telefono = document.getElementById('telefono').value;
        let participarBtn = document.getElementById('participar-btn');
        let loading = document.getElementById('loading');
        let resultado = document.getElementById('resultado');
        let numeroElemento = document.getElementById('numero-aleatorio');

        participarBtn.disabled = true;
        loading.classList.remove('hidden');
        resultado.classList.add('hidden');

        jQuery.ajax({
            url: ajaxurl,
            type: 'POST',
            data: {
                action: 'procesar_sorteo',
                nombre: nombre,
                telefono: telefono,
                reservas: JSON.stringify(reservas)
            },
            success: function(response) {
                if (response.success) {
                    let numeroAsignado = response.data.numero_asignado;
                    
                    numeroElemento.textContent = numeroAsignado;
                    resultado.classList.remove('hidden');

                    // Marcar el número como tachado
                    let numeroDiv = document.getElementById(`numero-${numeroAsignado}`);
                    numeroDiv.classList.add('numero-tachado');
                }

                loading.classList.add('hidden');
                participarBtn.disabled = false;
            },
            error: function() {
                alert('Error al procesar la solicitud.');
                loading.classList.add('hidden');
                participarBtn.disabled = false;
            }
        });
    });
});
