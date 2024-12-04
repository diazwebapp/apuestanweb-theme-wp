
function aw_set_imgs(e){
    var mediaUploader;
    
        let id_html_id = e.getAttribute("target-html-id")
        let element = false;
        if(id_html_id){
            element = document.querySelector(`#${id_html_id}`)
        }
	  // If the uploader object has already been created, reopen the dialog
		if (mediaUploader) {
			mediaUploader.open();
			return;
		}

	  // Extend the wp.media object
	  mediaUploader = wp.media.frames.file_frame = wp.media({
				title: 'Choose Image',
				button: {
				text: 'Choose Image'
			}, multiple: false });

	  // When a file is selected, grab the URL and set it as the text field's value
	  mediaUploader.on('select', function() {
			attachment = mediaUploader.state().get('selection').first().toJSON();
			if(element){
                element.src = attachment.url
                element.classList.remove("d-none")
            }
		});

	  // Open the uploader dialog
	  mediaUploader.open();
        
}

async function generate_base64(element){
    let previus_text = element.textContent
    element.disabled = true
    element.textContent = "generando..."
    let post_id = element.getAttribute("post-id")

    let template = document.getElementById("thumb-template")
    let dataurl = await domtoimage.toPng(template)
    
    let response = await aw_generate_image(dataurl,post_id)
    alert(response.message)
    element.textContent = previus_text
    element.disabled = false
}
// Verificar que wpApiSettings está definido
if (typeof wpApiSettings !== 'undefined') {
    var apiUrl = wpApiSettings.rest_uri;
}
async function aw_generate_image(base64, post_id) {

        // Ejemplo de una solicitud fetch a la REST API
        try {
            let request = await fetch(`${apiUrl}aw-imagen-destacada/generate-apply`, {
                method: "POST",
                body: JSON.stringify({ base64, post_id }),
                headers: {
                    "Content-Type": "application/json",
                    "X-WP-Nonce": wpApiSettings.nonce
                }
            });

            if (!request.ok) {
                throw new Error('Network response was not ok ' + request.statusText);
            }

            let response = await request.json();
            return response;
        } catch (error) {
            console.error('Error:', error);
            alert('Error en rest_api');
        }
    
}
