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

    // $(document).ready(function(){
    //     // Verificar si la resolución es menor a 768px
        
    //     if (window.innerWidth < 768) {
    //         // Desactivar sticky
    //         $(".share-buttons-container").trigger("sticky_kit:detach");
    //     } else {
    //         // Activar sticky
    //         $(".share-buttons-container").stick_in_parent({
    //             offset_top: 20,
    //             parent: ".post-content",
    //             spacer: ".sticky-spacer"
    //         });
    
    //         // Eventos para agregar/eliminar clase is_stuck
    //         $(document).on("sticky_kit:unstick", ".share-buttons-container", function(e) {
    //             $(".share-buttons-container").removeClass("is_stuck");
    //         });
            
    //         $(document).on("sticky_kit:bottom", ".share-buttons-container", function(e) {
    //             $(".share-buttons-container").removeClass("is_stuck");
    //         });
    
    //         $(document).on("sticky_kit:unbottom", ".share-buttons-container", function(e) {
    //             $(".share-buttons-container").addClass("is_stuck");
    //         });
    
    //         $(document).on("sticky_kit:stick", ".share-buttons-container", function(e) {
    //             $(".share-buttons-container").addClass("is_stuck");
    //         });
    //     }

        
    // });
    document.addEventListener("DOMContentLoaded", function() {
        $("#table-of-contents").on("hide.bs.collapse show.bs.collapse", function() {
            $(this).prev().find(".fas").toggleClass("fa-angle-down fa-angle-up");
          });
        const contentDiv = document.querySelector(".single_event_content");
        const headers = contentDiv.querySelectorAll("h2, h3");
        const toc = document.querySelector("#table-of-contents .list-group");
    
        headers.forEach(header => {
          // Obtener el contenido de texto del encabezado
          const headerText = header.textContent.trim();
    
          // Crear un ID único para cada encabezado basado en su contenido de texto
          const headerId = headerText
            .toLowerCase()
            .replace(/[^\wáéíóúüñ\s]/g, "") // Remover caracteres especiales
            .replace(/\s+/g, "-"); // Reemplazar espacios por guiones
    
          // Asignar el ID único al encabezado
          header.id = headerId;
    
          // Crear el enlace para la tabla de contenido
          const link = document.createElement("a");
          link.href = `#${headerId}`;
          link.textContent = headerText;
          link.classList.add("list-group-item", "list-group-item-action");
    
          // Indentar subencabezados para mejorar la legibilidad
          if (header.tagName === "H3") {
            link.style.marginLeft = "20px";
          }
    
          toc.appendChild(link);
        });
    
        // Desplazamiento suave al hacer clic en un enlace en la tabla de contenido
        const tocLinks = document.querySelectorAll("#table-of-contents .list-group-item");
        tocLinks.forEach(link => {
          link.addEventListener("click", function(e) {
            e.preventDefault();
            const targetId = this.getAttribute("href");
            const targetElement = document.querySelector(targetId);
    
            if (targetElement) {
              targetElement.scrollIntoView({ behavior: "smooth" });
              history.pushState(null, null, targetId); // Actualizar la URL con el ID de la sección
            }
          });
        });
      });
    
      // Manejar el evento "popstate" para actualizar la tabla de contenido al usar el botón Atrás/Navegación
      window.addEventListener("popstate", function() {
        const hash = window.location.hash;
        if (hash) {
          const targetElement = document.querySelector(hash);
          if (targetElement) {
            targetElement.scrollIntoView({ behavior: "smooth" });
          }
        }
      });


})(jQuery);