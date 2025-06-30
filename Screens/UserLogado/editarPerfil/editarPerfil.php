<?php
include '../../../dashboard_userOFC.php';
//include '../../../buscarOFC.php';

// Obtém o ID da empresa (usuário logado)
$id_empresa = $_SESSION['user_id'];

// Inicializa variáveis para mensagens e erros
$message = '';
$error = '';

// Processa as alterações
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obter dados do formulário
    $email_atual = filter_input(INPUT_POST, 'email_atual', FILTER_SANITIZE_EMAIL);
    $novo_email = filter_input(INPUT_POST, 'novo_email', FILTER_SANITIZE_EMAIL);
    $senha_atual = filter_input(INPUT_POST, 'senha_atual', FILTER_SANITIZE_STRING);
    $nova_senha = filter_input(INPUT_POST, 'nova_senha', FILTER_SANITIZE_STRING);
    $confirmar_senha = filter_input(INPUT_POST, 'confirmar_senha', FILTER_SANITIZE_STRING);

    // Consulta os dados atuais no banco
    $sql = "SELECT email, senha FROM empresas WHERE id_empresa = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $id_empresa);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();
        $senha_hash = $user['senha'];
        $email_atual_banco = $user['email'];

        // Verificar se o email precisa ser alterado
        if ($novo_email && $novo_email !== $email_atual_banco) {
            if ($email_atual === $email_atual_banco) {
                $sql = "UPDATE empresas SET email = ? WHERE id_empresa = ?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param('si', $novo_email, $id_empresa);

                if ($stmt->execute()) {
                    $messageEmail .= "Email atualizado com sucesso! ";
                } else {
                    $errorEmail .= "Erro ao atualizar o email. ";
                }
            } else {
                $errorEmail .= "O email atual está incorreto. ";
            }
        }

        // Verificar se a senha precisa ser alterada
        if ($nova_senha && password_verify($senha_atual, $senha_hash)) {
            if ($nova_senha === $confirmar_senha) {
                $nova_senha_hash = password_hash($nova_senha, PASSWORD_DEFAULT);
                $sql = "UPDATE empresas SET senha = ? WHERE id_empresa = ?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param('si', $nova_senha_hash, $id_empresa);

                if ($stmt->execute()) {
                    $messageSenha .= "Senha atualizada com sucesso!";
                } else {
                    $errorSenha .= "Erro ao atualizar a senha.";
                }
            } else {
                $errorSenha .= "As novas senhas não coincidem.";
            }
        } elseif ($nova_senha) {
            $errorSenha .= "A senha atual está incorreta.";
        }
    } else {
        $error = "Usuário não encontrado.";
    }
}

?>


