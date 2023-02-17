jQuery(function($){

	
		
});
function aw_set_imgs(e){
    var mediaUploader;
    
        let id_html_id = e.getAttribute("target-html-id")
        let html_type = e.getAttribute("target-html-attr")
        
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
                if(element.tagName == 'DIV'){
                    element.style.backgroundImage = "url('"+attachment.url+"')" //añadimos el src al <img />
                }
                
            }else{
                if(e.tagName == 'IMG'){                    
                    e.src = attachment.url //añadimos el src al <img />
                }
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
    
    jQuery(async function($){
        let canvas = await html2canvas($("#imagen-destacada-personalizada")[0])
        let code = canvas.toDataURL('image/png');
        let response = await aw_generate_image(code,post_id)
        alert(response.message)
        element.textContent = previus_text
        element.disabled = false
    });

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