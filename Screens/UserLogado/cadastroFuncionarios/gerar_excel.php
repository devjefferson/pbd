<?php
include '../../../conexoes/conexaoOFC.php';


// Definir cabeçalhos para baixar o arquivo como Excel
header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=usuarios.xls");
header("Pragma: no-cache");
header("Expires: 0"); 

// Imprimir os dados como uma tabela HTML
echo "<table border='1'>
        <tr>
            <th>ID</th>
            <th>nome_func</th>
            <th>RG</th>
            <th>CPF</th>
            <th>Email</th>
            <th>Turno</th>
            <th>Sexo</th>
            <th>Escolaridade</th>
            <th>Data de Nascimento</th>
            <th>CEP</th>
            <th>Estado</th>
            <th>Cidade</th>
            <th>Bairro</th>'
            <th>Rua</th>
            <th>Número</th>
            <th>Complemento</th>
        </tr>";

// Atualizando a consulta SQL para incluir os novos campos
$sql = "SELECT id_funcionario, nome_func, rg, cpf, email, turno, sexo, escolaridade, data_nasc, cep, estado, cidade, bairro, rua, numero, complemento FROM funcionarios";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>{$row['id_funcionario']}</td>
                <td>{$row['nome_func']}</td>
                <td>{$row['rg']}</td>
                <td>{$row['cpf']}</td>
                <td>{$row['email']}</td>
                <td>{$row['turno']}</td>
                <td>{$row['sexo']}</td>
                <td>{$row['escolaridade']}</td>
                <td>{$row['data_nasc']}</td>
                <td>{$row['cep']}</td>
                <td>{$row['estado']}</td>
                <td>{$row['cidade']}</td>
                <td>{$row['bairro']}</td>
                <td>{$row['rua']}</td>
                <td>{$row['numero']}</td>
                <td>{$row['complemento']}</td>
              </tr>";
    }
} else {
    echo "<tr><td colspan='16'>Nenhum dado encontrado</td></tr>";
}
echo "</table>";

$conn->close();
?>
