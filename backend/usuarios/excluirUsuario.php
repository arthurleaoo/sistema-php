<?php
session_start();
error_log("ID da sessão: " . ($_SESSION['usuario_id'] ?? 'não definido'));
require_once '../db/conexao.php';

header('Content-Type: application/json');

if (!isset($_SESSION['usuario_id'])) {
    echo json_encode(['status' => 'erro', 'mensagem' => 'Usuário não autenticado']);
    exit;
}

$id = $_SESSION['usuario_id'];

try {
    $stmt = $pdo->prepare("DELETE FROM usuarios WHERE id = :id");
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();

    // Se nenhum registro foi deletado, retorna erro
    if ($stmt->rowCount() === 0) {
        echo json_encode(['status' => 'erro', 'mensagem' => 'Usuário não encontrado ou já excluído']);
        exit;
    }

    session_destroy(); // Encerra a sessão

    echo json_encode(['status' => 'ok']);
} catch (PDOException $e) {
    echo json_encode(['status' => 'erro', 'mensagem' => 'Erro ao excluir usuário: ' . $e->getMessage()]);
}
