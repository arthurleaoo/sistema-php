<?php
require_once '../db/conexao.php';

$nome = $_POST['nome'] ?? '';
$email = $_POST['email'] ?? '';
$senha = $_POST['senha'] ?? '';

if (empty($nome) || empty($email) || empty($senha)) {
    header('Location: /sistema-php/sistema-php/frontend/usuarios/criar.html?erro=campos_vazios');
    exit;
}

$senhaHash = password_hash($senha, PASSWORD_DEFAULT);

try {
    $sql = "INSERT INTO usuarios (nome, email, senha) VALUES (:nome, :email, :senha)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':nome' => $nome,
        ':email' => $email,
        ':senha' => $senhaHash
    ]);

   // Redireciona para a página de login após cadastro com sucesso
     header('Location: /sistema-php/sistema-php/frontend/usuarios/login.html?sucesso=1');
    exit;
} catch (PDOException $e) {
    // Redireciona de volta para o cadastro em caso de erro (ex: email duplicado)
    header('Location: /sistema-php/sistema-php/frontend/usuarios/criar.html?erro=cadastro');
    exit;
}
?>
