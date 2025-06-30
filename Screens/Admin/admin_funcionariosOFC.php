<?php
include '../../dashboard_adminOFC.php';
$id_empresa = $_SESSION['user_id'];
// Definir tabela e colunas com base no tipo de exibição
$tableName = $_GET['table'] ?? 'funcionarios';
$columns = $_GET['columns'] ?? 'id_funcionario,id_empresa,nome_func,rg,cpf,data_nasc,turno,escolaridade,email,sexo,cep,estado,cidade,bairro,rua,numero,complemento';
$isAdmin = $_GET['isAdmin'] ?? TRUE;
include '../../conexoes/buscarOFC.php';
include '../../conexoes/verificar_tabelaOFC.php';
unset($_POST['id_empresa']);

?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="admin_funcionarios.css">
    <link rel="stylesheet" href="../Geral/header.css">
    <link rel="stylesheet" href="../Geral/global.css">
    <title>Funcionários Cadastrados</title>
</head> 
<body>
    <header>
        <div class="container">
            <nav class="nav-menu">
                <a href="../UserLogado/user_logado.php">
                    <div>Inicio</div>
                </a>
                <a href="admin_empresasOFC.php">
                    <div>Voltar</div>
                </a>
            </nav> <!-- class="nav-menu" FIM -->
        </div> <!-- class="container" FIM -->
    </header>
        
    <main>
        <h2><?php echo ucfirst($tableName); ?> Cadastrados</h2>
        <?php echo generateTable($result, $tableName, $columns); 
        
        // Fechar a conexão
        $conn->close();
        ?>
    </main>
</body>
</html>