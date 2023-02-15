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
function generate_base64(element){
    let base64 = document.querySelector("#base64")
    let previus_text = element.textContent
    element.disabled = true
    element.textContent = "generando..."
    jQuery(function($){
    
       html2canvas($("#imagen-destacada-personalizada")[0]).then(function (canvas) {
            base64.value = canvas.toDataURL('image/png'); //o por 'image/jpeg' 
            element.textContent = previus_text
            element.disabled = false
        })

    });

}