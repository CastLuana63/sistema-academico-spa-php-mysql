<?php

require_once '../conexaobd.php';

try {
    $stmt = $pdo->query('SELECT IDCURSO, NOME FROM curso ORDER BY NOME');
    $cursos = $stmt->fetchAll(PDO::FETCH_ASSOC);

    header('Content-Type: application/json');
    echo json_encode($cursos);
} catch (Exception $e) {
    header('Content-Type: application/json');
    echo json_encode([
        'status' => 'error',
        'mensagem' => 'Erro ao listar cursos: ' . $e->getMessage()
    ]);
}