<?php
session_start();
require_once '../db/conexao.php';

if (!isset($_SESSION['usuario_id'])) {
    echo json_encode(['status' => 'erro', 'mensagem' => 'Usuário não autenticado.']);
    exit;
}

$usuario_id = $_SESSION['usuario_id'];
$id = $_GET['id'] ?? null;

if (!$id) {
    echo json_encode(['status' => 'erro', 'mensagem' => 'ID inválido.']);
    exit;
}

$sql = "SELECT * FROM movimentacoes WHERE id = :id AND usuario_id = :usuario_id";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':id', $id);
$stmt->bindParam(':usuario_id', $usuario_id);
$stmt->execute();
$movimentacao = $stmt->fetch(PDO::FETCH_ASSOC);

if ($movimentacao) {
    echo json_encode(['status' => 'ok', 'movimentacao' => $movimentacao]);
} else {
    echo json_encode(['status' => 'erro', 'mensagem' => 'Movimentação não encontrada.']);
}
