<?php
include 'conexaoOFC.php';
/**
 * Busca dados de uma tabela com condições opcionais.
 *
 * @param string $table Nome da tabela.
 * @param string $columns Colunas a serem buscadas.
 * @param array|null $where Condições (exemplo: ['id_empresa' => $id]).
 * @param mysqli $conn Conexão do banco de dados.
 * @return mysqli_result|false Resultado da consulta ou false em caso de erro.
 */ 

function fetchData($tableName, $columns, $where = null, $conn) { //Executar uma consulta SQL na tabela especificada, com colunas e condições opcionais.
    $sql = "SELECT $columns FROM $tableName";
    if ($where) {
        $conditions = [];
        foreach ($where as $column => $value) {
            $conditions[] = "$column = ?";
        }
        $sql .= " WHERE " . implode( " AND ", $conditions);
    }  

    $stmt = $conn->prepare($sql);
    if ($where) {
        $types = str_repeat("s", count($where)); // Assume strings; ajuste conforme necessário
        $stmt->bind_param($types, ...array_values($where));
    }

    $stmt->execute();
    return $stmt->get_result();
}

/**
 * Gera uma tabela HTML dinamicamente a partir dos resultados do banco.
 *
 * @param mysqli_result $result Resultado da consulta.
 * @return string HTML da tabela.
 */

 function generateTable($result, $tableName, $columns) {
    if ($result->num_rows == 0) {
        return "<p>Nenhum dado encontrado.</p>";
    }

    if (is_string($columns)) {
        $columns = explode(',', $columns); // Garante que seja um array
    }

    $showEmployees = isset($_GET['showEmployees']) ? filter_var($_GET['showEmployees'], FILTER_VALIDATE_BOOLEAN) : true;

    $table = "<form method='POST' action='excel.php'>";
    $table .= "<input type='hidden' name='tableName' value='" . htmlspecialchars($tableName) . "'>";
    $table .= "<input type='hidden' name='columns' value='" . htmlspecialchars(implode(',', $columns)) . "'>";
    $table .= "<button type='submit'>Exportar para Excel e Enviar por E-mail</button>";
    $table .= "</form>";

    $table .= "<table>";
    $table .= "<tr>";

    $resultColumns = array_keys($result->fetch_assoc());
    $result->data_seek(0);

    foreach ($resultColumns as $column) {
        if ($tableName !== 'funcionarios' || $column !== 'id_empresa') {
            $table .= "<th>" . htmlspecialchars($column) . "</th>";
        }
    }

    $table .= "<th>Editar</th>";
    if ($showEmployees && $tableName === 'empresas') {
        $table .= "<th>Funcionários</th>";
    }
    $table .= "</tr>";

    while ($row = $result->fetch_assoc()) {
        $table .= "<tr>";
        foreach ($columns as $column) {
            if ($tableName !== 'funcionarios' || $column !== 'id_empresa') {
                $table .= "<td>" . htmlspecialchars($row[$column]) . "</td>";
            }
        }

        if ($tableName === 'funcionarios') {
            $table .= "<td><a href='edita.php?"
                . "id=" . htmlspecialchars($row['id_funcionario'])
                . "&table=" . htmlspecialchars($tableName)
                . "&columns=" . htmlspecialchars(implode(',', $columns))
                . "&id_empresa=" . htmlspecialchars($row['id_empresa'])
                . "'>Editar</a></td>";
        } elseif ($tableName === 'empresas') {
            $table .= "<td><a href='edita.php?"
                . "id=" . htmlspecialchars($row['id_empresa'])
                . "&table=" . htmlspecialchars($tableName)
                . "&columns=" . htmlspecialchars(implode(',', $columns))
                . "'>Editar</a></td>";
        }

        if ($showEmployees && $tableName === 'empresas') {
            $table .= "<td><a href='admin_funcionariosOFC.php?id_empresa=" . htmlspecialchars($row['id_empresa']) . "&showEmployees=false'>Ver Funcionários</a></td>";
        }

        $table .= "</tr>";
    }
    $table .= "</table>";

    return $table;
}








