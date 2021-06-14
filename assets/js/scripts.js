window.addEventListener('load',()=>{
    const btn_menu_mobile = document.querySelector('#btn_menu_mobile')
    const menu_mobile = document.querySelector('.menu_mobile')
    const menu_mobile_bg = document.querySelector('.menu_mobile_bg')
    const canvas = document.getElementById('grafics')
    const html_head = document.querySelector('head')
    const aw_btn_login = document.querySelectorAll('#aw_btn_login')
    const aw_modal_login = document.querySelector('#aw_modal_login')
    const aw_modal_effect = document.querySelector('#aw_modal_effect')
    const body = document.querySelector('body')
    if(aw_modal_login){
        const login_form = aw_modal_login.querySelector('form')
        aw_btn_login.forEach(btn=>{
            btn.style.cursor = 'pointer'
            btn.addEventListener('click',()=>{
                aw_modal_effect.addEventListener('click',()=>{
                    aw_modal_effect.style.display = 'none'
                    aw_modal_login.style.display = 'none'
                })
                aw_modal_effect.style.display = 'block'
                aw_modal_login.style.display = 'flex'
                const recovery = login_form.querySelector('.recovery')
                const logo = aw_modal_login.querySelector('.logo')
                
                if(!recovery){
                    login_form.innerHTML += `<p class="recovery">
                    <a href="http://localhost:5000/wp-login.php?action=register">Registro</a>
                     | 
                    <a href="http://localhost:5000/wp-login.php?action=lostpassword">¿Has olvidado tu contraseña?</a>
                </p>`
                }
                if(!logo){
                    aw_modal_login.innerHTML += `<p class="logo">
                    <img src="/wp-content/themes/apuestanweb-theme-wp/assets/images/hh2.png" alt="Apuestanweb logo" />
                </p>`
                }
                const input_login = aw_modal_login.querySelector('#user_login')
                const input_pass = aw_modal_login.querySelector('#user_pass')
    
                function label_focus(style,css_selector){
                    if(style=='topUp'){
                        const label = aw_modal_login.querySelector(`${'.'+css_selector} label`)
                        label.style.top = "-30px"
                    }
                    if(style=='topDown'){
                        const label = aw_modal_login.querySelector(`${'.'+css_selector} label`)
                        label.style.top = "0"
                    }
                }
    
                input_login.addEventListener('focusin',()=>{
                    label_focus('topUp','login-username')
                })
                input_login.addEventListener('focusout',()=>{
                    label_focus('topDown','login-username')
                })
    
                input_pass.addEventListener('focusin',()=>{
                    label_focus('topUp','login-password')
                })
                input_pass.addEventListener('focusout',()=>{
                    label_focus('topDown','login-password')
                })
            })
        })
    }
    if(html_head){
        const btn_theme_mode_header = document.querySelectorAll('#theme_mode_header')
        if(localStorage.theme_mode == 'dark'){
            body.classList.add('dark_mode')
            for (const btn of btn_theme_mode_header) {
                btn.classList.remove('btn_light')
                btn.classList.add('btn_dark')
            }
        }
        
       
        for (const btn of btn_theme_mode_header) {
            btn.addEventListener('click',()=>{
                change_teme(btn)            
            })
        }

        const change_teme = ()=>{
            body.classList.toggle('dark_mode')
                
            if(localStorage.theme_mode !== 'dark' || !localStorage.theme_mode){
                for (const btn of btn_theme_mode_header) {
                    btn.classList.remove('btn_light')
                    btn.classList.add('btn_dark')
                }
                localStorage.theme_mode = 'dark'
                return
            }else{
                for (const btn of btn_theme_mode_header) {
                    btn.classList.add('btn_light')
                    btn.classList.remove('btn_dark')
                }
                localStorage.removeItem('theme_mode')
            }
        }
    }
    //Si existen los elementos en el dom ejecutar sus respectivas acciones
        menu_mobile_bg && menu_mobile && btn_menu_mobile?(
            (()=>{
                menu_mobile_bg.addEventListener('click',()=>{
                    menu_controller('close')
                })
                menu_mobile.addEventListener('click',()=>{
                    menu_controller('close')
                })
                btn_menu_mobile.addEventListener('click',()=>{
                    menu_controller('open');
                })
            })()
        ):null
    // si existe el canvas en el dom, crear el context 2d
        canvas?(
            (()=>{
                //capturando los datos de pronosticos desde los atributos del canvas
                let n_acertados = canvas.attributes.data_success.value
                let n_fallidos = canvas.attributes.data_failed.value
                var ctx = canvas.getContext('2d');
                var myChart = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: ['Acertados', 'Fallidos',],
                        datasets: [{
                            label: 'Statics',
                            data: [n_acertados, n_fallidos],
                            backgroundColor: [
                                'rgba(54, 162, 235, 0.2)',
                                'rgba(255, 99, 132, 0.2)',
                            ],
                            borderColor: [
                                'rgba(54, 162, 235, 1)',
                                'rgba(255, 99, 132, 1)',
                            ],
                            borderWidth: 1
                        }]
                    },
                    options: {
                        
                    }
                });
                
            })()
        ):null
    //controlador del menu
    function menu_controller(status){
        if(status === 'close'){
            menu_mobile_bg.style.display = 'none'
            menu_mobile.style.left = '-100%'
            return
        }else{
            menu_mobile_bg.style.display = 'block'
            menu_mobile.style.left = '0%'
            return
        }
    }    
})