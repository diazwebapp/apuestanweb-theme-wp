window.addEventListener("load",()=>{
    /////////Cambiamos el backgroun de color
    const wp_content = document.getElementById("wpcontent")
    //wp_content.style.background = '#1d2327'
    //////////////seleccionamos el formulario de añadir metodos de pago
    const form_add_method = document.getElementById("aw-add-payment-method-form")
    /////////verificamos que exista en el DOM
    if(form_add_method){
        /////////añadimos el controlador que manejara el formulario
        form_add_method.addEventListener("submit",async e => await aw_add_new_method(e))
    }
    //////////////seleccionamos el formulario de añadir cuentas
    const form_add_maccounts = document.getElementById("aw-form-add-account")
    /////////verificamos que exista en el DOM

    if(form_add_maccounts){
        /////////añadimos el controlador que manejara el formulario
        form_add_maccounts.addEventListener("submit",async e => await aw_add_new_account(e))
    }
})

///////////////// funcion que añade metodos de pago usando la api rest
const insert_payment_method = async({received_inputs,register_inputs,payment_method_data})=>{
    try {
        
        const req = await fetch(php.rest_url+'aw-admin/payment-methods',{
            method:"POST",
            body:JSON.stringify({received_inputs,register_inputs,payment_method_data}),
            headers:{
                "Content-type": "application/json"
            }
        })
        return await req.json()
    } catch (error) {
        return console.log(error)
    }
}
const insert_account = async({account_data,metadata})=>{
    try {
        
        const req = await fetch(php.rest_url+'aw-admin/payment-accounts',{
            method:"POST",
            body:JSON.stringify({account_data,metadata}),
            headers:{
                "Content-type": "application/json"
            }
        })
        const res = await req.json()
        return res
    } catch (error) {
        return console.log(error)
    }
}

function change_payment_status(e){
    const {status,element,lid,username} = e.attributes
    let path = `?update_payment_history_id=${element.textContent}&status=${status.textContent}&lid=${lid.textContent}&username=${username.textContent}`
    console.log(path)
    document.location = document.location.pathname + path
}

function aw_add_new_payment_data(action){
    
    const container = action.parentNode.parentNode;
    
    const template = document.getElementById(`${container.id}-template`);
    var clon = template.content.cloneNode(true);
    container.appendChild(clon);
}

function aw_drop_new_payment_data(element){
    element.parentNode.parentNode.remove();
}
//////////////////// controlador de formulario para añadir metodos de pago
async function aw_add_new_method(form){
    form.preventDefault()
    const {payment_method,icon_service,icon_class,status} = form.target
    
    const containers_received_inputs = form.target.querySelectorAll("#fields-received-paid div.inputs")
    const containers_register_inputs = form.target.querySelectorAll("#fields-register-paid div.inputs")
    const button = form.target.querySelector("button")
    let original_text = button.textContent
    button.textContent = "wait..."
    button.disabled = true
    
    const payment_method_data = {}
    let received_inputs = []
    let register_inputs = []

    payment_method_data[payment_method.name] = payment_method.value
    payment_method_data[icon_service.name] = icon_service.value
    payment_method_data[icon_class.name] = icon_class.value
    payment_method_data[status.name] = status.checked

    let breack = false
    if(containers_received_inputs && containers_received_inputs.length > 0){
        for(container of containers_received_inputs){
            const inputs = container.querySelectorAll("input")
            const type = inputs[0].value
            const name = inputs[1].value
            const show_ui = inputs[2].checked
            if(received_inputs.length > 0){
                received_inputs.filter(item=> item.name !== name ? received_inputs.push({type,name,show_ui}) : (()=>{
                    breack=true;
                    container.style.border = "1px solid red";
                    show_toats({msg:"elementos duplicados"});
                })())
            }
            if(received_inputs.length == 0){
                received_inputs.push({type,name,show_ui})
            }             
        }
    }
    
    if(containers_register_inputs && containers_register_inputs.length > 0){
        for(container of containers_register_inputs){
            const inputs = container.querySelectorAll("input")
            const type = inputs[0].value
            const name = inputs[1].value
            if(register_inputs.length > 0){
                register_inputs.map(item=> item.name !== name ? register_inputs.push({type,name}) : (()=>{
                    breack=true;
                    container.style.border = "1px solid red";
                    show_toats({msg:"elementos duplicados"});
                })())
            }
            if(register_inputs.length == 0 && !breack){
                register_inputs.push({type,name})
            } 
        }
        
    }
    if(received_inputs.length < 1){
        setTimeout(()=>{
            button.textContent = original_text
            button.disabled = false
        },1000)
        show_toats({msg:"añada inputs para mostrar su información de pago"})
    }
    if(!breack){
        ///////////eliminamos duplicados
        let received_inputsMap = received_inputs.map(item=>{
            return [item.name,item]
        });
        let received_inputsMapArr = new Map(received_inputsMap); // Pares de clave y valor
        received_inputs = false
        received_inputs = [...received_inputsMapArr.values()];

        let register_inputsMap = register_inputs.map(item=>{
            return [item.name,item]
        });
        let register_inputsMapArr = new Map(register_inputsMap); // Pares de clave y valor
        register_inputs = false
        register_inputs = [...register_inputsMapArr.values()];
        ////////////
        const response = await insert_payment_method({received_inputs,register_inputs,payment_method_data})
        
        if(!response.status){
            button.textContent = "error"
            show_toats({msg:response.msg})
        }
        if(response.status){
            location.reload()
        }
    }
    setTimeout(()=>{
        button.textContent = original_text
        button.disabled = false
    },1000)
    
}

function show_toats({msg}){
    const toats = document.querySelector(".toast")
    const toats_body = toats.querySelector(".toast-body")
    toats_body.textContent = msg
    toats.style.opacity = 1
    setTimeout(()=>{
        toats.style.opacity = 0
        toats_body.textContent = ""
    },4000)
}
async function aw_add_new_account(form){
    form.preventDefault()
    const {payment_method_name,payment_method_id,country_code,status} = form.target
    ////creamos el objeto con los campos obligatorios de la cuenta
    const account_data = {}
    account_data[payment_method_name.name] = payment_method_name.value
    account_data[payment_method_id.name] = payment_method_id.value
    account_data[country_code.name] = country_code.value
    account_data[status.name] = status.checked
    /////////////seleccionamos los inputs dinamicos
    const dynamic_inputs = form.target.querySelectorAll('input.dynamic-input')
    const metadata = [];
    if(dynamic_inputs.length > 0){
        for(input of dynamic_inputs){
           const obj = {key:input.name,value:input.value,status:true}
           metadata.push(obj)
        }
    }
    await insert_account({account_data,metadata})
    location.reload()
}