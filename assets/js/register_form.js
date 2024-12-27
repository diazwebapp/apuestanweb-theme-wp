// Vars injected by php : register_form_vars
window.addEventListener("load",()=>{
    const form = document.querySelector('.aw_register_form')

    if(form){
        ////Seleccionamos los inputs del form
        const inputs = form.querySelectorAll('input')
        /////creamos unas variables que detectará el error        
        let user_exists = false
        let email_exists = false
        /////detectamos si hay inputs
        if(inputs.length > 0){
            for(let input of inputs){
                ///Detectamos username o email
                if(input.name == 'username' || input.name == 'email'){
                    ///aplicamos un evento para detectar si el usuario existe
                    input.addEventListener('keyup',async ()=> {
                        const { success, data } = await detect_user_exists(input);
                        const { status, msg } = data;  // Extraemos status y msg desde data
                        if(status == 'fail'){
                            let icon_danger = `<span class="icon-danger notification">⚠️</span>`
                            // Inserta el icono de peligro antes del input
                            input.insertAdjacentHTML('beforebegin', icon_danger);

                            // Selecciona el icono insertado
                            const dangerIcon = document.querySelector('.icon-danger');

                            // Elimina el icono después de 2 segundos
                            setTimeout(() => {
                                if (dangerIcon) {
                                    dangerIcon.remove();
                                }
                            }, 2000);

                            
                            if(input.name == 'username'){
                                user_exists = true
                            }
                            if(input.name == 'email'){
                                email_exists = true
                            }
                            show_toats("toastsRegisterForm",`${msg}`)
                            return
                        }
                        if(status == 'ok'){
                            let child = input.parentElement.querySelector('i.notification')
                            if(child){
                                input.parentElement.removeChild(child)
                            }
                            if(input.name == 'username'){
                                user_exists = false
                            }
                            if(input.name == 'email'){
                                email_exists = false
                            }
                        }
                    })
                }
            }
            form.addEventListener('submit',async e=>{
                let breack = false
                e.preventDefault()
                let register_data = {}

                for(let input of inputs){
                    if(input.value == '' && input.className != 'nice-select-search'){
                        breack = true
                        show_toats("toastsRegisterForm",`${input.name} está vacio!`)
                        return;
                    }
                    if(input.name == 'tos' && !input.checked){
                        show_toats("toastsRegisterForm","Acepte los terminos")
                        breack = true
                        return;
                    }
                    register_data[input.name] = input.value
                }
                const {country} = e.target
                if(country.value == ''){
                    show_toats("toastsRegisterForm",`${country.name} está vacio!`)
                    breack = true
                    return;
                }
                register_data[country.name] = country.value
                
                const {status,redirect_url} = await register_user(register_data)  
                
                if(status == 'ok'){
                    //document.location = redirect_url
                } 
                if(status == 'fail'){
                    show_toats("toastsRegisterForm","A ocurrido un error de red")
                } 
            })
        }
    }
})

//////////////comprobe username

const detect_user_exists = async (input)=>{
    try {
        const req = await fetch(`${register_form_vars.rest_uri}aw-register-form/check-user-exists?name=${input.name}&value=${input.value}`)
        const resp = await req.json()
        return resp
    } catch (error) {
        console.log(error)
        return {status:'fail'}
    }
} 

const register_user = async(register_data)=>{
    try {
        const req = await fetch(`${register_form_vars.rest_uri}aw-register-form/register-user`,{
            method:'post',
            body:JSON.stringify(register_data),
            headers:{
                "content-type":"application/json"
            }
        })
        const resp = await req.json()
        
        return resp
    } catch (error) {
        console.error(error)
        return {status:'fail'}
    }
}
///////////////toggle toasts

const show_toats = (id_element,msg)=>{
    let toasts = document.getElementById(id_element)
    toasts.querySelector('.toast-body').textContent = msg
    toasts.classList.replace('hide','show')
    setTimeout(()=>{
        toasts.querySelector('.toast-body').textContent = ''
        toasts.classList.replace('show','hide')
    },3000)
}