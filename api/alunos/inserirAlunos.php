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

if (!isset($_POST['nome']) || empty($_POST['nome'])) {
    header('Content-Type: application/json');
    echo json_encode([
        'status' => 'erro',
        'mensagem' => 'O nome do aluno é obrigatório'
    ]);
    exit;
}

try {

    $stmt = $pdo->prepare("INSERT INTO aluno (NOME, IDCURSO) VALUES (:nome, :curso)");

    $stmt->execute([
        "nome" => $_POST["nome"],
        "curso" => !empty($_POST["curso"]) ? $_POST["curso"] : null,
    ]);

    header('Content-Type: application/json');
    echo json_encode([
        'status' => 'ok',
        'mensagem' => 'Aluno inserido com sucesso'
    ]);

} catch (Exception $e) {
    header('Content-Type: application/json');
    echo json_encode([
        'status' => 'error',
        'mensagem' => 'Erro ao inserir alunos: ' . $e->getMessage()
    ]);
}