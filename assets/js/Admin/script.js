/*
 * ----------------------------------------------------------------------------
 * Propiedad de <Armando Josue Velasquez Delgado> <<https://armandovelasquez.com>>
 * Todos los derechos reservados. Ninguna parte de este software puede ser 
 * reproducida, distribuida o transmitida de ninguna forma o por ningún medio, 
 * electrónico o mecánico, incluyendo fotocopias, grabaciones o cualquier otro 
 * sistema de almacenamiento y recuperación de información, sin el permiso 
 * previo por escrito del autor.
 * ----------------------------------------------------------------------------
 */

document.addEventListener("DOMContentLoaded", function () {
    
    // Const
    const sidebar = document.getElementById('sidebar');
    const nav = document.getElementById('nav');
    const title_page = document.getElementById('title_page_sidebar');
    const allSideDivider = document.querySelectorAll('#sidebar .divider');
    const allDropdown = document.querySelectorAll('#sidebar .side-dropdown');
    const dropdownLinks = document.querySelectorAll('#sidebar .side-dropdown a:first-child');
    const toggleSidebarButton = document.querySelector('nav .toggle-sidebar');
    const scrollTopButton = $("#btn_top");
    const profileImage = document.querySelector('nav .profile img');
    const profileDropdown = document.querySelector('nav .profile .profile-link');

    // Obtener la ruta exacta
    const currentUri = window.location.href;
    const currentUrl = window.location.pathname;
    const url = currentUri.substring(currentUrl.length);
    const domain = window.location.origin;
    const url_x = currentUri.substring(url.length);
    const URL = domain + url_x;

    function showDropdownText() {
        allSideDivider.forEach(item => {
            item.textContent = '-';
            title_page.style.display = 'none';

            allDropdown.forEach(i => {
                const aLink = i.parentElement.querySelector('a:first-child');
                aLink.classList.remove('active');
                i.classList.remove('show');
            })
        });
    }

    function showOriginalDropdownText() {
        allSideDivider.forEach(item => {
            item.textContent = item.dataset.text;
            title_page.style.display = 'grid';

        });
    }

    function toggleProfileDropdown() {
        profileDropdown.classList.toggle('show');
    }

    function activateLinks(selector) {
        const links = document.querySelectorAll(selector);
        links.forEach(link => {
            const linkUrl = link.getAttribute("href");

            if (URL === linkUrl) {
                link.classList.add("active");
                link.closest("li").classList.add("active");
            }
        });
    }

    // Redimencionar sidebar por ancho de la patanlla
    function checkWidth() {
        if (window.innerWidth <= 800) {
            sidebar.classList.add("hide");
            title_page.style.display = 'none';
            showDropdownText();
            toggleSidebarButton.innerHTML = '<i class="bx bx-menu-alt-left"></i>';
            nav.style.marginLeft = '70px';
        } else {
            sidebar.classList.remove("hide");
            showOriginalDropdownText();
            toggleSidebarButton.innerHTML = '<i class="bx bx-menu"></i>';
            nav.style.marginLeft = '230px';
            title_page.style.display = 'grid';
        }
    }

    function handleScrollTop() {
        $("html, body").animate({ scrollTop: 0 }, 800);
        return false;
    }

    function handleDropdownClick(event) {

        const clickedItem = this;
        const allDropdowns = document.querySelectorAll('#sidebar .side-dropdown');

        allDropdowns.forEach(item => {
            const aLink = item.parentElement.querySelector('a:first-child');

            if (aLink !== clickedItem) {
                aLink.classList.remove('active');
                item.classList.remove('show');
            }
        });

        clickedItem.classList.toggle('active');
        const dropdown = clickedItem.parentElement.querySelector('.side-dropdown');
        dropdown.classList.toggle('show');
    }

    // Eventos
    dropdownLinks.forEach(link => {
        link.addEventListener('click', handleDropdownClick);
    });

    allDropdown.forEach(item => {
        const a = item.parentElement.querySelector('a:first-child');
        a.addEventListener('click', function (e) {
            e.preventDefault();

            if (!this.classList.contains('active')) {
                allDropdown.forEach(i => {
                    const aLink = i.parentElement.querySelector('a:first-child');

                    aLink.classList.remove('active');
                    i.classList.remove('show');
                })
            }

            this.classList.toggle('active');
            item.classList.toggle('show');
        })
    });

    sidebar.addEventListener('mouseenter', function () {
        if (this.classList.contains('hide')) {
            showOriginalDropdownText();
        }
    });

    sidebar.addEventListener('mouseleave', function () {
        if (this.classList.contains('hide')) {
            showDropdownText();
        }
    });

    // Switch de sidevar al presionar el boton
    toggleSidebarButton.addEventListener('click', function () {
        sidebar.classList.toggle('hide');
        if (sidebar.classList.contains('hide')) {
            title_page.style.display = 'none';
            toggleSidebarButton.innerHTML = '<i class="bx bx-menu-alt-left"></i>';
            nav.style.marginLeft = '70px';
            showDropdownText();
            localStorage.setItem('sidebarState', 'hidden');
        } else {
            toggleSidebarButton.innerHTML = '<i class="bx bx-menu"></i>';
            showOriginalDropdownText();
            nav.style.marginLeft = '230px';
            localStorage.setItem('sidebarState', 'visible');
            title_page.style.display = 'grid';
        }
    });

    // Verificar si el sidebar esta en hidden o no
    function verificar_estado_sidebar(storedState) {
        if (storedState == 'hidden') {
            sidebar.classList.add('hide');
            toggleSidebarButton.innerHTML = '<i class="bx bx-menu-alt-left"></i>';
            nav.style.marginLeft = '70px';
            showDropdownText();
        } else {
            sidebar.classList.remove('hide');
            toggleSidebarButton.innerHTML = '<i class="bx bx-menu"></i>';
            nav.style.marginLeft = '230px';
            showOriginalDropdownText();
        }
    }


    // Agregar event listener para cerrar la lista cuando se hace clic fuera de ella
    document.addEventListener('click', function (event) {
        const profile = document.querySelector('.profile');
        const profileDropdown = document.querySelector('.profile .profile-link');

        if (!profile.contains(event.target)) {
            // El clic se produjo fuera del elemento .profile
            profileDropdown.classList.remove('show');
        }
    });

    profileImage.addEventListener('click', toggleProfileDropdown);

    // Boton para ir hacia arriba
    scrollTopButton.hide();
    $(window).scroll(function () {
        if ($(this).scrollTop() > 100) {
            scrollTopButton.fadeIn();
        } else {
            scrollTopButton.fadeOut();
        }
    });
    scrollTopButton.click(handleScrollTop);

    // Activadores de navegacion
    activateLinks(".side-menu a");
    activateLinks(".contenedor_config a");
    activateLinks(".profile-link a");
    activateLinks(".more-button-list a");

    checkWidth();
    window.addEventListener("resize", checkWidth);

});


