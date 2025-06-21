<?php
session_start();
require_once '../db/conexao.php';

if (!isset($_SESSION['usuario_id'])) {
    echo json_encode(['status' => 'erro', 'mensagem' => 'Usuário não autenticado.']);
    exit;
}

$id = $_POST['id'] ?? null;
$usuario_id = $_SESSION['usuario_id'];

if (!$id) {
    echo json_encode(['status' => 'erro', 'mensagem' => 'ID não informado.']);
    exit;
}

try {
    $sql = "DELETE FROM movimentacoes WHERE id = :id AND usuario_id = :usuario_id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':id', $id);
    $stmt->bindParam(':usuario_id', $usuario_id);
    $stmt->execute();

    echo json_encode(['status' => 'ok', 'mensagem' => 'Movimentação excluída com sucesso.']);
} catch (PDOException $e) {
    echo json_encode(['status' => 'erro', 'mensagem' => 'Erro ao excluir movimentação.']);
}
