let aw_payment_methods = false
const rest_uri = php_payment_services["rest_api_uri"]
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
    
    
    
      
    // copiar al portapapeles
    const labels = document.querySelectorAll('label.copy')
    
    if(labels.length>0){
      
      for(let label of labels){
        label.addEventListener('click',async e =>{
          const text_id = label.getAttribute("for")
          const input = document.getElementById(text_id)
          if(!navigator.clipboard){
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
})
function aw_default_register_payment_method(register_form,method){

  const ihc_payment_gateway_input = register_form.querySelector("input[name=ihc_payment_gateway]")
  const ihc_payment_selected_input = register_form.querySelector("input[name=payment_selected]")
  if(ihc_payment_gateway_input && ihc_payment_selected_input && method){
    ihc_payment_gateway_input.value = method
    ihc_payment_selected_input.value = method
  }else if(ihc_payment_gateway_input && ihc_payment_selected_input){
    ihc_payment_gateway_input.value = ""
    ihc_payment_selected_input.value = ""
    ihc_payment_gateway_input.setAttribute("required","")
    ihc_payment_selected_input.setAttribute("required","")
  }
}

function aw_change_register_payment_method(e){

  const ihc_payment_gateway_input = document.querySelector("input[name=ihc_payment_gateway]")
  const ihc_payment_selected_input = document.querySelector("input[name=payment_selected]")
  
  if(ihc_payment_gateway_input && ihc_payment_selected_input){
    ihc_payment_gateway_input.value = e.value
    ihc_payment_selected_input.value = e.value
    ihc_payment_gateway_input.id = e.getAttribute('data-method')
    ihc_payment_selected_input.id = e.getAttribute('data-method')
  }
}


async function aw_register_payment(form_event) {
  const inputs = form_event.target.querySelectorAll('input') //extraemos los datos por defecto del formulario
  const {ihc_country} = form_event.target
  let account_data = {}
  for(let input of inputs){
        account_data[input.name] = input.value
        if(input.name == 'payment_selected'){
          account_data["method_name"] = input.id
        }
  }
  account_data["ihc_country"] = ihc_country.value
  let breack = true
  
  if(account_data["user_login"] == "" || account_data["user_email"] == "" || account_data["pass1"] == ""){
    breack = false
    form_event.target.tos.checked = false
    alert("faltan datos por completar")
    return 
  }
  if (/\s/.test(account_data["user_login"])) {
    breack = false
    form_event.target.tos.checked = false
    alert("el nombre de usuario tiene espacios en blanco")
    return 
  }
  /* if(account_data["payment_selected"] == "" || account_data["ihc_payment_gateway"] == ""){
    breack = false
    form_event.target.tos.checked = false
    alert("Seleccione un metodo de pago")
    return
  } */
  if(account_data["pass1"].length <= 5){
    breack = false
    alert("Seleccione la contraseña es muy corta")
    return
  }
  //creamos selector de register metas unico por payment account
  let register_metas = form_event.target.querySelectorAll(`input[data-method="${account_data["payment_selected"]}"]`)
  account_data["register"] = []
  register_metas.forEach((input)=>{
      account_data["register"].push({meta_key:input.name,name:input.name,meta_value:input.value})
  })
  
  if(!form_event.target.tos.checked){
    breack = false
    alert("Acepte los terminos")
    return
  }
  
  if(breack){
    try {
      await fetch(`${rest_uri}aw-register-form/register-payment`,{
        method:'POST',
        body:JSON.stringify(account_data),
        headers:{
          "content-type":"application/json"
        }
      })
    } catch (error) {
      console.log(error)
    }
  }
}

