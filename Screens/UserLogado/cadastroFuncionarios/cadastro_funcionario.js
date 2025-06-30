$(document).ready(function () {

    // Aplicação de máscara aos inputs
    $('#cpf').mask('000.000.000-00');
    $('#rg').mask('00.000.000-0');
    $('#data_nasc').mask('00/00/0000');
    $('#cep').mask('00000-000');
    $('#numero').mask('00000');

    $('input, select, textarea').on('keyup change', function () {
        validateField(this);
    });

    function validateField(field) {
        const value = $(field).val().trim();
        const fieldName = $(field).attr('name');
        let errorMsg = '';

        switch (fieldName) {
            case 'nome_func':
                if (value.length === 0) {
                    errorMsg = 'Nome do funcionário é obrigatório.';
                } else if (value.length < 15) {
                    errorMsg = 'Nome do funcionário deve ter no mínimo 15 caracteres';
                }
                break;

            case 'email':
                const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                errorMsg = value.length === 0 ? 'Email é obrigatório.' : !emailPattern.test(value) ? 'Email inválido.' : '';
                break;

            case 'rg':
                if (value.length === 0) {
                    errorMsg = 'RG é obrigatório.';
                } else if (!validateRG(value)) {
                    errorMsg = 'RG inválido. Verifique se o número está correto.';
                }
                break;

            case 'cpf':
                if (value.length === 0) {
                    errorMsg = 'CPF é obrigatório.';
                } else if (!validateCPF(value)) {
                    errorMsg = 'CPF inválido.';
                }
                break;

            case 'data_nasc':
                const dataPattern = /^(0[1-9]|[12][0-9]|3[01])[\/](0[1-9]|1[012])[\/]\d{4}$/;
                if (value.length === 0) {
                    errorMsg = 'Data de Nascimento é obrigatória.';
                } else if (!dataPattern.test(value)) {
                    errorMsg = 'Data de Nascimento inválida. Formato esperado: DD/MM/AAAA';
                }
                break;

            case 'turno':
                if (value.length === 0) {
                    errorMsg = 'Turno Disponível é obrigatório.';
                }
                break;

            case 'escolaridade':
                if (value.length === 0) {
                    errorMsg = 'Grau de Escolaridade é obrigatório.';
                }
                break;

            case 'sexo':
                if (value.length === 0) {
                    errorMsg = 'Sexo é obrigatório.';
                }
                break;
            case 'rua':
                if (value.length === 0) {
                    errorMsg = 'Rua é obrigatório.';
                }
                    break;
            case 'bairro':
                if (value.length === 0) {
                    errorMsg = 'Bairro é obrigatório.';
                }
                break;
            case 'cidade':
                if (value.length === 0) {
                    errorMsg = 'Cidade é obrigatório.';
                }
                break;
            case 'estado':
                if (value.length === 0) {
                    errorMsg = 'Estado é obrigatório.';
                }
                break;

            case 'cep':
                const cepPattern = /^\d{5}-\d{3}$/;
                if (value.length === 0) {
                    errorMsg = 'CEP é obrigatório.';
                } else if (!cepPattern.test(value)) {
                    errorMsg = 'CEP inválido. Formato esperado: 00000-000';
                }
                break;

            case 'numero':
                if (value.length === 0) {
                    errorMsg = 'Número é obrigatório.';
                }
                break;

            default:
                break;
        }

        $(field).next('.spans').text(errorMsg);
        return errorMsg.length === 0;
    }

    // Manipulação do formulário de cadastro
    $('#form').on('submit', function (e) {
        let isValid = true;

        $('input, select').each(function () {
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
            $('#successMessage').hide(); // Oculta a mensagem de sucesso se houver erro
        }

        if (isValid) {
            $('#successMessage').text('Cadastro realizado com sucesso!').css('color', 'green').show(); // Exibe a mensagem de sucesso
            setTimeout(function () {
                $('#successMessage').hide();
            }, 3000); // 3000 milissegundos = 3 segundos
        } else {
            $('#successMessage').hide(); // Oculta a mensagem de sucesso se houver erro
        }
    });

    // Limpar campos do formulário de cadastro
    $('#clearBtn').on('click', function () {
        $('#form')[0].reset(); // Limpa todos os inputs
        $('.spans').text(''); // Limpa todas as mensagens de erro
        $('#successMessage').text('').hide(); // Esconde a mensagem de sucesso
    });

});
