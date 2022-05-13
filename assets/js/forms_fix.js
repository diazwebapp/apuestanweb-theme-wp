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
      container_form.insertAdjacentHTML('afterbegin','<p class="divider-text"><span class="bg-light">OR</span></p>')
      if(div_social.length > 0){
        container_form.insertAdjacentHTML('afterbegin','<p id="social-links" ></p>')
        const container_social_links = container_form.querySelector('#social-links')
        div_social.forEach(social=>{
          const enlace = social.querySelector('a')
          enlace.classList.add('btn')
          enlace.classList.add('btn-block')
          
          container_social_links.appendChild(social)
        })
      }
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
    }

    //Register form
    const container_register_form = document.querySelector("div#aw-container-register-form")
    if(container_register_form){
      const register_form = container_register_form.querySelector("form")
      const div_register_social = register_form.querySelectorAll("div.ihc-sm-item")
      const div_register_payments = register_form.querySelectorAll(".ihc-js-select-payment")
      const register_form_divs = register_form.querySelectorAll("div")
      const register_countries = register_form.querySelectorAll("select#ihc_country_field option");
      //const product_details_table = register_form.querySelector("table.ihc-product-details-table")
      const product_subtotal_table = register_form.querySelectorAll("table.ihc-subtotal-table")
      const checkout_session = register_form.querySelector("div.ihc-js-checkout-session")
      const checkout_button = register_form.querySelector("div#ihc-checout-page-purchase-button-section")
      
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
      
      
      if(register_form){

        container_register_form.insertAdjacentHTML('afterbegin','<p class="divider-text"><span class="bg-light">OR</span></p>')
        if(div_register_social.length > 0){
          container_register_form.insertAdjacentHTML('afterbegin','<p id="social-links" ></p>')
          const container_social_links = container_register_form.querySelector('#social-links')
          div_register_social.forEach(social=>{
            const enlace = social.querySelector('a')
            enlace.classList.add('btn')
            enlace.classList.add('btn-block')
            
            container_social_links.appendChild(social)
          })
        }
        container_register_form.insertAdjacentHTML('afterbegin','<h4 class="card-title mt-3 text-center" style="color:black !important;">Create Acount</h4>')
        register_form.innerHTML += `
              <section class="form-group input-group">
                  <section class="input-group-prepend">
                      <span class="input-group-text"> <i class="fa fa-user"></i> </span>
                  </section>
                  <input type="email" class="form-control" name="user_email" placeholder="Email">
              </section>
              <section class="form-group input-group">
                <section class="input-group-prepend">
                    <span class="input-group-text"> <i class="fa fa-envelope"></i> </span>
                </section>
                  <input type="password" value="" class="form-control" name="pwd" placeholder="Password">
              </section>
    
              <section class="form-group input-group" id="country-field">
                <section class="input-group-prepend">
                    <span class="input-group-text"> <i class="fa fa-globe"></i> </span>
                </section>
                  <!-- dinamic content-->
              </section>

              <section class="form-group input-group" id="payment-select">
                  <!-- dinamic content-->
              </section>
    
              <section class="form-group">
                      <input type="submit" value="Login" class="btn btn-primary btn-block">
              </section>
          `
          // add select country to form
          const div_country_field = register_form.querySelector("section#country-field")
          div_country_field.appendChild(select_country_element) //select
          div_country_field.appendChild(datalist_countries) //datalist

          // add payment select to form
          const div_payment_field = register_form.querySelector("div#payment-select")
          //div_payment_field.appendChild(product_details_table) // detail payment
          div_register_payments.forEach(payment=>{
            div_payment_field.appendChild(payment) //payments
          })
          div_payment_field.appendChild(product_subtotal_table) // subtotal payment
          div_payment_field.appendChild(checkout_session) //add checkout session
          div_payment_field.appendChild(checkout_button) //add checkout button

          //remove form divs
          register_form_divs.forEach(div=>{
            div.remove()
          })
      }
    }
      
})