(function ($) {
    "use strict";

    $(window).on('load', function(){
        //===== Prealoder
        $("#preloader").delay(600).fadeOut("slow");
        
    });

    $(document).ready(function () {
        //05. sticky header
        function sticky_header(){
            var wind = $(window);
            var sticky = $('header');
            wind.on('scroll', function () {
                var scroll = wind.scrollTop();
                if (scroll < 100) {
                    sticky.removeClass('sticky');
                } else {
                    sticky.addClass('sticky');
                }
            });
        }
        sticky_header();
        //===== Back to top

        // Show or hide the sticky footer button
        $(window).on('scroll', function () {
            if ($(this).scrollTop() > 600) {
                $('.back-to-top').fadeIn(200)
            } else {
                $('.back-to-top').fadeOut(200)
            }
        });

        //Animate the scroll to yop
        $('.back-to-top').on('click', function (event) {
            event.preventDefault();

            $('html, body').animate({
                scrollTop: 0,
            }, 600);
        });

        // Hamburger-menu
        $('.hamburger-menu').on('click', function () {
            $('.hamburger-menu .line-top, .menu').toggleClass('current');
            $('.hamburger-menu .line-center').toggleClass('current');
            $('.hamburger-menu .line-bottom').toggleClass('current');
        });

        if ($(window).width() >= 768) {
            $('.question button').click(function(e) {
                e.preventDefault();
                e.stopPropagation();
            });
            $('#faq .collapse').addClass('show');
        }

        //10. Client Slider Initialize
        $('.owl-carousel.slider').owlCarousel({
            loop: true,
            nav: true,
            navText: [
                '<i class="fal fa-chevron-left"></i>',
                '<i class="fal fa-chevron-right"></i>'
            ],
            dots: true,
            items: 1,
            smartSpeed: 1000,
        });        

        $('.owl-carousel.slider2').owlCarousel({
            loop: true,
            navText: [
                '<i class="fa fa-angle-left"></i>',
                '<i class="fa fa-angle-right"></i>'
            ],
            dots: false,
            smartSpeed: 1000,
            margin: 30,
            stagePadding: 15,
            responsive: {
                0:{
                    items: 2,
                    margin: 15,
                    nav: true,
                },
                768: {
                    items: 3,
                },
                922: {
                    nav: false
                }
            }
        });
        //slider 3
        $('.slider__active').owlCarousel({
            loop: true,
            navText: [
                '<i class="fa fa-angle-right"></i>',
                '<i class="fa fa-angle-left"></i>'
            ],
            dots: false,
            smartSpeed: 1000,
            margin: 10,
            stagePadding: 100,
            responsive: {
                0: {
                    items: 1,
                    margin: 15,
                    stagePadding: 2,
                    nav: true,
                },
                768: {
                    items: 2,
                    stagePadding: 2,
                },
                922: {
                    items:2,
                    nav: true,
                    
                    stagePadding: 2,
                },
                1200: {
                    items: 3,
                    nav: true
                }
            }
        });

        // nice select
        const selects = document.getElementsByTagName('select')
        if(selects.length > 0){
            for(let select of selects){
                
                if(select.id == 'search_select'){
                    NiceSelect.bind(select,{searchable:true})
                }else{
                    NiceSelect.bind(select)
                }
            }
        }


        // collapse
        $('.parley_collapse_btn').click(function(){
            $('.parley_box').addClass('parley_box_shadow');
            $('.parley_box').removeClass('parley_box_shadow');
        });
    });




})(jQuery);