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
              <section class="form-group input-group">
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
                  <div id="payment-select" >
                    
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
          const div_payment_field = register_form.querySelector("div#payment-select")
          
          //add term conditions
          const tos_field = register_form.querySelector("section#terms")
          tos_field.appendChild(tos)
          
          div_payment_field.appendChild(checkout_session) //add checkout session
          div_payment_field.appendChild(checkout_button) //add checkout button
          
          
          //div_register_payments
          let payment_methods_array = Object.entries(php_payment_services)
          let template = document.querySelector("#temp")
          if(template){
            let label = template.content.querySelector('label')
            let input = template.content.querySelector('input')
            let p = template.content.querySelector('p')
            
            for(let i = 0; i < payment_methods_array.length; i++){
              label.textContent = payment_methods_array[i][1]
              label.setAttribute('for',payment_methods_array[i][0])

              

              p.id = payment_methods_array[i][0]

              p.innerHTML = `<div class="col-12 text-start">
              <p class="mt-2">
                1. Usamos la tasa de cambio oficial del BCV  &nbsp;&nbsp;<b> Bs/USD <strong id="tasaFomato">5,16</strong> </b>
              </p>
              <p class="mt-2">2. Paga desde tu banco el total de <b id="Monto">Bs. 185,40</b> <i>(El IVA está incluido)</i></p>
              
              <p class="mt-2">3. Usa nuestros datos de transferencia bancaria<br>
                                     <b> Bco. Banesco Cta. Cte:</b><br>
                                      0134 0038 59 0381059561<br><b>
                                      A nombre de:</b><br>
                                      A.C. CONTENIDOS PARA LA INFORMACIÓN Y FORMACIÓN (COFEIN)<br><b>
                                      RIF:</b> J-40842480-0
                                  </p>
              <p class="mt-2">4. Reporta tu pago a continuación</p>
            </div>`

              input.value = payment_methods_array[i][0]
              input.name = "aw-payment-radio"
              input.id = payment_methods_array[i][0]

              input.setAttribute("data-target",`#${payment_methods_array[i][0]}`)
              input.setAttribute("aria-controls",`${payment_methods_array[i][0]}`)
              
              if(payment_methods_array[i][0] == 'paypal_express_checkout'){
                input.checked = true
                aw_default_register_payment_method(register_form,payment_methods_array[i][0])
              }

              if(payment_methods_array[i][0] !== 'bank_transfer'){
                let clone = document.importNode(template.content,true)
                div_payment_field.appendChild(clone)
              }
            }
          }
        }
        
      }
      
})
function aw_default_register_payment_method(register_form,method){

  const ihc_payment_gateway_input = register_form.querySelector("input[name=ihc_payment_gateway]")
  const ihc_payment_selected_input = register_form.querySelector("input[name=payment_selected]")
  if(ihc_payment_gateway_input && ihc_payment_selected_input){
    ihc_payment_gateway_input.value = method
    ihc_payment_selected_input.value = method
  }
}

function aw_change_register_payment_method(e){

  const ihc_payment_gateway_input = document.querySelector("input[name=ihc_payment_gateway]")
  const ihc_payment_selected_input = document.querySelector("input[name=payment_selected]")
  const p_show = e.parentNode.parentNode.querySelectorAll("p.show")
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