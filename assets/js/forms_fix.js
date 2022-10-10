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

    //Register form
    const container_register_form = document.querySelector("div#aw-container-register-form")
    if(container_register_form){
      const register_form = container_register_form.querySelector("form")
      const div_register_social = register_form.querySelectorAll("div.ihc-sm-item")
      //const div_register_payments = register_form.querySelectorAll(".ihc-js-select-payment")
      const register_form_divs = register_form.querySelectorAll("div")
      const register_countries = register_form.querySelectorAll("select#ihc_country_field option");
      //const product_subtotal_table = register_form.querySelector("table.ihc-subtotal-table")
      const checkout_session = register_form.querySelector("div.ihc-js-checkout-session")
      const checkout_button = register_form.querySelector("div#ihc-checout-page-purchase-button-section")
      const product_name = register_form.querySelector("div.ihc-product-name")
      const product_description = register_form.querySelector("div.ihc-product-description")
      const product_price = register_form.querySelector("div.ihc-product-price")
      const product_fee_name = register_form.querySelector("div.ihc-product-main-fee-label")
      const product_fee_amount = register_form.querySelector("span#ihc-subtotal-product-price")
      const discount_input = register_form.querySelector("input#ihc-discount") 
      const discount_title = register_form.querySelector("div.ihc-checkout-page-additional-info") 
      const discount_button = register_form.querySelector("button#ihc-apply-discount") 
      
      
      const tos = register_form.querySelector("div.ihc-tos-wrap")

      //Create select
      const select_country_element = document.createElement("select")
      select_country_element.setAttribute("id","ihc_country_field")
      select_country_element.setAttribute("name","ihc_country")
      select_country_element.classList.add("form-control")
      select_country_element.classList.add("select2countries")
      
      register_countries.forEach(country=>{
        if(php_payment_services["client_geolocation"]["country_code"] == country.value){
          country.setAttribute("seleted","")
        }else{
          country.removeAttribute("seleted","")
        }
        select_country_element.appendChild(country)
      })
      
      register_form_divs.forEach(div=>{
        div.remove()
      })
      container_register_form.style.display = "block"
      if(register_form){

        if(div_register_social.length > 0){
          container_register_form.insertAdjacentHTML('afterbegin','<p class="divider-text"><span class="bg-light">OR</span></p>')
          container_register_form.insertAdjacentHTML('afterbegin','<p id="social-links" ></p>')
          const container_social_links = container_register_form.querySelector('#social-links')
          div_register_social.forEach(social=>{
            container_social_links.appendChild(social)
          })
        }
        container_register_form.insertAdjacentHTML('afterbegin','<h4 class="card-title mt-3 text-center" style="color:black !important;">Create Acount</h4>')
        register_form.innerHTML += `
              <section class="form-group input-group"">
                  <section class="input-group-prepend">
                      <span class="input-group-text"> <i class="fa fa-user"></i> </span>
                  </section>
                  <input type="text" class="form-control" name="user_login" placeholder="username" autocomplete="username">
              </section>
              <section class="form-group input-group">
                  <section class="input-group-prepend">
                      <span class="input-group-text"> <i class="fa fa-envelope"></i> </span>
                  </section>
                  <input type="email" class="form-control" name="user_email" placeholder="Email" autocomplete="email">
              </section>
              <section class="form-group input-group">
                <section class="input-group-prepend">
                    <span class="input-group-text"> <i class="fa fa-lock"></i> </span>
                </section>
                  <input type="password" value="" class="form-control" name="pass1" placeholder="Password">
              </section>
              ${
                register_countries.length > 0 ? (`<section class="form-group input-group" id="country-field">
                <section class="input-group-prepend">
                    <span class="input-group-text"> <i class="fa fa-globe"></i> </span>
                </section>
                <div class="dropdown">
                
                  <!-- dinamic content-->
              </section>'`) : ''
              }

              <section class="form-group" id="payment-field">
                  <!-- dinamic content-->
                  <table class="table-product-details" >
                    <tr>
                      <td id="product-name" >
                      </td>
                      <td id="product-price">
                      </td>
                    </tr>
                  </table>
                  <div id="discount" >
                    <!-- dimanic content -->
                  </div>
                  <div id="payment-select" class="accordion">
                    
                  </div>

                  <table class="table-product-subtotal" >
                    <tr>
                      <td id="fee-name" >
                      </td>
                      <td id="product-subtotal">
                      </td>
                    </tr>
                  </table>
              </section>
              
              <section class="form-group">
                      <input type="submit" value="Register" class="btn btn-primary btn-block">
              </section>
              <section class="form-group" id="terms">
                <!-- dinamic terms and conditions-->
              </section>
          `
          register_form.addEventListener("submit",async(e)=>{
              e.preventDefault()
              await aw_register_payment(e)
          })
          // add select country to form
          if(register_countries.length > 0){

            const div_country_field = register_form.querySelector("section#country-field")
            div_country_field.appendChild(select_country_element) //select
            $('.select2countries').select2();
          }
          //add product details
          const product_name_ = register_form.querySelector("td#product-name")
          product_name_.appendChild(product_name)
          product_name_.appendChild(product_description)
          const product_price_ = register_form.querySelector("td#product-price")
          product_price_.textContent = product_price.textContent
                  
          //add product subtotal
          const product_fee_name_ = register_form.querySelector("td#fee-name")
          product_fee_name_.appendChild(product_fee_name)
          const product_fee_amount_ = register_form.querySelector("td#product-subtotal")
          product_fee_amount_.textContent = product_fee_amount.textContent
          //add discount
          if(discount_input){

            const div_discount = register_form.querySelector("div#discount")
            div_discount.appendChild(discount_title)
            div_discount.appendChild(discount_input)
            div_discount.appendChild(discount_button)
          }
          // add payment select to form
          const div_payment_field = register_form.querySelector("div#payment-select")
          
          //add term conditions
          const tos_field = register_form.querySelector("section#terms")
          tos_field.appendChild(tos)
          
          div_payment_field.appendChild(checkout_session) //add checkout session
          div_payment_field.appendChild(checkout_button) //add checkout button
          
          //div_register_payments
          const payment_methods_ = php_payment_services["um_payment_methods"]
          let payment_methods_array = []
          if(payment_methods_){
              payment_methods_array = Object.entries(payment_methods_)
          }
          let template = document.querySelector("#temp")
          if(template){
            let label = template.content.querySelector('label')
            let input = template.content.querySelector('input')
            
            for(let i = 0; i < payment_methods_array.length; i++){
              label.textContent = payment_methods_array[i][1]
              label.setAttribute('for',payment_methods_array[i][0])
              input.id = payment_methods_array[i][0]
              input.value = payment_methods_array[i][0]
              input.setAttribute('data-method',payment_methods_array[i][0])

              if(payment_methods_array[i][0] !== 'bank_transfer'){
                let clone = document.importNode(template.content,true)
                div_payment_field.appendChild(clone)
              }
            }
            div_payment_field.innerHTML += `${php_payment_services["html"]}`
          }
          aw_default_register_payment_method(register_form)
        }
        
      }
      
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

