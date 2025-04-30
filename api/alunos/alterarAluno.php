<?php

require_once '../conexaobd.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Content-Type: application/json');
    echo json_encode([
        'status' => 'erro',
        'mensagem' => 'Método não permitido'
    ]);
    exit;
}

if (!isset($_POST['id']) || !isset($_POST['nome']) || empty($_POST['nome'])) {
    header('Content-Type: application/json');
    echo json_encode([
        'status' => 'erro',
        'mensagem' => 'ID e nome do aluno é obrigatório'
    ]);
    exit;
}

try {
    $stmt = $pdo->prepare("UPDATE aluno SET NOME = :nome, IDCURSO = :curso WHERE IDALUNO = :id");

    $stmt->execute([
        "id" => $_POST["id"],
        "nome" => $_POST["nome"],
        "curso" => !empty($_POST["curso"]) ? $_POST["curso"] : null,
    ]);

    if ($stmt->rowCount() > 0) {
        header('Content-Type: application/json');
        echo json_encode([
            'status' => 'ok',
            'mensagem' => 'Aluno atualizado com sucesso'
        ]);
    } else {
        header('Content-Type: application/json');
        echo json_encode([
            'status' => 'erro',
            'mensagem' => 'Aluno não encontrado'
        ]);
    }
} catch (Exception $e) {
    header('Content-Type: application/json');
    echo json_encode([
        'status' => 'error',
        'mensagem' => 'Erro ao inserir alunos: ' . $e->getMessage()
    ]);
}