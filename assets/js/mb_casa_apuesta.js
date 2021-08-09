// aw_rest_api_settigns variable que viene de php
window.addEventListener('load',()=>{
    //logica metabox casa apuesta
    const select_logo_casa_apuesta = document.getElementById('btn_lca')
    const btn_m_pago_1 = document.getElementById('m_p_icon_1')
    const btn_m_pago_2 = document.getElementById('m_p_icon_2')
    const btn_m_pago_3 = document.getElementById('m_p_icon_3')
    const btn_m_pago_4 = document.getElementById('m_p_icon_4')
    if(select_logo_casa_apuesta || btn_m_pago_1 || btn_m_pago_2 || btn_m_pago_3 || btn_m_pago_4){
        select_logo_casa_apuesta.addEventListener('click',function(){
            //selecciona el campo donde pintará la url de la imagen subida
            const inputUrl = document.getElementById('url_logo_casa_apuesta')
            const prev_img = document.getElementById('prev_img')
            subir(inputUrl,prev_img)
        })

        btn_m_pago_1.addEventListener('click',function(){
          //selecciona el campo donde pintará la url de la imagen subida
          const inputUrl = document.getElementById('url_m_p_icon_1')
          const prev_img = document.getElementById('prev_img_m_p_icon_1')
          subir(inputUrl,prev_img)
      })

        btn_m_pago_2.addEventListener('click',function(){
          //selecciona el campo donde pintará la url de la imagen subida
          const inputUrl = document.getElementById('url_m_p_icon_2')
          const prev_img = document.getElementById('prev_img_m_p_icon_2')
          subir(inputUrl,prev_img)
      })

        btn_m_pago_3.addEventListener('click',function(){
          //selecciona el campo donde pintará la url de la imagen subida
          const inputUrl = document.getElementById('url_m_p_icon_3')
          const prev_img = document.getElementById('prev_img_m_p_icon_3')
          subir(inputUrl,prev_img)
      })
        btn_m_pago_4.addEventListener('click',function(){
          //selecciona el campo donde pintará la url de la imagen subida
          const inputUrl = document.getElementById('url_m_p_icon_4')
          const prev_img = document.getElementById('prev_img_m_p_icon_4')
          subir(inputUrl,prev_img)
      })
    }
    function subir(inputUrl,prev_img) {
        var mediaUploader;
          //
            if (mediaUploader) {
                mediaUploader.open();
                return;
            }
    
          // 
          mediaUploader = wp.media.frames.file_frame = wp.media({
                    title: 'Selecionar Imagen',
                    button: {
                    text: 'Selecionar Imagen'
                }, multiple: true });
    
          // 
          mediaUploader.on('select', function() {
                attachment = mediaUploader.state().get('selection').first().toJSON();
                inputUrl? inputUrl.value = attachment.url : null
                prev_img? prev_img.src = attachment.url : null
            });
    
          // 
          mediaUploader.open();
        }
 
});
