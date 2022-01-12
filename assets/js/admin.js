
window.addEventListener("load",()=>{
    const form_add_account = document.querySelector('#aw-form-add-account') //Seleccionamos el form para añadir cuentas
    const btn_methods = document.querySelectorAll('button.method-item') //seleccionamos los botones del menu de metodos de pago
    if(btn_methods.length>0){ // verificamos que hay elementos
        for(let key=0;key<btn_methods.length;key++){
            btn_methods[key].addEventListener('click',async(e)=>{
                const current_button = e.target // accedemos al elemento button
                replace_form_metas({form:form_add_account,method:current_button.textContent}) // reemplezamos los metadatos del form segun su metodo de pago
                reset_class_btn_menu(btn_methods) //quitamos todas las clases active
                current_button.classList.add('active')
                get_payment_accounts({method:current_button.textContent})
            })
        }
    }
    if(form_add_account){ // verificamos que exista el formulario en el dom
        form_add_account.addEventListener('submit',e=>{
            e.preventDefault() //Evitamos que recarge la pagina
            const inputs = e.target.querySelectorAll('input') //extraemos los datos por defecto del formulario
            let account_data = {}
            let account_metadata = []
            inputs.forEach((input,i)=>{
                if(i < 6){
                    account_data[input.name] = input.value
                }
            })
            inputs.forEach((input,i)=>{
                if(i >= 6){
                    $key = input.name.toString()
                    account_metadata.push({key:input.name,value:input.value})
                }
            })
            const {payment_method} = e.target // extraemos el metodo de pago para recargar la tabla de cuentas
            insert_account({account_data,metadata:account_metadata})
            get_payment_accounts({method:payment_method.value})
        })
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

const insert_account = async({account_data,metadata})=>{
    const req = await fetch(php.rest_url+'aw-admin/payment-accounts',{
        method:"POST",
        body:JSON.stringify({account_data,metadata}),
        headers:{
            "Content-type": "application/json"
        }
    })
    await req.text()
}
const get_payment_accounts = async({method})=>{
    const c_table = document.querySelector("#aw-container-table")
    const req = await fetch(php.rest_url+'aw-admin/payment-accounts?method='+method)
    const {data} = await req.json()
    if(c_table){
        c_table.innerHTML = ""
        c_table.innerHTML = data
    }
    
}