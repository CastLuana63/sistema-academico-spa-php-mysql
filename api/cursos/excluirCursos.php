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
        'mensagem' => 'ID do curso é obrigadtório'
    ]));
    exit;
}

try {
    $stmt = $pdo->prepare('SELECT COUNT(*) FROM aluno WHERE IDCURSO = :id');
    $stmt->execute(['id' => $_POST['id']]);
    $numAlunos = $stmt->fetchColumn();

    if ($numAlunos > 0) {
        header('Content-Type: application/json');
        echo json_encode(([
            'status' => 'erro',
            'mensagem' => 'Não é possível excluir o curso pois existem alunos vinculados a ele'
        ]));
        exit;
    }

    $stmt = $pdo->prepare('DELETE FROM curso WHERE IDCURSO = :id');
    $stmt->execute(['id' => $_POST['id']]);

    if ($stmt->rowCount() > 0) {
        header('Content-Type: application/json');
        echo json_encode(([
            'status' => 'ok',
            'mensagem' => 'Curso excluído com sucesso'
        ]));
    } else {
        header('Content-Type: application/json');
        echo json_encode(([
            'status' => 'erro',
            'mensagem' => 'Curso não encontrado'
        ]));
    }

} catch (PDOException $e) {
    header('Content-Type: application/json');
    echo json_encode(([
        'status' => 'erro',
        'mensagem' => 'Erro ao excluir curso:' . $e->getMessage()
    ]));
}

?>