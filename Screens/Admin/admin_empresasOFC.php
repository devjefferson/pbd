<?php
include '../../dashboard_adminOFC.php';
$id_empresa = $_SESSION['user_id'];
// Definir tabela e colunas com base no tipo de exibição
$tableName = $_GET['table'] ?? 'empresas';
$columns = $_GET['columns'] ?? 'id_empresa,nome_empresa,email,cnpj,cep,estado,cidade,bairro,rua,numero,complemento,telefone,celular';
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
    <link rel="stylesheet" href="../Geral/header.css">
    <link rel="stylesheet" href="../Geral/global.css">
    <link rel="stylesheet" href="admin_empresas.css">
    <title>Empresas Cadastradas</title>
</head>
<body>

<header>
    <div class="container">
        <nav class="nav-menu">
            <a href="../UserLogado/user_logado.php">
                <div>Inicio</div>
            </a>
        </nav> <!-- class="nav-menu" FIM -->
    </div> <!-- class="container" FIM -->
</header>

<main>
    <h2><?php echo ucfirst($tableName); ?> Cadastradas</h2>
    <?php echo generateTable($result, $tableName, $columns); ?>
</main>

<?php
// Fechar a conexão
$conn->close();
?>

</body>
</html>
