if(!localStorage.theme_mode){
    localStorage.theme_mode = 'light'
}
const dark = `<svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 512 512"><title>ionicons-v5-q</title><path d="M256,118a22,22,0,0,1-22-22V48a22,22,0,0,1,44,0V96A22,22,0,0,1,256,118Z"/><path d="M256,486a22,22,0,0,1-22-22V416a22,22,0,0,1,44,0v48A22,22,0,0,1,256,486Z"/><path d="M369.14,164.86a22,22,0,0,1-15.56-37.55l33.94-33.94a22,22,0,0,1,31.11,31.11l-33.94,33.94A21.93,21.93,0,0,1,369.14,164.86Z"/><path d="M108.92,425.08a22,22,0,0,1-15.55-37.56l33.94-33.94a22,22,0,1,1,31.11,31.11l-33.94,33.94A21.94,21.94,0,0,1,108.92,425.08Z"/><path d="M464,278H416a22,22,0,0,1,0-44h48a22,22,0,0,1,0,44Z"/><path d="M96,278H48a22,22,0,0,1,0-44H96a22,22,0,0,1,0,44Z"/><path d="M403.08,425.08a21.94,21.94,0,0,1-15.56-6.45l-33.94-33.94a22,22,0,0,1,31.11-31.11l33.94,33.94a22,22,0,0,1-15.55,37.56Z"/><path d="M142.86,164.86a21.89,21.89,0,0,1-15.55-6.44L93.37,124.48a22,22,0,0,1,31.11-31.11l33.94,33.94a22,22,0,0,1-15.56,37.55Z"/><path d="M256,358A102,102,0,1,1,358,256,102.12,102.12,0,0,1,256,358Z"/></svg>`

const light = `<svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 512 512"><title>ionicons-v5-q</title><line x1="256" y1="48" x2="256" y2="96" style="fill:none;stroke:#fff;stroke-linecap:round;stroke-miterlimit:10;stroke-width:32px"/><line x1="256" y1="416" x2="256" y2="464" style="fill:none;stroke:#fff;stroke-linecap:round;stroke-miterlimit:10;stroke-width:32px"/><line x1="403.08" y1="108.92" x2="369.14" y2="142.86" style="fill:none;stroke:#fff;stroke-linecap:round;stroke-miterlimit:10;stroke-width:32px"/><line x1="142.86" y1="369.14" x2="108.92" y2="403.08" style="fill:none;stroke:#fff;stroke-linecap:round;stroke-miterlimit:10;stroke-width:32px"/><line x1="464" y1="256" x2="416" y2="256" style="fill:none;stroke:#fff;stroke-linecap:round;stroke-miterlimit:10;stroke-width:32px"/><line x1="96" y1="256" x2="48" y2="256" style="fill:none;stroke:#fff;stroke-linecap:round;stroke-miterlimit:10;stroke-width:32px"/><line x1="403.08" y1="403.08" x2="369.14" y2="369.14" style="fill:none;stroke:#fff;stroke-linecap:round;stroke-miterlimit:10;stroke-width:32px"/><line x1="142.86" y1="142.86" x2="108.92" y2="108.92" style="fill:none;stroke:#fff;stroke-linecap:round;stroke-miterlimit:10;stroke-width:32px"/><circle cx="256" cy="256" r="80" style="fill:none;stroke:#fff;stroke-linecap:round;stroke-miterlimit:10;stroke-width:32px"/></svg>`
window.addEventListener('load',()=>{
    const btn_menu_mobile = document.querySelector('#btn_menu_mobile')
    const menu_mobile = document.querySelector('.menu_mobile')
    const menu_mobile_bg = document.querySelector('.menu_mobile_bg')
    const canvas = document.getElementById('grafics')
    const html_head = document.querySelector('head')
    const aw_btn_login = document.querySelectorAll('#aw_btn_login')
    const aw_modal_login = document.querySelector('#aw_modal_login')
    const aw_modal_effect = document.querySelector('#aw_modal_effect')
    aw_btn_login.forEach(btn=>{
        btn.style.cursor = 'pointer'
        btn.addEventListener('click',()=>{
            aw_modal_effect.addEventListener('click',()=>{
                aw_modal_effect.style.display = 'none'
                aw_modal_login.style.display = 'none'
            })
            aw_modal_effect.style.display = 'block'
            aw_modal_login.style.display = 'flex'
            const recovery = aw_modal_login.querySelector('form .recovery')
            const logo = aw_modal_login.querySelector('.logo')
            
            if(!recovery){
                aw_modal_login.querySelector('form').innerHTML += `<p class="recovery">
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
    if(html_head){
        const btn_theme_mode_header = document.createElement('button')
        btn_theme_mode_header.setAttribute('id','theme_mode_header')
       
        controler_btn_toggle_theme(window.innerWidth,btn_theme_mode_header)
        window.addEventListener('resize',()=>{
            controler_btn_toggle_theme(window.innerWidth,btn_theme_mode_header)
        })
        //'☪' '☀'
        btn_theme_mode_header.innerHTML = dark
        
        if(localStorage.theme_mode == 'dark'){
            btn_theme_mode_header.innerHTML = light
            const style = `<style>:root{
                --fondo:#202323;
                --bg-page:#303434;
                --bg-tarjetitas:#3b4040;
                --shadow:#202020;
                --bg-average:rgba(30, 115, 191, .25);
                --font-color:#fff;
                --font-color-2:#808080;
                --primary-color:#ff4141;
                --secondary-color:#1e73bf;
                --color-sub-title:#fff;
                --color-title-sidebar:rgb(30,115,191);
                --bg-sub-title:#043a69;
                --shadow-length: 36px ;
            } </style>`
            html_head.innerHTML += style
        }
        if(localStorage.theme_mode == 'light'){
            btn_theme_mode_header.innerHTML = dark
            const style = `<style>:root{
                --fondo:#f5f5f5;
                --bg-page:#fff;
                --bg-tarjetitas:#f5f5f5;
                --shadow:rgba(0,0,0, .12);
                --bg-average:rgba(30, 115, 191, .25);
                --font-color:#484848;
                --font-color-2:#808080;
                --primary-color:#ff4141;
                --secondary-color:#1e73bf;
                --color-sub-title:#fff;
                --color-title-sidebar:rgb(30,115,191);
                --bg-sub-title:#043a69;
                --shadow-length: 36px ;
            } </style>`
            
            html_head.innerHTML += style
        }
        btn_theme_mode_header.addEventListener('click',()=>{
            change_teme()            
        })

        const change_teme = ()=>{
            if(localStorage.theme_mode == 'light'){
                localStorage.theme_mode = 'dark'
                window.location.reload()
                return
            }
            if(localStorage.theme_mode == 'dark'){
                localStorage.theme_mode = 'light'
                window.location.reload()
                return
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
                let total = parseInt(n_acertados) + parseInt(n_fallidos)

                //estableciendo objeto total
                let data_total={
                    label:'pronosticos',
                    data:[total,total],
                    lineTension:0.3,
                    fill:false,
                    backgroundColor:'transparent',
                    borderColor:'green'
                }
                //estableciendo objeto de acerdatos
                let data_acertados={
                    label:'Acertados',
                    data:[n_acertados],
                    backgroundColor:'blue',
                }
                //estableciendo objeto de fallidos
                let data_fallidos={
                    label:'Fallidos',
                    data:[n_fallidos],
                    backgroundColor:'orange',
                }
                
                //objeto final para la grafica
                
                let finaldata={
                    labels:['Avegare del autor'],
                    datasets:[data_acertados,data_fallidos]
                }
                let context = canvas.getContext('2d')
                new Chart(context,{
                    type:'bar',
                    data:finaldata
                })
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
    function controler_btn_toggle_theme(width,btn){
        
        const menu_mobile = document.querySelector('.title_nav')
        const body = document.querySelector('body')
        if(width < 860){
            btn.style.position = 'relative'
            btn.style.right = 'unset'
            menu_mobile.appendChild(btn)
        }
        if(width >= 860){
            btn.style.zIndex = 90000000
            btn.style.position = 'fixed'
            btn.style.right = '15px'
            body.appendChild(btn)
        }
    }
    
})