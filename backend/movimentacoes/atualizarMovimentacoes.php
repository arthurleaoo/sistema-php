<?php
session_start();
require_once '../db/conexao.php';

if (!isset($_SESSION['usuario_id'])) {
    echo json_encode(['status' => 'erro', 'mensagem' => 'Usuário não autenticado.']);
    exit;
}

$usuario_id = $_SESSION['usuario_id'];

$id = $_POST['id'] ?? null;
$tipo = $_POST['tipo'] ?? '';
$valor = $_POST['valor'] ?? '';
$descricao = $_POST['descricao'] ?? '';
$data = $_POST['data'] ?? '';

if (!$id || empty($tipo) || empty($valor) || empty($descricao) || empty($data)) {
    echo json_encode(['status' => 'erro', 'mensagem' => 'Dados incompletos.']);
    exit;
}

try {
    $sql = "UPDATE movimentacoes 
            SET tipo = :tipo, valor = :valor, descricao = :descricao, data = :data 
            WHERE id = :id AND usuario_id = :usuario_id";

    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':tipo', $tipo);
    $stmt->bindParam(':valor', $valor);
    $stmt->bindParam(':descricao', $descricao);
    $stmt->bindParam(':data', $data);
    $stmt->bindParam(':id', $id);
    $stmt->bindParam(':usuario_id', $usuario_id);
    $stmt->execute();

    echo json_encode(['status' => 'ok', 'mensagem' => 'Movimentação atualizada com sucesso.']);
} catch (PDOException $e) {
    echo json_encode(['status' => 'erro', 'mensagem' => 'Erro ao atualizar movimentação.']);
}
