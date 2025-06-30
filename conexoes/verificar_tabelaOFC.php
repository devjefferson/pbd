<?php

if (isset($_SESSION['is_admin']) && $_SESSION['is_admin'] == 1) {
    // Administrador pode acessar tudo
    $where = null;
} else {
    // Usuário comum pode acessar apenas dados relacionados ao id_empresa ou id_funcionario
    if ($tableName === 'empresas' && isset($id_empresa)) {
        $where = ['id_empresa' => $id_empresa];
    } elseif ($tableName === 'funcionarios' && isset($id_funcionario)) {
        $where = ['id_funcionario' => $id_funcionario];
    } else {
        $where = null; // Define como null se nenhum dos dois estiver definido ou a tabela não corresponder
    }
}

// Buscar os dados
try {
    $result = fetchData($tableName, $columns, $where, $conn);
} catch (mysqli_sql_exception $e) {
    die("Erro na consulta: " . $e->getMessage());
}