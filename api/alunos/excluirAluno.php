<?php

require_once '../conexaobd.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Content-Type: application/json');
    echo json_encode(([
        'status' => 'erro',
        'mensagem' => 'método não permitido'
    ]));
    exit;
}

if (!isset($_POST['id'])) {
    header('Content-Type: application/json');
    echo json_encode(([
        'status' => 'erro',
        'mensagem' => 'ID do aluno é obrigadtório'
    ]));
    exit;
}

try {
    $stmt = $pdo->prepare('DELETE FROM aluno WHERE IDALUNO = :id');
    $stmt->execute(['id' => $_POST['id']]);

    if ($stmt->rowCount() > 0) {
        header('Content-Type: application/json');
        echo json_encode(([
            'status' => 'ok',
            'mensagem' => 'Aluno excluído com sucesso'
        ]));
    } else {
        header('Content-Type: application/json');
        echo json_encode(([
            'status' => 'erro',
            'mensagem' => 'Aluno não encontrado'
        ]));
    }

} catch (PDOException $e) {
    header('Content-Type: application/json');
    echo json_encode(([
        'status' => 'erro',
        'mensagem' => 'Erro ao excluir aluno:' . $e->getMessage()
    ]));
}

?>