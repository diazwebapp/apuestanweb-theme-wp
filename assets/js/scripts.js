window.addEventListener('load',()=>{
    const btn_menu_mobile = document.querySelector('#btn_menu_mobile')
    const menu_mobile = document.querySelector('.menu_mobile')
    const menu_mobile_bg = document.querySelector('.menu_mobile_bg')

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