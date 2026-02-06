 const btnMenu = document.getElementById('btnMenuMobile');
    const menu = document.getElementById('menuPrincipal');

    // Abre / fecha menu ao clicar no botão
    btnMenu.addEventListener('click', () => {
        menu.classList.toggle('aberto');
    });

    // Fecha o menu ao clicar em um link (somente no mobile)
    const links = menu.querySelectorAll('.nav-link');
    links.forEach(link => {
        link.addEventListener('click', () => {
            if (window.innerWidth <= 768) {
                menu.classList.remove('aberto');
            }
        });
    });

    // Garante que ao redimensionar para desktop o menu fique sempre visível
    window.addEventListener('resize', () => {
        if (window.innerWidth > 768) {
            menu.classList.remove('aberto');
        }
    });

    