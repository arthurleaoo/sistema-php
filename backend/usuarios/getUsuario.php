<?php
session_start();
require_once '../db/conexao.php';

header('Content-Type: application/json');

// Verifica se o usuário está autenticado
if (!isset($_SESSION['usuario_id'])) {
    echo json_encode([
        'status' => 'erro',
        'mensagem' => 'Usuário não autenticado.'
    ]);
    exit;
}

$id = $_SESSION['usuario_id'];

try {
    $stmt = $pdo->prepare("SELECT nome, email FROM usuarios WHERE id = :id");
    $stmt->execute([':id' => $id]);
    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($usuario) {
        echo json_encode([
            'status' => 'ok',
            'dados' => $usuario
        ]);
    } else {
        echo json_encode([
            'status' => 'erro',
            'mensagem' => 'Usuário não encontrado.'
        ]);
    }
} catch (PDOException $e) {
    echo json_encode([
        'status' => 'erro',
        'mensagem' => 'Erro no banco de dados.'
    ]);
}
