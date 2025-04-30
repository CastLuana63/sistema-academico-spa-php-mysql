<?php

require_once '../conexaobd.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Content-Type: application/json');
    echo json_encode([
        'status' => 'erro',
        'mensagem' => 'método não permitido.'
    ]);
    exit;
}

if (!isset($_POST['nome']) || empty($_POST['nome'])) {
    header('Content-Type: application/json');
    echo json_encode([
        'status' => 'erro',
        'mensagem' => 'O nome do curso é obrigatório'
    ]);
    exit;
}

try {
    $stmt = $pdo->prepare("INSERT INTO curso (NOME) VALUES (:nome)");
    $stmt->execute(["nome" => $_POST["nome"]]);

    if ($stmt->rowCount() > 0) {
        header('Content-Type: application/json');
        echo json_encode([
            'status' => 'ok',
            'mensagem' => 'Curso inserido com sucesso!'
        ]);
    } else {
        header('Content-Type: application/json');
        echo json_encode([
            'status' => 'erro',
            'mensagem' => 'Falha ao inserir curso!'
        ]);
    }
} catch (PDOException $e) {
    header('Content-Type: application/json');
    echo json_encode([
        'status' => 'erro',
        'mensagem' => 'Erro ao inserir curso' . $e->getMessage()
    ]);
}


?>