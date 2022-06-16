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
      const select_country_element = document.createElement("input")
      select_country_element.setAttribute("id","ihc_country_field")
      select_country_element.setAttribute("name","ihc_country")
      select_country_element.setAttribute("list","countries")
      select_country_element.setAttribute("class","form-control")
      //create default option
      select_country_element.value = php_payment_services["client_geolocation"]["country_code"]
      //create datalist
      const datalist_countries = document.createElement("datalist")
      datalist_countries.setAttribute("id","countries")
      register_countries.forEach(country=>{
        datalist_countries.appendChild(country)
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
                  <input type="text" class="form-control" name="user_login" placeholder="username">
              </section>
              <section class="form-group input-group">
                  <section class="input-group-prepend">
                      <span class="input-group-text"> <i class="fa fa-envelope"></i> </span>
                  </section>
                  <input type="email" class="form-control" name="user_email" placeholder="Email">
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
                  <ol id="payment-select" class="list-group">
                    
                  </ol>

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
              await aw_register_payment(e)
          })
          // add select country to form
          if(register_countries.length > 0){

            const div_country_field = register_form.querySelector("section#country-field")
            div_country_field.appendChild(select_country_element) //select
            div_country_field.appendChild(datalist_countries) //datalist
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
          const div_payment_field = register_form.querySelector("ol#payment-select")
          
          //add term conditions
          const tos_field = register_form.querySelector("section#terms")
          tos_field.appendChild(tos)
          
          div_payment_field.appendChild(checkout_session) //add checkout session
          div_payment_field.appendChild(checkout_button) //add checkout button
          
          //div_register_payments
          
          let payment_methods_array = Object.entries(php_payment_services["um_payment_methods"])
          let template = document.querySelector("#temp")
          if(template){
            let label = template.content.querySelector('label')
            let input = template.content.querySelector('input')
            
            for(let i = 0; i < payment_methods_array.length; i++){
              label.textContent = payment_methods_array[i][1]
              label.setAttribute('for',payment_methods_array[i][0])
              input.id = payment_methods_array[i][0]
              input.value = payment_methods_array[i][0]
              input.name = "aw-payment-radio"

              if(payment_methods_array[i][0] !== 'bank_transfer'){
                let clone = document.importNode(template.content,true)
                div_payment_field.appendChild(clone)
              }
            }
          }
          (async()=>{ //function autoiniciada para pintar los metodos de pago del tema 

            aw_payment_methods = await print_payment_methods_data()
            aw_payment_methods = Object.entries(aw_payment_methods)

            let template = document.querySelector("#aw-temp")
            
            if(template){
              let label = template.content.querySelector('label')
              let input = template.content.querySelector('input')
              let div = template.content.querySelector('div.method_data')
              for(let i = 0; i <aw_payment_methods.length;i++){
                label.setAttribute('for',aw_payment_methods[i][1].key)
                label.textContent = aw_payment_methods[i][1].name
                label.setAttribute("data-target",`#${aw_payment_methods[i][1].key}`)
                label.setAttribute("aria-controls",`${aw_payment_methods[i][1].key}`)

                div.id = aw_payment_methods[i][1].key
                input.value = aw_payment_methods[i][1].key
                input.name = "aw-payment-radio"
                input.id = aw_payment_methods[i][1].key
                div.innerHTML = '<div class="d-flex w-100 justify-content-between">'
                let accounts_template = ''
                for(account of aw_payment_methods[i][1].accounts){
                  accounts_template += `<h3 class="mb-1">${account.bank_name}</h3>
                  <p class="mb-1"><b>Titular :</b> ${account.titular}</p>
                  <p class="mb-1"><b>Dni :</b> ${account.dni}</p>
                  `
                  for(meta of account.metas){
                    accounts_template += `<p class="mb-1"><b>${meta["key"]} :</b> ${meta["value"]}</p>`
                  }
                  div.innerHTML = accounts_template
                }
                div.innerHTML += '</div>'
                
                let key_inputs = aw_payment_methods[i][1].key+"_inputs"
                div.innerHTML += aw_payment_methods[i][1][key_inputs]

                let aw_clone = document.importNode(template.content,true)
                div_payment_field.appendChild(aw_clone)
              }
            }
            
          })()
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
    ihc_payment_gateway_input.setAttribute("required")
    ihc_payment_selected_input.setAttribute("required")
  }
}

function aw_change_register_payment_method(e){

  const ihc_payment_gateway_input = document.querySelector("input[name=ihc_payment_gateway]")
  const ihc_payment_selected_input = document.querySelector("input[name=payment_selected]")
  const p_show = e.parentNode.parentNode.querySelectorAll("div.show")
  
  if(p_show.length > 0){
    p_show.forEach(p=>{
      p.classList.remove("show")
    })
  }
  if(ihc_payment_gateway_input && ihc_payment_selected_input){
    ihc_payment_gateway_input.value = e.value
    ihc_payment_selected_input.value = e.value
  }
}

async function print_payment_methods_data(){
  try {
    const req = await  fetch(`${rest_uri}aw-register-form/payment-methods`)
    const {data} = await req.json()
    return data
  } catch (error) {
    console.log(error)
  }
}

async function aw_register_payment(form_event) {
  const inputs = form_event.target.querySelectorAll('input') //extraemos los datos por defecto del formulario
  let account_data = {}
  inputs.forEach((input)=>{
        account_data[input.name] = input.value
  })
  
  if(account_data["user_login"] == "" || account_data["user_email"] == "" || account_data["pass1"] == ""){
    alert("faltan datos por completar")
    return 
  }
  if(!form_event.target.tos.checked){
    return alert("Acepte los terminos")
  }
  
  const req = await fetch(`${rest_uri}aw-payments/register-payment`,{
    method:'POST',
    body:JSON.stringify(account_data),
    headers:{
      "content-type":"application/json"
    }
  })
  await req.json()
}
