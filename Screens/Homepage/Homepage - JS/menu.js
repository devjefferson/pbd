// SCROLLING LINKS > BEGINNING

$(document).ready(function() {
    // Espera o DOM estar completamente carregado antes de executar o código

    const header = $('header'); 
    // Seleciona o elemento <header> e o armazena na constante

    let ignoreScroll = false; 
    // Variável para controlar se a rolagem deve ser ignorada

    const closeMenu = () => {
        // Função para fechar o menu mobile

        $('.menu-button').removeClass('active'); 
        // Remove a classe 'active' do botão do menu

        $('#menu').removeClass('show'); 
        // Remove a classe 'show' do menu, ocultando-o
    };

    const smoothNavigateTo = target => {
        // Função para navegar suavemente até um alvo específico

        closeMenu(); 
        // Fecha o menu antes de navegar

        ignoreScroll = true; 
        // Ignora rolagem durante a animação

        header.addClass('hidden'); 
        // Oculta o cabeçalho
        
        $('html, body').animate({
            // Anima a rolagem da página até a posição do alvo

            scrollTop: $(target).offset().top 
            // Define a posição de rolagem

        }, 800, () => setTimeout(() => ignoreScroll = false, 300)); 
        // Permite rolagem novamente após 300ms
    };

    $('.click-disappear').on('click', function(event) {
        // Adiciona um evento de clique a todos os links que devem ocultar o menu

        event.preventDefault(); 
        // Impede o comportamento padrão do link

        smoothNavigateTo(this.getAttribute('href')); 
        // Chama a função de navegação suave
    });

    let lastScrollTop = 0; 
    // Variável para armazenar a última posição do scroll
    
    $(window).on('scroll', function() {
        // Evento de scroll para mostrar ou ocultar o cabeçalho

        if (ignoreScroll) return; 
        // Ignora a rolagem se estiver em navegação suave

        const scrollTop = $(this).scrollTop(); 
        // Obtém a posição atual do scroll

        header.toggleClass('hidden', scrollTop > lastScrollTop); 
        // Adiciona ou remove a classe 'hidden' com base na direção do scroll

        lastScrollTop = scrollTop; 
        // Atualiza a última posição do scroll
    });

// SCROLLING LINKS > END

const btnMenu = $('.menu-button');
const menu = $('#menu');

// BUTTON MENU > BEGINNING

btnMenu.on('click', function(e) {
    $(this).toggleClass('active');
    menu.toggleClass('show');
    e.stopPropagation();
});

// BUTTON MENU > END

// CLOSE THE MENU IF YOU CLICK OUTSIDE > BEGINNING

$(document).on('click', function(e) {
    const clickMenu = menu.is(e.target) || menu.has(e.target).length > 0;
    const clickButton = btnMenu.is(e.target) || btnMenu.has(e.target).length > 0;

    if (!clickMenu && !clickButton) {
        menu.removeClass('show');
        btnMenu.removeClass('active');
    }
});

// CLOSE THE MENU IF YOU CLICK OUTSIDE > END

});