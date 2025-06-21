<?php
session_start();
require_once '../db/conexao.php';

if (!isset($_SESSION['usuario_id'])) {
    echo json_encode(['status' => 'erro', 'mensagem' => 'Usuário não autenticado.']);
    exit;
}

$tipo = $_POST['tipo'] ?? '';
$valor = $_POST['valor'] ?? '';
$descricao = $_POST['descricao'] ?? '';
$data = $_POST['data'] ?? '';
$usuario_id = $_SESSION['usuario_id'];

if (empty($tipo) || empty($valor) || empty($descricao) || empty($data)) {
    echo json_encode(['status' => 'erro', 'mensagem' => 'Todos os campos são obrigatórios.']);
    exit;
}

try {
    $sql = "INSERT INTO movimentacoes (usuario_id, tipo, valor, descricao, data)
            VALUES (:usuario_id, :tipo, :valor, :descricao, :data)";
    
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':usuario_id', $usuario_id);
    $stmt->bindParam(':tipo', $tipo);
    $stmt->bindParam(':valor', $valor);
    $stmt->bindParam(':descricao', $descricao);
    $stmt->bindParam(':data', $data);
    $stmt->execute();
     
     // Redireciona para o login com parâmetro de sucesso
    header('Location: /sistema-php/sistema-php/frontend/dashboard.html');
    exit;
 
} catch (PDOException $e) {
    echo json_encode(['status' => 'erro', 'mensagem' => 'Erro ao cadastrar movimentação.']);
}
