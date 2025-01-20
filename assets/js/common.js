let date_items = document.querySelectorAll('.date_item_pronostico_top');
    
//////////////FILTRADO DE FECHAS EN PRONOSTICOS

///////////////////////////////// 
function parley_calc_cuotes(param){
    let current_parley = param.attributes.data.textContent
    let amount = param.value
    let cuote = document.querySelector(`#jscuote_${current_parley}`)
    let result = document.querySelector(`#jsresult_${current_parley}`)
    
    if(cuote && result){
        let final_cuote = parseFloat(cuote.value) * parseFloat(amount)
        result.innerHTML = final_cuote.toFixed(2)
    }
}
function updateCountdown(html_element) {
    const INPUT_DATE = html_element.querySelector('#date');
    const SPAN_DAYS = html_element.querySelector('#date_dias');
    const SPAN_HOURS = html_element.querySelector('#date_horas');
    const SPAN_MINUTES = html_element.querySelector('#date_minutos');
    const SPAN_SECONDS = html_element.querySelector('#date_segundos');

    if(INPUT_DATE){

        const DATE_TARGET = new Date(INPUT_DATE.value);
        
        // Milliseconds for the calculations
        const MILLISECONDS_OF_A_SECOND = 1000;
        const MILLISECONDS_OF_A_MINUTE = MILLISECONDS_OF_A_SECOND * 60;
        const MILLISECONDS_OF_A_HOUR = MILLISECONDS_OF_A_MINUTE * 60;
        const MILLISECONDS_OF_A_DAY = MILLISECONDS_OF_A_HOUR * 24
    
        // Calcs
        const NOW = new Date()
        const DURATION = DATE_TARGET - NOW;
        const REMAINING_DAYS = Math.floor(DURATION / MILLISECONDS_OF_A_DAY);
        const REMAINING_HOURS = Math.floor((DURATION % MILLISECONDS_OF_A_DAY) / MILLISECONDS_OF_A_HOUR);
        const REMAINING_MINUTES = Math.floor((DURATION % MILLISECONDS_OF_A_HOUR) / MILLISECONDS_OF_A_MINUTE);
        const REMAINING_SECONDS = Math.floor((DURATION % MILLISECONDS_OF_A_MINUTE) / MILLISECONDS_OF_A_SECOND);
   
        // Render
        
        if(SPAN_DAYS){
            SPAN_DAYS.innerHTML = REMAINING_DAYS + "D:" ;
        }   
        if(SPAN_HOURS)  SPAN_HOURS.innerHTML = REMAINING_HOURS + "H:";
        if(SPAN_MINUTES)    SPAN_MINUTES.innerHTML = REMAINING_MINUTES + "M:";
        if(SPAN_SECONDS)    SPAN_SECONDS.innerHTML = REMAINING_SECONDS + "S";
    
        if(REMAINING_DAYS <= 0 && REMAINING_HOURS <= 0 && REMAINING_MINUTES <= 0){
            let hora = DATE_TARGET.getHours() % 12
            let minutos = DATE_TARGET.getMinutes().toString().padStart(2,'0')
            let ampm = DATE_TARGET.getHours() > 12 ? 'pm' : 'am'
            html_element.innerHTML = `
                            <time datetime="${hora}:${minutos}" >${hora}:${minutos} ${ampm}</time>
            `
        }
    }
}
function init_countdown(date_items){
    date_items.forEach(item=>{
        setInterval(()=>{
            updateCountdown(item)
        },1000)
    })
}
if(date_items.length > 0){
    init_countdown(date_items)
}

/////////////BOTON CARGAR MÁS (PAGINACIÓN) DE PRONOSTICOS

const div_game_list = document.querySelector('#games_list')

async function load_more_items(e){
    let cano = document.querySelector('[rel="canonical"]')
    const inditator_page = document.querySelector('#current-page-number')
    const previus_text = e.textContent
    e.innerHTML = '°°°'
    
    let old_page = forecasts_fetch_vars.paged
    
    forecasts_fetch_vars.paged++
    
    let params = "?paged="+forecasts_fetch_vars.paged;
    params += "&posts_per_page="+forecasts_fetch_vars.posts_per_page;
    params += forecasts_fetch_vars.leagues ? "&leagues="+forecasts_fetch_vars.leagues:"";
    params += forecasts_fetch_vars.date ? "&date="+forecasts_fetch_vars.date:"";
    params += "&model="+forecasts_fetch_vars.model;
    params += forecasts_fetch_vars.time_format ? "&time_format="+forecasts_fetch_vars.time_format:"";
    params += forecasts_fetch_vars.country_code ? "&country_code="+forecasts_fetch_vars.country_code:"";
    params += forecasts_fetch_vars.timezone ? "&timezone="+forecasts_fetch_vars.timezone:"";
    params += forecasts_fetch_vars.text_vip_link ? "&text_vip_link="+forecasts_fetch_vars.text_vip_link:"";
    params += forecasts_fetch_vars.unlock ? "&unlock="+forecasts_fetch_vars.unlock:"";
    params += "&current_user_id="+forecasts_fetch_vars.current_user_id;
    params += "&odds="+forecasts_fetch_vars.odds;
    const request = await fetch(forecasts_fetch_vars.rest_uri+params)
    const response = await request.json()
    
    if(response.max_pages == forecasts_fetch_vars.paged){
        e.remove()
        inditator_page.textContent = forecasts_fetch_vars.paged
    }
    
    if(response.status == 'ok'){
        e.setAttribute("data-page",forecasts_fetch_vars.paged)
        
        const searchTerm = 'page/';
        if(inditator_page){
            inditator_page.textContent = forecasts_fetch_vars.paged
        }
        
        const url = new URL(window.location);
        let page = window.location.pathname.indexOf(searchTerm)
        if(page == -1){
            url.pathname += 'page/'+forecasts_fetch_vars.paged+'/'
        } else {
            old_page = "/"+old_page
            const old_page_number = url.pathname.indexOf(old_page)
            if(old_page_number != -1){
                url.pathname = url.pathname.replace(new RegExp(old_page, 'ig'), "");              
                url.pathname += response.page + "/"
            }
        }
        
        window.history.pushState({}, '', url);
        if(cano){
            cano.href = url
        }
        
        forecasts_fetch_vars.paged = response.page
        div_game_list.innerHTML += response.html
        e.textContent = previus_text 
        let date_items = document.querySelectorAll('.date_item_pronostico_top');
        if(date_items.length > 0){
            init_countdown(date_items)
        }               
    }else{
        div_game_list.innerHTML = response.html
        e.remove()
    }
}
async function filter_date_items(e){
    const inditator_page = document.querySelector('#current-page-number')
    const indicator_max_page = document.querySelector('#max-page-number')
    forecasts_fetch_vars.date = e.value
    
    let params = "?paged="+1;
    params += "&posts_per_page="+forecasts_fetch_vars.posts_per_page;
    params += forecasts_fetch_vars.leagues ? "&leagues="+forecasts_fetch_vars.leagues:"";
    params += forecasts_fetch_vars.date ? "&date="+forecasts_fetch_vars.date:"";
    params += "&model="+forecasts_fetch_vars.model;
    params += forecasts_fetch_vars.time_format ? "&time_format="+forecasts_fetch_vars.time_format:"";
    params += forecasts_fetch_vars.country_code ? "&country_code="+forecasts_fetch_vars.country_code:"";
    params += forecasts_fetch_vars.timezone ? "&timezone="+forecasts_fetch_vars.timezone:"";
    params += forecasts_fetch_vars.text_vip_link ? "&text_vip_link="+forecasts_fetch_vars.text_vip_link:"";
    params += forecasts_fetch_vars.unlock ? "&unlock="+forecasts_fetch_vars.unlock:"";
    params += "&current_user_id="+forecasts_fetch_vars.current_user_id;
    params += "&odds="+forecasts_fetch_vars.odds;

    const request = await fetch(forecasts_fetch_vars.rest_uri+params)
    const response = await request.json()
    
    let class_item =  e.getAttribute('data-type') 
    const div_container_pagination_forecasts = document.querySelector('.container_pagination_'+class_item)
    
    if(response.status == 'ok'){
        
        forecasts_fetch_vars.paged = response.page
        div_game_list.innerHTML = response.html
        let date_items = document.querySelectorAll('.date_item_pronostico_top');
        
        if(response.max_pages > 1){
            div_container_pagination_forecasts.innerHTML = forecasts_fetch_vars.btn_load_more            
            inditator_page.textContent = forecasts_fetch_vars.paged
            indicator_max_page.textContent = response.max_pages
        }else{
            document.querySelector("#load_more_"+class_item) ? document.querySelector("#load_more_"+class_item).remove() : null
            inditator_page.textContent = response.page
            indicator_max_page.textContent = response.max_pages
        }
        if(date_items.length > 0){
            init_countdown(date_items)
        }  
    }else{
        div_game_list.innerHTML = response.html
        document.querySelector("#load_more_"+class_item) ? document.querySelector("#load_more_"+class_item).remove() : null
        inditator_page.textContent = 0
        indicator_max_page.textContent = 0

    }
    let page = window.location.pathname.indexOf("/page/")
    if(page != -1){
        const url = new URL(window.location)
        let new_pathname = url.pathname.split("/");
        url.pathname = new_pathname[1] + "/"
        window.history.pushState({}, '', url);
    }
}
