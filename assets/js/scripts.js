window.addEventListener('load',()=>{
    const btn_menu_mobile = document.querySelector('#btn_menu_mobile')
    const menu_mobile = document.querySelector('.menu_mobile')
    const menu_mobile_bg = document.querySelector('.menu_mobile_bg')
    const canvas = document.getElementById('grafics')
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
                    data:[0,n_acertados],
                    lineTension:0.3,
                    fill:false,
                    backgroundColor:'transparent',
                    borderColor:'blue'
                }
                //estableciendo objeto de fallidos
                let data_fallidos={
                    label:'Fallidos',
                    data:[0,n_fallidos],
                    lineTension:0.3,
                    fill:false,
                    backgroundColor:'transparent',
                    borderColor:'orange'
                }
                //objeto final para lagrafica
                
                let finaldata={
                    labels:['totales','segmentacion'],
                    datasets:[data_total,data_acertados,data_fallidos]
                }
                let context = canvas.getContext('2d')
                let chart = new Chart(context,{
                    type:'line',
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

})