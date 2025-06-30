<?php
session_start();
include '../../conexoes/conexaoOFC.php';

// Captura os parâmetros
$columns = $_GET['columns'] ?? null;
$tableName = $_GET['table'] ?? null;
$id = isset($_GET['id']) ? intval($_GET['id']) : null;


if (!$tableName) {
    die("Tabela inválida.");
}

// Lista de tabelas válidas
$tabelasAceitas = ['empresas', 'funcionarios'];
if (!in_array($tableName, $tabelasAceitas)) {
    die("Tabela inválida.");
}

// Lista de colunas válidas
$colunasAceitas = [
    'id_empresa', 'id_funcionario', 'nome_func', 'rg', 'cpf', 'turno', 'sexo', 'escolaridade',
    'data_nasc', 'nome_empresa', 'cnpj', 'email', 'telefone', 'bairro', 'cep', 'estado', 'cidade',
    'rua', 'numero', 'complemento', 'telefone', 'celular'
];

// Verifica se as colunas são válidas
if (!$columns) {
    die("Colunas inválidas ou ausentes.");
}

$arrayColunas = explode(',', $columns);
foreach ($arrayColunas as $column) {
    if (!in_array(trim($column), $colunasAceitas)) {
        die("Coluna inválida: $column");
    }
}

// Valida o ID
if (filter_var($id, FILTER_VALIDATE_INT) === false) {
    die("ID inválido. O valor fornecido não é um inteiro.");
}

// Monta a query de acordo com a tabela selecionada
if ($tableName === 'empresas') {
    $query = "SELECT $columns FROM $tableName WHERE id_empresa = ?";
} elseif ($tableName === 'funcionarios') {
    $query = "SELECT $columns FROM $tableName WHERE id_funcionario = ?";
}

// Prepara a consulta
$stmt = $conn->prepare($query);
$stmt->bind_param('i', $id);
$stmt->execute();
$result = $stmt->get_result();
$data = $result->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Determina o nome da coluna da chave primária
    $id_column = $tableName === 'empresas' ? 'id_empresa' : 'id_funcionario';
    $id = $_POST[$id_column] ?? $id;

    // Atualiza os dados, excluindo `id_empresa` ou `id_funcionario`
    $updates = [];
    $values = [];

    foreach ($_POST as $column => $value) {
        if ($column !== $id_column) {
            $updates[] = "$column = ?";
            $values[] = $value;
        }
    }

    if (count($values) > 0) {
        $sql = "UPDATE $tableName SET " . implode(", ", $updates) . " WHERE $id_column = ?";
        $stmt = $conn->prepare($sql);

        // Adiciona o ID ao final dos valores
        $types = str_repeat('s', count($values)) . 'i'; // 's' para strings, 'i' para inteiros
        $values[] = $id;
        $stmt->bind_param($types, ...$values);
        $stmt->execute();

        // Redireciona após o sucesso para evitar reenvio do formulário
        header("Location: admin_" . $tableName . "OFC.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="edita.css">
    <link rel="stylesheet" href="../Geral/header.css">
    <link rel="stylesheet" href="../Geral/global.css">
    <title>Editar <?php echo ucfirst($tableName); ?></title>
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
    <form method="POST">
        <h2>Editar <?php echo ucfirst($tableName); ?></h2>
        <?php if ($data): ?>
            <?php foreach ($data as $column => $value): ?>
            <?php if (($tableName === 'empresas' && $column === 'id_empresa') || ($tableName === 'funcionarios' && $column === 'id_funcionario')): ?>
        <!-- Campo apenas visível (não enviado no POST) -->
        <div class="input_group">
            <div class="container_input">
                <label for="<?php echo $column; ?>"><?php echo ucfirst($column); ?></label>
                <input type="text" id="<?php echo $column; ?>" value="<?php echo htmlspecialchars($value); ?>" readonly>
            </div>
            <!-- Campo oculto para manter o ID correto -->
            <input type="hidden" name="<?php echo $column; ?>" value="<?php echo htmlspecialchars($value); ?>">
            <?php else: ?>
            <!-- Campos editáveis para outras colunas -->
            <div class="container_input">
                <label for="<?php echo $column; ?>"><?php echo ucfirst($column); ?>:</label>
                <input type="text" id="<?php echo $column; ?>" name="<?php echo $column; ?>" value="<?php echo htmlspecialchars($value); ?>">
            </div>
        </div>
        <?php endif; ?>
        <?php endforeach; ?>
        <button class="button" type="submit">Salvar</button>
        <?php else: ?>
        <p>Nenhum dado encontrado.</p>
        <?php endif; ?>
    </form>
</main>
</body>
</html>
                