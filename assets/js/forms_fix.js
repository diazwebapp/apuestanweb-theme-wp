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
      
      //Create select
      const select_country_element = document.createElement("input")
      select_country_element.setAttribute("id","ihc_country_field")
      select_country_element.setAttribute("name","ihc_country")
      select_country_element.setAttribute("list","countries")
      //create datalist
      const datalist_countries = document.createElement("datalist")
      datalist_countries.setAttribute("id","countries")
      register_countries.forEach(country=>{
        datalist_countries.appendChild(country)
      })
      //remove form divs
      register_form_divs.forEach(div=>{
        div.remove()
      })
      
    }
    register_form.innerHTML += `
          <div class="form-group input-group">
              <div class="input-group-prepend">
                  <span class="input-group-text"> <i class="fa fa-user"></i> </span>
              </div>
              <input type="email" class="form-control" name="user_email" placeholder="Email">
          </div>
          <div class="form-group input-group">
            <div class="input-group-prepend">
                <span class="input-group-text"> <i class="fa fa-envelope"></i> </span>
            </div>
              <input type="password" value="" class="form-control" name="pwd" placeholder="Password">
          </div>

          <div class="form-group input-group" id="country-field">
            <div class="input-group-prepend">
                <span class="input-group-text"> <i class="fa fa-envelope"></i> </span>
            </div>
              <input type="password" value="" class="form-control" name="pwd" placeholder="Password">
          </div>

          <div class="form-group">
                  <input type="submit" value="Login" class="btn btn-primary btn-block">
          </div>

      `
      // add select country to form
      const div_country_field = register_form.querySelector("div#country-field")
      div_country_field.appendChild(select_country_element) //select
      div_country_field.appendChild(datalist_countries) //datalist
      
})