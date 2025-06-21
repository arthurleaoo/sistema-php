<?php
session_start();
require_once '../db/conexao.php';

if (!isset($_SESSION['usuario_id'])) {
    echo json_encode(['status' => 'erro', 'mensagem' => 'Usuário não autenticado.']);
    exit;
}

$id = $_SESSION['usuario_id'];

// Coleta os dados do formulário
$nome  = filter_input(INPUT_POST, 'nome', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
$senha = filter_input(INPUT_POST, 'senha', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

// Validação básica
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

    // Redireciona para o login com parâmetro de sucesso
    header('Location: /sistema-php/sistema-php/frontend/usuarios/login.html?atualizado=1');
    exit;

} catch (PDOException $e) {
    // Redireciona de volta para a tela de edição em caso de erro
    header('Location: /sistema-php/sistema-php/frontend/usuarios/editar.html?erro=cadastro');
    exit;
}
?>
