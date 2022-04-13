$(document).ready(function () {

    $('.subscribe-block button').on('click', function (event) {
        event.preventDefault();
        var email = $('.subscribe-block input').val();
        var data = {
            'action': 'subscribe_mailchimp',
            'postmail': email,
        };
        if (email) {
            $.ajax({
                url: custom_ajax_url,
                data: data,
                type: 'POST',
                success: function (data) {
                    if (data === '1') {
                        $('.subscribe-block input').val('');
                        alert('Вы успешно подписались! Спасибо!');
                    } else {
                        alert('Ошибка, попробуйте еще раз.');
                    }
                }
            });
        } else {
            alert('Введите валидную почту.');
        }
    });

    $('.set_rating input').change(function () {
        var $radio = $(this);
        $('.set_rating .selected').removeClass('selected');
        $radio.closest('label').addClass('selected');

    });

    /*category.php*/
    var selector_category = $('button.loadmore.cat');
    $(selector_category).click(function (e) {
        e.preventDefault();
        $(this).text('Загружаю...');
        var data = {
            'action': 'loadmore_categories',
            'query': posts,
            'page': current_page
        };
        $.ajax({
            url: ajaxurl,
            data: data,
            type: 'POST',
            success: function (data) {
                if (data) {
                    $(selector_category).text("Загрузить еще");
                    current_page++;
                    $('.flex2').append(data);
                    if (current_page == max_pages) $(selector_category).remove();
                } else {
                    $(selector_category).remove();
                }
            }
        });
    });


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
            'cpt':cpt
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

    /*load posts*/
    var selector_loadmore_posts = $('button.loadmore.posts');
    $(selector_loadmore_posts).click(function (e) {
        e.preventDefault();
        $(this).text('loading...');
        var data = {
            'action': 'loadmore_posts',
            'query': posts,
            'page': current_page,
            'model': model,
            "link" : link,
            "text_link" : text_link,
            "vip_link" : vip_link,
            "text_vip_link" : text_vip_link,
            'vip':vip,
            'unlock':unlock,
            'cpt':cpt
        };
        
        $.ajax({
            url: ajaxurl,
            data: data,
            type: 'POST',
            success: function (data) {
                if (data) {
                    $(selector_loadmore_posts).text("ver más");
                    current_page++;
                    $('#posts_list').append(data);
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
            'cpt':cpt
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
/*archive-forecast.php*/