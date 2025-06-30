// ==========================
// LOGGED IN USER > BEGINNING
// ==========================


    // =====================
    // USER MENU > BEGINNING
    // =====================

const menu_logado = $('.menu-logado'); 
// Seleciona o menu logado

$('.user_logado').on('click', function() { 
    // Alterna a visibilidade do menu logado

    if (menu_logado.css('opacity') == 0) { 
        // Verifica se o menu está invisível

        menu_logado.css({'opacity': '1', 'visibility': 'visible'}); 
        // Torna o menu visível

    } else { 
        menu_logado.css({'opacity': '0','visibility': 'hidden'}); 
        // Torna o menu invisível
    }
});


$(document).on('click', function(event) {
    // Verifica se o clique foi fora do menu logado ou do usuário logado

    if (!$(event.target).closest('.menu-logado, .user_logado').length) { 
        $('.menu-logado').css({'opacity': '0', 'visibility': 'hidden'}); 
        // Torna o menu invisível
    }
});

    // =====================
    // USER MENU > BEGINNING
    // =====================


// ====================
// LOGGED IN USER > END
// ====================
