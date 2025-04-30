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

if (!isset($_POST['id']) || !isset($_POST['nome']) || empty($_POST['nome'])) {
    header('Content-Type: application/json');
    echo json_encode(([
        'status' => 'erro',
        'mensagem' => 'ID e nome do curso são obrigadtórios'
    ]));
    exit;
}

try {
    $stmt = $pdo->prepare('UPDATE curso SET NOME = :nome WHERE IDCURSO = :id');

    $stmt->execute([
        'id' => $_POST['id'],
        'nome' => $_POST['nome'],
    ]);

    if ($stmt->rowCount() > 0) {
        header('Content-Type: application/json');
        echo json_encode(([
            'status' => 'ok',
            'mensagem' => 'Curso atualizado com sucesso'
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
        'mensagem' => 'Erro ao atualizar curso:' . $e->getMessage()
    ]));
}

?>