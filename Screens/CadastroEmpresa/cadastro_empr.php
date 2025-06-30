<?php
// Chamar o conexão.php
// include '../conexao.php';
include '../../conexoes/conexaoOFC.php';


if (isset($_POST['cadastrar'])) {
    // Receber e sanitizar os dados do formulário usando isset para verificar se os campos foram enviados
    $nome_empresa = isset($_POST['nome_empresa']) ? $conn->real_escape_string($_POST['nome_empresa']) : '';
    $email = isset($_POST['email']) ? $conn->real_escape_string($_POST['email']) : '';
    $senha = isset($_POST['senha']) ? password_hash($_POST['senha'], PASSWORD_DEFAULT) : '';
    $cnpj = isset($_POST['cnpj']) ? $conn->real_escape_string($_POST['cnpj']) : '';
    $cep = isset($_POST['cep']) ? $conn->real_escape_string($_POST['cep']) : '';
    $estado = isset($_POST['estado']) ? $conn->real_escape_string($_POST['estado']) : '';
    $cidade = isset($_POST['cidade']) ? $conn->real_escape_string($_POST['cidade']) : '';
    $bairro = isset($_POST['bairro']) ? $conn->real_escape_string($_POST['bairro']) : '';
    $rua = isset($_POST['rua']) ? $conn->real_escape_string($_POST['rua']) : '';
    $numero = isset($_POST['numero']) ? $conn->real_escape_string($_POST['numero']) : '';
    $complemento = isset($_POST['complemento']) ? $conn->real_escape_string($_POST['complemento']) : '';
    $telefone = isset($_POST['telefone']) ? $conn->real_escape_string($_POST['telefone']) : '';
    $celular = isset($_POST['celular']) ? $conn->real_escape_string($_POST['celular']) : '';


            // Consulta para inserir os dados no banco de dados
            $sql = "INSERT INTO empresas (nome_empresa, email, senha, cnpj, cep, estado, cidade, bairro, rua, numero, complemento, telefone, celular) 
                    VALUES ('$nome_empresa', '$email', '$senha', '$cnpj', '$cep', '$estado', '$cidade', '$bairro', '$rua', '$numero', '$complemento', '$telefone', '$celular')";

            // Executa a consulta e verifica se foi bem-sucedida
            if ($conn->query($sql) === TRUE) {
                header("Location: ../../Screens/Login/login.php");
                exit; // Sempre utilizar exit após o redirecionamento
            } else {
                echo "Erro: " . $sql . "<br>" . $conn->error;
            }
      }
  
  // Fechar a conexão
  $conn->close();
  ?>
