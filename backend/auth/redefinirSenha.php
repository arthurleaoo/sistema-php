<?php
require_once '../db/conexao.php';

$email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
$novaSenha = filter_input(INPUT_POST, 'senha', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

if (empty($email) || empty($novaSenha)) {
    header('Location: /sistema-php/sistema-php/frontend/usuarios/redefinirSenha.html?erro=campos');
    exit;
}

$senhaHash = password_hash($novaSenha, PASSWORD_DEFAULT);

try {
    $sql = "UPDATE usuarios SET senha = :senha WHERE email = :email";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':senha' => $senhaHash,
        ':email' => $email
    ]);

    header('Location: /sistema-php/sistema-php/frontend/usuarios/login.html?senhaAtualizada=1');
    exit;

} catch (PDOException $e) {
    header('Location: /sistema-php/sistema-php/frontend/usuarios/redefinir.html?erro=bd');
    exit;
}
