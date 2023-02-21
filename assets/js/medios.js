jQuery(function($){

	
		
});
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

    let plantilla = document.getElementById("plantilla")
    let equipo1 = document.getElementById("equipo-1")
    let equipo2 = document.getElementById("equipo-2")
   
    var canvas = document.createElement("canvas");
    canvas.width = plantilla.getAttribute("width")
    canvas.height = plantilla.getAttribute("height")
    var ctx = canvas.getContext("2d");
    
    ctx.drawImage(plantilla, 0, 0);    
    ctx.drawImage(equipo1,153,150, equipo1.offsetWidth,equipo1.offsetHeight);
    ctx.drawImage(equipo2,516,150, equipo1.offsetWidth,equipo1.offsetHeight);
    
    let dataurl = canvas.toDataURL()
    
    let response = await aw_generate_image(dataurl,post_id)
    alert(response.message)
    element.textContent = previus_text
    element.disabled = false
}

async function aw_generate_image(base64,post_id){    
    let request = await fetch("/wp-json/aw-imagen-destacada/generate-apply",{
        method:"post",
        body: JSON.stringify({base64,post_id}),
        headers:{
            "Content-type": "application/json"
        }
    })
    let response = await request.json()
    return response
    
}