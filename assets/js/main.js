
document.addEventListener("DOMContentLoaded", () => {
        // Selecciona el botón de "volver al principio"
        const backToTopButton = document.querySelector('.back-to-top');

        // Asegúrate de que el botón exista en el DOM
        if (backToTopButton) {
            // Mostrar u ocultar el botón según la posición del scroll
            window.addEventListener('scroll', () => {
                // Obtén la cantidad de píxeles desplazados desde la parte superior
                const scrollPosition = window.scrollY;
    
                if (scrollPosition > 600) {
                    // Si el desplazamiento es mayor a 600 píxeles, muestra el botón
                    backToTopButton.style.display = 'block'; // Cambia la propiedad display para mostrar
                    backToTopButton.style.opacity = '1'; // Aplica opacidad completa
                } else {
                    // Si el desplazamiento es menor o igual a 600 píxeles, oculta el botón
                    backToTopButton.style.opacity = '0'; // Inicia el fade-out
                    setTimeout(() => {
                        // Asegúrate de ocultarlo completamente después de la animación
                        if (window.scrollY <= 600) {
                            backToTopButton.style.display = 'none';
                        }
                    }, 200); // Espera 200ms para completar el efecto de fade-out
                }
            });
    
            // Desplazamiento suave hacia la parte superior al hacer clic en el botón
            backToTopButton.addEventListener('click', (event) => {
                event.preventDefault(); // Previene el comportamiento predeterminado del botón
                // Usa scrollTo con la opción behavior: 'smooth' para animar el desplazamiento
                window.scrollTo({
                    top: 0, // Posición de destino (parte superior de la página)
                    behavior: 'smooth' // Animación suave
                });
            });
        }

    // Hamburger-menu
    const hamburgerMenu = document.querySelector('.hamburger-menu');
    const menu = document.querySelector('.menu');
    const lineTop = document.querySelector('.hamburger-menu .line-top');
    const lineCenter = document.querySelector('.hamburger-menu .line-center');
    const lineBottom = document.querySelector('.hamburger-menu .line-bottom');

    if (hamburgerMenu) {
        hamburgerMenu.addEventListener('click', () => {
            if (lineTop) lineTop.classList.toggle('current');
            if (lineCenter) lineCenter.classList.toggle('current');
            if (lineBottom) lineBottom.classList.toggle('current');
            if (menu) menu.classList.toggle('current');
        });
    }

    // FAQ section logic for window width >= 768px
    if (window.innerWidth >= 768) {
        const questionButtons = document.querySelectorAll('.question button');
        const faqCollapseElements = document.querySelectorAll('#faq .collapse');

        questionButtons.forEach(button => {
            button.addEventListener('click', (e) => {
                e.preventDefault();
                e.stopPropagation();
            });
        });

        faqCollapseElements.forEach(collapse => {
            collapse.classList.add('show');
        });
    }
    // Collapse functionality for table of contents without jQuery
    const tocElement = document.querySelector("#table-of-contents");
    const button = document.querySelector('[data-toggle="collapse"]');
    const targetId = button?.getAttribute('data-target');
    const targetElement = document.querySelector(targetId);

    if (button && targetElement) {
        button.addEventListener('click', () => {
            targetElement.classList.toggle('show'); // Alternar la clase .show
        });
    }
    if (tocElement) {
        const toggleIcon = (action) => {
            const icon = tocElement.previousElementSibling.querySelector(".fas");
            if (icon) {
                icon.classList.toggle("fa-angle-down", action === "hide");
                icon.classList.toggle("fa-angle-up", action === "show");
            }
        };

        // Escuchar los eventos personalizados de Bootstrap para collapse
        tocElement.addEventListener("show.bs.collapse", () => toggleIcon("show"));
        tocElement.addEventListener("hide.bs.collapse", () => toggleIcon("hide"));
    }

    // Dynamically generate Table of Contents
    const contentDiv = document.querySelector(".single_event_content");
    const tocList = document.querySelector("#table-of-contents .list-group");

    if (contentDiv && tocList) {
        const headers = contentDiv.querySelectorAll("h2, h3");

        headers.forEach((header) => {
            const headerText = header.textContent.trim();
            const headerId = headerText
                .toLowerCase()
                .replace(/[^\wáéíóúüñ\s]/g, "") // Remove special characters
                .replace(/\s+/g, "-"); // Replace spaces with dashes

            // Assign unique ID to header
            header.id = headerId;

            // Create link for the table of contents
            const link = document.createElement("a");
            link.href = `#${headerId}`;
            link.textContent = headerText;
            link.classList.add("list-group-item", "list-group-item-action");

            // Indent subheadings
            if (header.tagName === "H3") {
                link.style.marginLeft = "20px";
            }

            tocList.appendChild(link);
        });

        // Add smooth scrolling for TOC links
        tocList.querySelectorAll(".list-group-item").forEach((link) => {
            link.addEventListener("click", (e) => {
                e.preventDefault();
                const targetId = link.getAttribute("href");
                const targetElement = document.querySelector(targetId);

                if (targetElement) {
                    targetElement.scrollIntoView({ behavior: "smooth" });
                    if (history.state !== targetId) {
                        history.pushState(null, null, targetId);
                    }
                }
            });
        });
    }

    // Changue odds format
    let select_odds = document.querySelector('select#select_odds_format');
    select_odds.addEventListener('change', function(e) {
        handler_odds_format(e);
    });

    // Handle browser navigation with smooth scrolling
    window.addEventListener("popstate", () => {
        const hash = window.location.hash;
        if (hash) {
            const targetElement = document.querySelector(hash);
            if (targetElement) {
                targetElement.scrollIntoView({ behavior: "smooth" });
            }
        }
    });

    let dropdowns = document.querySelectorAll('.dropdown-toggle'); 
    dropdowns.forEach(function(dropdown) {
        dropdown.addEventListener('click', function() { 
            this.classList.toggle('dropdown-active'); 
        }); 
    });

    if (typeof(Storage) !== 'undefined') {
        let respuesta = localStorage.getItem('age_user');
        
        if (respuesta !== null && respuesta === 'no') {
            document.write('');
        }
        if (respuesta === null) {
            let modal = document.getElementById('modal_age_terms');
            if (modal) {
                modal.style.display = 'grid';
            }
        }
    }

    let btn_quitar_notificaciones = document.querySelector('p#btn_quitar_notificaciones');
        btn_quitar_notificaciones.addEventListener('click', function(e) {
            quitar_notificaciones();
        });

    // Improved collapse functionality for parley buttons
    const parleyButtons = document.querySelectorAll(".parley_collapse_btn");
    if (parleyButtons.length > 0) {
        parleyButtons.forEach((button) => {
            button.addEventListener("click", () => {
                const parleyBoxes = document.querySelectorAll(".parley_box");
                parleyBoxes.forEach((box) => {
                    box.classList.toggle("parley_box_shadow");
                });
            });
        });
    }
});

////////////////////metodos//////////////////
function handler_odds_format(e){
    alert('')
    let format = e.target.value
    document.location = '?odds_format='+format
}
function setAge(resp){
    
    let text = resp.textContent
    let modal = document.getElementById('modal_age_terms')
    
    if(text == 'no'){
        localStorage.setItem('age_user', 'no')
        document.write('')
    }
    if(text == 'si'){
        localStorage.setItem('age_user', 'si')
    }
    
    modal.remove()
}


const quitar_notificaciones = async() =>{
    let p_username = document.querySelector("#header-username")
    let counter_html = document.querySelector("#notification-counter")
    let username = false
    if(p_username){
        username = p_username.textContent
    }
    let request = await fetch(`/wp-json/aw-notificaciones/clear-all`,{
        method:'post',
        body:JSON.stringify({username}),
        headers:{
            "content-type" : "application/json"
        }
    });
    if(request.status == 200){
        let response = await request.json()
        if(counter_html && response.status == "ok"){
            counter_html.textContent = 0
        }
    }else{
        console.log("hubo un error 500")
    }
}

const quitar_notificacion = async(element)=>{
    let post_id = element.getAttribute("data-postid")
    let p_username = document.querySelector("#header-username")
    let counter_html = document.querySelector("#notification-counter")
    let username = false
    if(p_username){
        counter = parseInt(counter_html.textContent)
        username = p_username.textContent
    }
    let request = await fetch(`/wp-json/aw-notificaciones/clear-one`,{
        method:'post',
        body:JSON.stringify({username,post_id}),
        headers:{
            "content-type" : "application/json"
        }
    });
    if(request.status == 200){
        let response = await request.json()
        
        if(counter_html && response.status == "ok"){
            counter_html.textContent = counter - 1
            window.location = response.redirect
        }
    }else{
        console.log("hubo un error 500")
    }
}

window.addEventListener('popstate', function (e) {
    window.history.back()
});
