<?php
require '../../conexoes/conexaoOFC.php';
require '../../vendor/autoload.php'; // Bibliotecas como PHPMailer e PhpSpreadsheet

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $tableName = $_POST['tableName'];
    $columns = $_POST['columns'];

    // Valida a tabela e as colunas (reutilize sua lógica existente)
    $query = "SELECT $columns FROM $tableName";
    $result = $conn->query($query);

    if (!$result || $result->num_rows === 0) {
        die("Nenhum dado encontrado para exportar.");
    }

    // Cria a planilha
    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();

    // Adiciona cabeçalhos
    $columnsArray = explode(',', $columns);
    foreach ($columnsArray as $key => $column) {
        $cell = chr(65 + $key) . '1'; // Converte para "A1", "B1", etc.
        $sheet->setCellValue($cell, $column);
    }
    
    // Adiciona dados
    $rowNumber = 2;
    while ($row = $result->fetch_assoc()) {
    foreach ($columnsArray as $key => $column) {
        $cell = chr(65 + $key) . $rowNumber; // Converte para "A2", "B2", etc.
        $sheet->setCellValue($cell, $row[$column]);
    }
    $rowNumber++;
}

    // Salva o arquivo temporário
    $filePath = 'export_' . $tableName . '.xlsx';
    $writer = new Xlsx($spreadsheet);
    $writer->save($filePath);

    // Envia por e-mail
    $mail = new PHPMailer(true);
    try {
        $mail->isSMTP();
        $mail->Host = 'smtp-relay.brevo.com';
        $mail->SMTPAuth = true;
        $mail->Username = '810f86001@smtp-brevo.com';
        $mail->Password = 'Fa7Pt8DUjXVCNwqy';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        $mail->setFrom('portaldaalfabetizacao@gmail.com', 'Anderson');
        $mail->addAddress('portaldaalfabetizacao@gmail.com'); 

        $mail->Subject = "Exportação de dados - $tableName";
        $mail->Body = "Os dados exportados da tabela $tableName estão anexados.";

        $mail->addAttachment($filePath);

        $mail->send();
        unlink($filePath); // Remove o arquivo temporário

        echo header ("Location: admin_empresasOFC.php");
    } catch (Exception $e) {
        echo "Erro ao enviar o e-mail: " . $mail->ErrorInfo;
    }
}
?>
