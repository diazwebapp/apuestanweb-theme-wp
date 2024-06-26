$(document).ready(function () {


    /*archive-forecast.php*/
    var selector_category_f = $('button.loadmore.forecasts');
    $(selector_category_f).click(function (e) {
        e.preventDefault();
        $(this).text('loading...');
        var data = {
            'action': 'loadmore_forecast',
            'query': posts,
            'page': current_page,
            'model': model,
            "text_vip_link" : text_vip_link,
            'vip':vip,
            'unlock':unlock,
            'cpt':cpt,
            "time_format" : time_format,
        };
        
        $.ajax({
            url: ajaxurl,
            data: data,
            type: 'POST',
            success: function (data) {
                if (data) {
                    $(selector_category_f).text("Load more");
                    current_page++;
                    $('#games_list').append(data);
                    }else{
                        $(selector_category_f).text("no items");
                    }
            }
        });
    });

    
    let filter_forecast = $('select#element_select_forecasts');
    $(filter_forecast).change(e => filter(e));

    function filter(e){
        const date = e.target.value
        
        var data = {
            'action': 'filter_forecast',
            'query': posts,
            'model': model,
            'date':date,
            "text_vip_link" : text_vip_link,
            'vip':vip,
            'unlock':unlock,
            'cpt':cpt,
            "time_format" : time_format,
        };
       
        $.ajax({
            url: ajaxurl,
            data: data,
            type: 'POST',
            success: function (data) {
                
                var element = $('#games_list');
                if (data) {
                    $(element).html(data)
                    } else {
                        $(element).html('')
                } 
            }
        });
    };
    let select_odds = $('select#select_odds_format');
    select_odds.change(e =>handler_odds_format(e))
});
function test(param){
    let current_parley = param.attributes.data.textContent
    let amount = param.value
    let cuote = document.querySelector(`#jscuote_${current_parley }`)
    let result = document.querySelector(`#jsresult_${current_parley }`)
    if(cuote && result){
        result.innerHTML = parseFloat(cuote.value) * parseFloat(amount)
    }
}

// DOM for render
const date_items = document.querySelectorAll('.date_item_pronostico_top');

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
        if(SPAN_DAYS)   SPAN_DAYS.textContent = REMAINING_DAYS;
        if(SPAN_HOURS)  SPAN_HOURS.textContent = REMAINING_HOURS;
        if(SPAN_MINUTES)    SPAN_MINUTES.textContent = REMAINING_MINUTES;
        if(SPAN_SECONDS)    SPAN_SECONDS.textContent = REMAINING_SECONDS;
    
        if(REMAINING_DAYS <= 0 && REMAINING_HOURS <= 0 && REMAINING_MINUTES <= 0){
            let hora = DATE_TARGET.getHours() % 12
            let minutos = DATE_TARGET.getMinutes().toString().padStart(2,'0')
            let ampm = DATE_TARGET.getHours() > 12 ? 'pm' : 'am'
            html_element.innerHTML = `
                            <time datetime="${DATE_TARGET.getHours()}:${minutos}" >${hora}:${minutos} ${ampm}</time>
            `
        }
    }
}

//===
// INIT
//===

date_items.forEach(item=>{
    setInterval(()=>{
        updateCountdown(item)
    },1000)
})

function handler_odds_format(e){
    let format = e.target.value
    document.location = '?odds_format='+format
}