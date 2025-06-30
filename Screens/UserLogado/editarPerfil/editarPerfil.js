$(document).ready(function () {


  $('input').on('keyup change', function () {
      validateField(this);
  });

  const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

  function validateField(field) {
      const value = $(field).val().trim();
      const fieldName = $(field).attr('name');
      let errorMsg = '';

      switch (fieldName) {
          case 'email_atual':
              emailPattern
              errorMsg = value.length === 0 ? 'Email é obrigatório.' : !emailPattern.test(value) ? 'Email inválido.' : '';
              break;

          case 'novo_email':
              emailPattern
              errorMsg = value.length === 0 ? 'Email é obrigatório.' : !emailPattern.test(value) ? 'Email inválido.' : '';
              break;

      }

      $(field).next('.spans').text(errorMsg);
      return errorMsg.length === 0;
  }

  // Manipulação do formulário de cadastro
  $('#form_email').on('submit', function (e) {
      let isValid = true;

      $('input').each(function () {
          if (!validateField(this)) {
              isValid = false;
          }
      });

      // Verifica se as mensagens de erro estão vazias
      $('.spans').each(function () {
          if ($(this).text() !== '') {
              isValid = false;
              e.preventDefault();
          }
      });

      if (!isValid) {
          e.preventDefault();
      }
  });





function validateFieldSenha(field) {
    const value = $(field).val().trim();
    const fieldName = $(field).attr('name');
    let errorMsg = '';

    switch (fieldName) {
        case 'senha_atual':
            errorMsg =  value.length ===0 ? 'A senha Atual é obrigatória.' : ''
          break;
        case 'nova_senha':
            errorMsg =  value.length ===0 ? 'A nova senha é obrigatória.' :
                        value.length != 8 ? 'A nova senha deve ter 8 caracteres.' : '';
          break;
        case 'confirmar_senha':
            errorMsg =  value.length === 0 ? 'Confirme a nova senha.' :
                        value !== $('#nova_senha').val() ? 'As senhas não coincidem.' : '';
            break;

    }

    $(field).next('.spans').text(errorMsg);
    return errorMsg.length === 0;
}

// Manipulação do formulário de cadastro
$('#form_senha').on('submit', function (e) {
    let isValid = true;

    $('input').each(function () {
        if (!validateFieldSenha(this)) {
            isValid = false;
        }
    });

    // Verifica se as mensagens de erro estão vazias
    $('.spans').each(function () {
        if ($(this).text() !== '') {
            isValid = false;
            e.preventDefault();
        }
    });

    if (!isValid) {
        e.preventDefault();
    }

  });

if ($('#validateMessage').length > 0 || $('#errorMessage').length > 0) {
    setTimeout(function() {
        $('#validateMessage').fadeOut(); 
        $('#errorMessage').fadeOut(); 
    }, 2000);
}

});

