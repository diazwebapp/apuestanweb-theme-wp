
document.addEventListener("DOMContentLoaded", () => {
    // Cache de elementos para evitar múltiples selecciones
    const backToTopButton = document.querySelector('.back-to-top');
    const hamburgerMenu = document.querySelector('.hamburger-menu');
    const menu = document.querySelector('.menu');
    const tocElement = document.querySelector("#table-of-contents");
    const contentDiv = document.querySelector(".single_event_content");
    const tocList = document.querySelector("#table-of-contents .list-group");
    const dropdowns = document.querySelectorAll('.dropdown-toggle');
    const btnQuitarNotificaciones = document.querySelector('p#btn_quitar_notificaciones');
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
            ['line-top', 'line-center', 'line-bottom'].forEach(className => {
                const line = document.querySelector(`.hamburger-menu .${className}`);
                if (line) line.classList.toggle('current');
            });
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
            dropdown.classList.toggle('dropdown-active');
        });
    });

    // LocalStorage and modal display
    const ageResponse = localStorage.getItem('age_user');
    if (ageResponse === 'no') {
        document.body.innerHTML = '';
    } else if (!ageResponse && modalAgeTerms) {
        modalAgeTerms.style.display = 'grid';
    }

    // Remove notifications functionality
    if (btnQuitarNotificaciones) {
        btnQuitarNotificaciones.addEventListener('click', async () => {
            const usernameElement = document.querySelector("#header-username");
            const counterElement = document.querySelector("#notification-counter");
            const username = usernameElement?.textContent;

            try {
                const response = await fetch('/wp-json/aw-notificaciones/clear-all', {
                    method: 'POST',
                    headers: { "Content-Type": "application/json" },
                    body: JSON.stringify({ username })
                });

                if (response.ok) {
                    const result = await response.json();
                    if (counterElement && result.status === "ok") {
                        counterElement.textContent = 0;
                    }
                }
            } catch (error) {
                console.error("Error clearing notifications:", error);
            }
        });
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
});

function handler_odds_format(e){
    let format = e.target.value
    document.location = '?odds_format='+format
}
