
document.addEventListener("DOMContentLoaded", () => {
    // Cache de elementos para evitar múltiples selecciones
    const backToTopButton = document.querySelector('.back-to-top');
    const hamburgerMenu = document.querySelector('.hamburger-menu');
    const menu = document.querySelector('.menu');
    const tocElement = document.querySelector("#table-of-contents");
    const contentDiv = document.querySelector(".single_event_content");
    const tocList = document.querySelector("#table-of-contents .list-group");
    const dropdowns = document.querySelectorAll('.dropdown-toggle');
    const nav_tabs = document.querySelectorAll('.nav-tabs');
    const modalAgeTerms = document.getElementById('modal_age_terms');
    let select_odds = document.querySelector('select#select_odds_format');
    
    // Changue odds format
    select_odds.addEventListener('change', function(e) {
        handler_odds_format(e);
    });

    // Función de throttling
    const throttle = (callback, delay) => {
        let isThrottled = false;
        return (...args) => {
            if (!isThrottled) {
                callback(...args);
                isThrottled = true;
                setTimeout(() => {
                    isThrottled = false;
                }, delay);
            }
        };
    };

    // Back to top button functionality
 

// Back to top button functionality
        if (backToTopButton) {
            const handleScroll = throttle(() => {
                const scrollPosition = window.scrollY;
                if (scrollPosition > 200) {
                    backToTopButton.style.display = 'block';
                    backToTopButton.style.opacity = '1';
                } else {
                    backToTopButton.style.opacity = '0';
                    setTimeout(() => {
                        if (window.scrollY <= 200) {
                            backToTopButton.style.display = 'none';
                        }
                    }, 200);
                }
            }, 100);

            window.addEventListener('scroll', handleScroll);
            
            backToTopButton.addEventListener('click', (event) => {
                event.preventDefault();
                window.scrollTo({
                    top: 0,
                    behavior: 'smooth'
                });
            });
        }


    // Hamburger menu functionality
  
    if (hamburgerMenu) {
        hamburgerMenu.addEventListener('click', () => {
            const lines = hamburgerMenu.querySelectorAll(`span`);
            if (lines.length > 0){
                lines.forEach(line =>{line.classList.toggle('current')})
            }        
            if (menu) menu.classList.toggle('current');
        });
    }

    // FAQ section logic for wide screens
    if (window.innerWidth >= 768) {
        document.querySelectorAll('.question button').forEach(button => {
            button.addEventListener('click', (e) => {
                e.preventDefault();
                e.stopPropagation();
            });
        });

        document.querySelectorAll('#faq .collapse').forEach(collapse => {
            collapse.classList.add('show');
        });
    }

    // Collapse functionality for Table of Contents
    if (tocElement) {
        const button = document.querySelector('[data-toggle="collapse"]');
        const targetId = button?.getAttribute('data-target');
        const targetElement = document.querySelector(targetId);

        if (button && targetElement) {
            button.addEventListener('click', () => {
                targetElement.classList.toggle('show');
            });
        }

        const toggleIcon = (action) => {
            const icon = tocElement.previousElementSibling.querySelector(".fas");
            if (icon) {
                icon.classList.toggle("fa-angle-down", action === "hide");
                icon.classList.toggle("fa-angle-up", action === "show");
            }
        };

        tocElement.addEventListener("show.bs.collapse", () => toggleIcon("show"));
        tocElement.addEventListener("hide.bs.collapse", () => toggleIcon("hide"));
    }

    // Generate Table of Contents dynamically
    if (contentDiv && tocList) {
        const headers = contentDiv.querySelectorAll("h2, h3");
        const fragment = document.createDocumentFragment();

        headers.forEach(header => {
            const headerText = header.textContent.trim();
            const headerId = headerText
                .toLowerCase()
                .replace(/[^\wáéíóúüñ\s]/g, "")
                .replace(/\s+/g, "-");

            header.id = headerId;

            const link = document.createElement("a");
            link.href = `#${headerId}`;
            link.textContent = headerText;
            link.classList.add("list-group-item", "list-group-item-action");

            if (header.tagName === "H3") link.style.marginLeft = "20px";
            fragment.appendChild(link);
        });

        tocList.appendChild(fragment);

        tocList.querySelectorAll(".list-group-item").forEach(link => {
            const targetElement = document.querySelector(link.getAttribute("href"));
            if (targetElement) {
                link.addEventListener("click", (e) => {
                    e.preventDefault();
                    targetElement.scrollIntoView({ behavior: "smooth" });
                });
            }
        });
    }

    // Dropdown toggles
    dropdowns.forEach(dropdown => {
        dropdown.addEventListener('click', () => {
            if(dropdown.attributes["aria-expanded"].value == 'false'){
                dropdown.attributes["aria-expanded"].value = true
            }else{
                dropdown.attributes["aria-expanded"].value = false
            }
            let menus = document.querySelectorAll('.dropdown-menu')
            menus.forEach(element => {
                if(element.attributes["aria-labelledby"].value == dropdown.id){
                    element.classList.toggle('show')
                }
            });
        });
    });
    // nav_tabs
    nav_tabs.forEach(tab => {
        let nav_links = tab.querySelectorAll('.nav-link')
        
        
        nav_links.forEach(link => {
            let parent = tab.parentElement
            let tab_contents = parent.querySelectorAll('.tab-pane')
            
            link.addEventListener('click', e =>{
                e.preventDefault()
                if(link.attributes["aria-selected"].value == 'false'){
                    tab_contents.forEach(element => {
                        if(element.attributes["aria-labelledby"].value == link.id){
                            element.classList.toggle('active')
                            element.classList.toggle('show')
                            
                        }else{
                            element.classList.remove('active')
                            element.classList.remove('show')
                        }
                    }); 
                    nav_links.forEach(link2 => {
                        link2.attributes["aria-selected"].value = false
                        link2.classList.remove('active')
                    })
                    link.attributes["aria-selected"].value = true
                    link.classList.toggle('active')
                }else{
                    return
                }
                
            })
             
        });
    });
    // LocalStorage and modal display
    const ageResponse = localStorage.getItem('age_user');
    if (ageResponse === 'no') {
        document.body.innerHTML = '';
    } else if (!ageResponse && modalAgeTerms) {
        modalAgeTerms.style.display = 'grid';
    }


    // Parley button functionality
    document.querySelectorAll(".parley_collapse_btn").forEach(button => {
        button.addEventListener("click", () => {
            document.querySelectorAll(".parley_box").forEach(box => {
                box.classList.toggle("parley_box_shadow");
            });
        });
    });

    // Smooth scrolling for browser navigation
    window.addEventListener("popstate", () => {
        const hash = window.location.hash;
        if (hash) {
            document.querySelector(hash)?.scrollIntoView({ behavior: "smooth" });
        }
    });

    ///////////Search//////////////
    // Obtén elementos DOM
    var openModalBtn = document.getElementById('open-search-modal');
    var closeModalBtn = document.getElementById('close-search-modal');
    var modal = document.getElementById('search-modal');

    // Abrir la ventana modal al hacer clic en el icono de búsqueda
    openModalBtn.addEventListener('click', function () {
        modal.style.display = 'block';
    });

    // Cerrar la ventana modal al hacer clic en el botón de cierre
    closeModalBtn.addEventListener('click', function () {
        modal.style.display = 'none';
    });

    // Cerrar la ventana modal al hacer clic fuera de ella
    window.addEventListener('click', function (event) {
        if (event.target === modal) {
            modal.style.display = 'none';
        }
    });

// Captura el evento keyup en el campo de búsqueda
document.getElementById('search').addEventListener('keyup', async function () {
    const searchQuery = this.value;

    // Realiza la solicitud AJAX solo si hay al menos 3 caracteres
    if (frontendajax.url && searchQuery.length >= 3) {
        try {
            const formData = new URLSearchParams();
            formData.append('action', 'custom_search');
            formData.append('search_query', searchQuery);

            const response = await fetch(frontendajax.url, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: formData.toString(),
            });

            const data = await response.json();
            
            if (data.success) {
                // Muestra los resultados en la ventana modal
                document.getElementById('search-results').innerHTML = data.results;
            } else {
                // Muestra un mensaje de error si no hay resultados
                document.getElementById('search-results').innerHTML = data.message;
            }
        } catch (error) {
            console.error('Error:', error);
        }
    } else {
        // Si el campo de búsqueda tiene menos de 3 caracteres, vacía los resultados
        document.getElementById('search-results').innerHTML = '';
    }
});

});

function handler_odds_format(e){
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