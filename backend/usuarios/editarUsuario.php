<?php
session_start();
require_once '../db/conexao.php';

header('Content-Type: application/json');

if (!isset($_SESSION['usuario_id'])) {
    echo json_encode(['status' => 'erro', 'mensagem' => 'Usuário não autenticado.']);
    exit;
}

$id = $_SESSION['usuario_id'];

$input = json_decode(file_get_contents('php://input'), true);

$nome  = htmlspecialchars(trim($input['nome'] ?? ''));
$email = filter_var(trim($input['email'] ?? ''), FILTER_SANITIZE_EMAIL);
$senha = htmlspecialchars(trim($input['senha'] ?? ''));

// Validação
if (empty($nome) || empty($email) || empty($senha)) {
    echo json_encode(['status' => 'erro', 'mensagem' => 'Todos os campos são obrigatórios.']);
    exit;
}

// Hash da nova senha
$senhaHash = password_hash($senha, PASSWORD_DEFAULT);

try {
    $sql = "UPDATE usuarios SET nome = :nome, email = :email, senha = :senha WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':nome' => $nome,
        ':email' => $email,
        ':senha' => $senhaHash,
        ':id' => $id
    ]);

    echo json_encode(['status' => 'ok', 'mensagem' => 'Perfil atualizado com sucesso.']);
} catch (PDOException $e) {
    echo json_encode(['status' => 'erro', 'mensagem' => 'Erro ao atualizar perfil.']);
}
?>
