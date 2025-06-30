// SECTION > THREE > BEGINNING
$(document).ready(function() {
    
$('.cell').mask('(00) 00000-0000'); 

// Seleciona o elemento com ID "name" do documento HTML
const inputName = $("#name");

// Anexa um ouvinte de evento "keypress" ao campo de entrada
inputName.on("keypress", function(e) {
    // Chama a função checkChar para validar o caractere pressionado
    if (!checkChar(e)) {
        // Se checkChar retornar falso (ou seja, o caractere não é uma letra)
        // Prevenir o comportamento padrão (inserir o caractere)
        e.preventDefault();
    }
});

// Função para verificar se o caractere pressionado é uma letra
function checkChar(e) {
    // Extrai o código de caractere do objeto de evento
    const char = String.fromCharCode(e.keyCode);
    // Define um padrão de expressão regular para letras (incluindo acentuadas)
    const pattern = '[ A-Za-zÀ-ú]';

    // Verifica se o caractere corresponde ao padrão
    if (char.match(pattern)) {
        // Se for uma letra, retorne true (permitir o caractere)
        return true;
    }
}

$('#contactForm').on('submit', function(e) {
    // Adiciona um evento ao formulário quando ele é submetido
    // Impede o envio padrão do formulário
    
    const name = $('#name').val();
    const email = $('#email').val();
    const cell = $('#cell').val();
    const message = $('#message').val(); 
    // Obtém os valores dos campos do formulário

    let isValid = true; 
    // Variável para verificar se o formulário é válido

    // NAME FIELD VALIDATION > BEGINNING

    if (name.length < 3) {
        $('#nameError').text('Por favor, preencha seu nome.'); 
        // Mensagem de erro
        isValid = false; 
        // Marca o formulário como inválido
    } else {
        $('#nameError').text(''); 
        // Limpa a mensagem de erro
    }

    // NAME FIELD VALIDATION > END

    // EMAIL FIELD VALIDATION > BEGINNING

    const emailRegex = /^\w+([-+.']\w+)*@\w+([-.]\w*)*\.\w+([-.]\w+)*$/; 
    // Regex para validação de email

    if (email === '') {
        $('#emailError').text('Por favor, preencha seu email.'); 
        // Mensagem de erro
        isValid = false; 
        // Marca o formulário como inválido
    } else if (!emailRegex.test(email)) {
        $('#emailError').text('Por favor, insira um email válido.'); 
        // Mensagem de erro
        isValid = false; 
        // Marca o formulário como inválido
    } else {
        $('#emailError').text(''); 
        // Limpa a mensagem de erro
    }

    // EMAIL FIELD VALIDATION > END

    // CELL FIELD VALIDATION > BEGINNING

    if (cell === '') {
        $('#cellError').text('Por favor, preencha com o número do seu celular.'); 
        // Mensagem de erro
        isValid = false; 
        // Marca o formulário como inválido
    } else if (cell.length < 15) {
        $('#cellError').text('Por favor, insira um número válido'); 
        // Mensagem de erro
        isValid = false; 
        // Marca o formulário como inválido
    } else {
        $('#cellError').text(''); 
        // Limpa a mensagem de erro
    }

    // CELL FIELD VALIDATION > END

    // VALIDATION OF THE MESSAGE FIELD > BEGINNING

    if (message === '') {
        $('#messageError').text('Por favor, preencha a mensagem.'); 
        // Mensagem de erro
        isValid = false; 
        // Marca o formulário como inválido
    } else {
        $('#messageError').text(''); 
        // Limpa a mensagem de erro
    }

    if (isValid === false) {
        e.preventDefault(); 
    }

    // VALIDATION OF THE MESSAGE FIELD > END

    if (isValid) {
        // Se todos os campos forem válidos, exibe a mensagem de sucesso e reseta o formulário
        // Reseta o formulário
        $('#formSent').text('Formulário enviado com sucesso!'); 
        // Mensagem de sucesso
        setTimeout(function() {
            // Remove a mensagem de sucesso após 3 segundos
            $('#formSent').text(''); 
            // Limpa a mensagem de sucesso
        }, 3000);
    }
});
})
// SECTION > THREE > END