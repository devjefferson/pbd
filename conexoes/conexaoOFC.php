<?php

// Configurações do banco de dados
$host = "localhost";
$user = "root";
$password = "";
$dbname = "portal";

// Criar conexão com o banco de dados
$conn = new mysqli($host, $user, $password, $dbname);

// Verificar conexão
if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}
$conn->set_charset("utf8mb4");
?>