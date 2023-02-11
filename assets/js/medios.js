jQuery(function($){
    
});
function aw_set_imgs(e){
        let id_html_id = e.getAttribute("target-html-id")
        let html_type = e.getAttribute("target-html-attr")
        
        let element = false;
        if(id_html_id){
            element = document.querySelector(`#${id_html_id}`)
        }
        
        aw_uploader = wp.media({
            title: 'Custom image',
            library: {
                uploadedTo: wp.media.view.settings.post.id,
                type: 'image'
            },
            button: {
                text: 'Use this image'
            },
            multiple: false
        }).on('select', function() {
            var attachment = aw_uploader.state().get('selection').first().toJSON();
            if(element){
                if(element.tagName == 'DIV'){
                    
                    element.style.backgroundImage = "url('"+attachment.url+"')" //añadimos el src al <img />
                    
                }
                
            }else{
                if(e.tagName == 'IMG'){
                    
                    e.src = attachment.url //añadimos el src al <img />
                    
                    
                }
            }
            
        })
        .open();
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