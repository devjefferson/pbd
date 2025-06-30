// =======================================
// OBTAINING DATA FROM THE CEP > BEGINNING
// =======================================

$('#cep').on('blur', function () {
    const cep = $(this).val().replace(/\D/g, '');
    if (cep.length === 8) {
        $.getJSON(`https://viacep.com.br/ws/${cep}/json/`, function (data) {
            if (!data.erro) {
                $('#rua').val(data.logradouro).trigger('keyup');
                $('#bairro').val(data.bairro).trigger('keyup');
                $('#cidade').val(data.localidade).trigger('keyup');
                $('#estado').val(data.uf).trigger('keyup'); // Adicionando a linha para preencher o estado
                $('#cep').next('.spans').text('');
            } else {
                $('#rua').val('');
                $('#bairro').val('');
                $('#cidade').val('');
                $('#estado').val(''); // Limpa o campo de estado em caso de erro
                $('#cep').next('.spans').text('CEP não encontrado.');
            }
        }).fail(function () {
            $('#rua').val('');
            $('#bairro').val('');
            $('#cidade').val('');
            $('#estado').val(''); // Limpa o campo de estado em caso de erro
            $('#cep').next('.spans').text('Erro ao buscar o CEP.');
        });
    } else if (cep.length === 0) {
        $('#cep').next('.spans').text('CEP é obrigatório.');
    } else {
        $('#cep').next('.spans').text('CEP inválido.');
    }
});

// =================================
// OBTAINING DATA FROM THE CEP > END
// =================================


// ==========================
// CPF VALIDATION > BEGINNING
// ==========================

function validateCPF(cpf) {
    cpf = cpf.replace(/[^\d]+/g, '');
    if (cpf.length !== 11 || /^(\d)\1{10}$/.test(cpf)) return false;

    let sum = 0;
    for (let i = 0; i < 9; i++) {
        sum += parseInt(cpf.charAt(i)) * (10 - i);
    }
    let rev = 11 - (sum % 11);
    if (rev === 10 || rev === 11) rev = 0;
    if (rev !== parseInt(cpf.charAt(9))) return false;

    sum = 0;
    for (let i = 0; i < 10; i++) {
        sum += parseInt(cpf.charAt(i)) * (11 - i);
    }
    rev = 11 - (sum % 11);
    if (rev === 10 || rev === 11) rev = 0;
    if (rev !== parseInt(cpf.charAt(10))) return false;

    return true;
}

// ====================
// CPF VALIDATION > END
// ====================

function validateRG(rg) {
    // Remove caracteres não numéricos
    const cleanRG = rg.replace(/\D/g, '');

    // O RG deve ter exatamente 9 dígitos
    if (cleanRG.length !== 9) {
        return false;
    }

    // Extrai os números e o dígito verificador
    const numbers = cleanRG.slice(0, 8).split('').map(Number);
    const verifier = parseInt(cleanRG[8], 10);

    // Cálculo do dígito verificador
    let sum = 0;
    for (let i = 0; i < numbers.length; i++) {
        sum += numbers[i] * (2 + i);
    }

    // Calcula o dígito esperado
    const remainder = sum % 11;
    let expectedVerifier;

    if (remainder === 0) {
        expectedVerifier = 0;
    } else if (remainder === 1) {
        expectedVerifier = 1; // Em alguns estados, pode ser 0. Isso varia.
    } else {
        expectedVerifier = 11 - remainder;
    }

    // Verifica se o dígito calculado corresponde ao fornecido
    return expectedVerifier === verifier;
}



