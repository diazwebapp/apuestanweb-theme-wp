const {rest_api_uri} = php_payment_services
window.addEventListener("load",()=>{
  
    //login form
    const container_form = document.querySelector(".ihc-login-form-wrap")
    const form = document.querySelector("#ihc_login_form")
    if(form){
      const divs = form.querySelectorAll("div")
      const div_register = form.querySelector("div.impu-form-links-reg")
      const div_lost_pass = form.querySelector("div.impu-form-links-pass")
      const div_social = form.querySelectorAll("div.ihc-sm-item")              
      
      
      divs.forEach(div=>{
        div.remove()
      })
      
      container_form.insertAdjacentHTML('afterbegin','<h4 class="card-title mt-3 text-center" style="color:black !important;">Login</h4>')
      form.innerHTML += `
          <div class="form-group input-group">
              <div class="input-group-prepend">
                  <span class="input-group-text"> <i class="fa fa-user"></i> </span>
              </div>
              <input type="text" value="" class="form-control" id="iump_login_username" name="log" placeholder="Username">
          </div>
          <div class="form-group input-group">
            <div class="input-group-prepend">
              <span class="input-group-text"> <i class="fa fa-envelope"></i> </span>
          </div>
              <input type="password" value="" class="form-control" id="iump_login_password" name="pwd" placeholder="Password">
          </div>
          <div class="form-group">
                  <input type="submit" value="Login" class="btn btn-primary btn-block">
          </div>
      `
      form.appendChild(div_lost_pass)
      form.appendChild(div_register)
      
      container_form.removeAttribute("class")
      container_form.classList.add("card-body")
      container_form.classList.add("mx-auto")

      if(div_social.length > 0){
        container_form.innerHTML += `<p class="divider-text"><span class="bg-light">OR</span></p>
        <p id="social-links" ></p>`
        
        const container_social_links = container_form.querySelector('#social-links')
        div_social.forEach(social=>{
          const enlace = social.querySelector('a')
          enlace.classList.add('btn')
          enlace.classList.add('btn-block')
          
          container_social_links.appendChild(social)
        })
      }
    }

    ////////////////////Register form/////////////////////////
    const checkout_form = document.getElementById("checkout-form")
    if(checkout_form){
      //Seleccionamos todos los inputs de metodos de pago
      const payment_inputs = checkout_form.querySelectorAll('#payment-select input[name=aw-payment-radio]')
      if(payment_inputs.length > 0){
        payment_inputs[0].checked = true
        aw_payment_method_controller(payment_inputs[0])
        for(let payment_input of payment_inputs){
          payment_input.addEventListener('change',()=>aw_payment_method_controller(payment_input))
        }        
      }
      // Seleccionamos todos los label para copiar al portapapeles
      const labels = checkout_form.querySelectorAll('#payment-select label.copy')
      //Recorremos los labels y asignamos su respectiva función copy
      if(labels.length>0){
        
        for(let label of labels){
          label.addEventListener('click',async e =>{
            const text_id = label.getAttribute("for")
            const input = document.getElementById(text_id)
            if(!navigator.clipboard){ //Si el navegador no soporta navigator.clipboard
              input.focus()
              input.select();
              const result = document.execCommand('copy');
              if (result === 'unsuccessful') {
                console.error('Failed to copy text.');
                return;
              }
              await $('.toast').toast('show')
              return
            }
  
            try {
              await navigator.clipboard.writeText(input.value)
              await $('.toast').toast('show')
            } catch (err) {
              console.error('Failed to copy!', err)
            }
  
          })
        }
      }
      const submit_btn = checkout_form.querySelector("button")
      if(submit_btn){
        submit_btn.disabled = false
      }
      checkout_form.addEventListener('submit',async (e)=>await aw_submit_checkout_form(e))
    }
          
})
/*//////////////
*             *
*Controladores*
*             *
/////////////*/
///////controlador de payment method inputs
const aw_payment_method_controller = (e)=>{
  const register_payment_inputs = document.querySelectorAll(`#payment-select input.register-input`) //Seleccionamos todos los campos que es usuario debe llenar para registrar su pago
  if(register_payment_inputs.length > 0){
    for(let register_payment_input of register_payment_inputs){
      let account_id = register_payment_input.getAttribute('account-id')
      register_payment_input.required = false
      if(account_id == e.value){
        register_payment_input.required = true
      }      
    }
  }
}
const aw_submit_checkout_form = async (e)=>{
  e.preventDefault()
  //Seleccionamos todos los inputs de metodos de pago
  const payment_inputs = e.target.querySelectorAll('#payment-select input[name=aw-payment-radio]')
  const btn = e.target.querySelector('button')
  let text_btn = btn.textContent
  btn.disabled = true
  btn.textContent = "espere..."
  let payment_account_id = false
  let payment_account_name = false
  let payment_history_metas = []
  
  for(let payment_input of payment_inputs){
    if(payment_input.checked){
      let attr = payment_input.getAttribute("data-method")
      payment_account_id = payment_input.value
      payment_account_name = attr    
    }
  }
  const register_payment_inputs = document.querySelectorAll(`#payment-select input.register-input`)
  for(let register_payment_input of register_payment_inputs){
      let attr = register_payment_input.getAttribute("account-id")
      if(payment_account_id === attr){ 
        let meta = {
          meta_key: register_payment_input.name,
          meta_value: register_payment_input.value
        }
        payment_history_metas.push(meta)
      }
  }
  const {lid} = e.target
 
  if(payment_account_name.toLowerCase() == "paypal"){
    const {id,links,status} = await paypal_checkout({lid:lid.value,payment_account_id})
    
        if(status === "CREATED"){
          window.location = links[1].href
        }else{
          btn.disabled = false
          btn.textContent = btn.textContent
          alert("ha habido un error con paypal")
        }
    return
  }
  const {redirect} = await aw_checkout_activate_membership({payment_history_metas,lid:lid.value,payment_account_id})
  btn.textContent = text_btn
  if(redirect){
    location = redirect
  }
  btn.disabled = false
}

const aw_checkout_activate_membership = async({lid,payment_history_metas,payment_account_id})=>{
  const uri = rest_api_uri + 'aw-user-levels/user-level-opeations/'
  try{
    const req = await fetch(uri,{
      method:'post',
      body:JSON.stringify({lid,payment_history_metas,payment_account_id}),
      headers:{
          "content-type" : "application/json"
        }
    })
    if(req.status == 200){
      const resp = await req.json()
      return resp
    }
  }catch(err){
    console.log(err)
    return false
  }
  btn.textContent = text_btn
  btn.disabled = false
  return false
}
const paypal_checkout = async({lid,payment_account_id})=>{
  const req = await fetch(rest_api_uri+'aw-paypal-api/create-order',{
    method:'post',
    body: JSON.stringify({lid,payment_account_id}),
    headers:{
      "content-type":"application/json"
    }
  })
  if(req.status == 200){
    const res = await req.json()
    return res
  }
  return false
}
