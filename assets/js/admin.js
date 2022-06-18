window.addEventListener("load",()=>{
    const form_add_method = document.getElementById("aw-add-payment-method-form")
    if(form_add_method){
        form_add_method.addEventListener("submit",async e => await aw_add_new_account(e))
    }
})
// funcion para remover las clases a todos los botones del menu
const reset_class_btn_menu = (btn_methods)=>{
    for(let key=0;key<btn_methods.length;key++){
        btn_methods[key].classList.remove('active')
    }
}

const replace_form_metas = ({form,method})=>{
    const form_metadata = form.querySelector('#form-metadata') //Seleccionamos el form para añadir cuentas
    const payment_method = form.querySelector('#payment_method')
    payment_method.value = method
    form_metadata.innerHTML = "";
    form_metadata.innerHTML = php_form_metadata[method] // reemplazamos los metas de manera dinamica comparando el payment method que viene del button con el de la variable inyectada desde php
}

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
        await req.json()
    } catch (error) {
        return console.log(error)
    }
}

const get_payment_accounts = async({method})=>{
    const c_table = document.querySelector("#aw-container-table")
    try {
        const req = await fetch(php.rest_url+'aw-admin/payment-accounts?method='+method)
        const {data} = await req.json()
        if(c_table){
            c_table.innerHTML = ""
            c_table.innerHTML = data
        }
    } catch (error) {
        return console.log(error)
    }
    
}

function change_payment_status(e){
    const {status,element} = e.attributes
    let path = `?update_payment_history_id=${element.textContent}&status=${status.textContent}`
    
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

async function aw_add_new_account(form){
    form.preventDefault()
    const {payment_method,icon_service,icon_class,status} = form.target
    
    const containers_received_inputs = form.target.querySelectorAll("#fields-received-paid div.inputs")
    const containers_register_inputs = form.target.querySelectorAll("#fields-register-paid div.inputs")
    const button = form.target.querySelector("button")
    let original_text = button.textContent
    button.textContent = "wait..."
    button.disabled = true
    
    const payment_method_data = {}
    const received_inputs = []
    const register_inputs = []

    payment_method_data[payment_method.name] = payment_method.value
    payment_method_data[icon_service.name] = icon_service.value
    payment_method_data[icon_class.name] = icon_class.value
    payment_method_data[status.name] = status.checked

    if(containers_received_inputs && containers_received_inputs.length > 0){
        for(container of containers_received_inputs){
            const inputs = container.querySelectorAll("input")
            const type = inputs[0].value
            const name = inputs[1].value
            const show_ui = inputs[2].checked
            received_inputs.push({type,name,show_ui})
        }
    }
    if(containers_register_inputs && containers_register_inputs.length > 0){
        for(container of containers_register_inputs){
            const inputs = container.querySelectorAll("input")
            const type = inputs[0].value
            const name = inputs[1].value
            register_inputs.push({type,name})
        }
    }
    if(received_inputs.length < 1){
        setTimeout(()=>{
            button.textContent = original_text
            button.disabled = false
        },1000)
        show_toats({msg:"añada inputs para mostrar su información de pago"})
    }
    if(received_inputs.length > 0){
        const response = await insert_payment_method({received_inputs,register_inputs,payment_method_data})
        if(!response.status){
            button.textContent = "error"
        }
        show_toats({msg:response.msg})
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