jQuery(function($){
    /* $('body').on('click', '.aw_upload_image_button', function(e){
        e.preventDefault();
  
        var button = $(this),
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
            $('#aw_custom_image').val(attachment.url);
        })
        .open();
    }); */
    
});
function aw_set_imgs(e){
        let id_html_id = e.getAttribute("target-html-id")
        let html_type = e.getAttribute("target-html-attr")
        let element = false;
        if(id_html_id){
            element = document.querySelector(`#${id_html_id}`)
            if(element.tagName == 'DIV'){
                
            }
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
                if(e.tagName == 'DIV'){
                    
                    e.style.backgroundImage = "url('"+attachment.url+"')" //añadimos el src al <img />
                    
                }
                if(e.tagName == 'IMG'){
                    
                    e.src = attachment.url //añadimos el src al <img />
                    
                }
            }
            
        })
        .open();
    }