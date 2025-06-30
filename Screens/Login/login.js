$(document).ready(function () {
    // Evento ao submeter o formulário de login
    $('#loginForm').on('submit', function (e) {
        

        let email = $('#loginEmail').val();
        let senha = $('#loginPassword').val();

        // Verifica se o email ou a senha estão vazios
        if (email === '' || senha === '') {
            e.preventDefault();
            $('#errorMessage').text('Usuário ou senha incompletos').show();
            return;
        }

    });

    // Função para limpar o formulário de login
    $('#clearLogin').on('click', function () {
        $('#loginForm')[0].reset(); // Limpa todos os inputs do formulário de login
        $('#errorMessage').text('').hide(); // Limpa a mensagem de erro e esconde
        $('#loginMessage').text('').hide(); // Limpa a mensagem de sucesso e esconde
    });




      
});
