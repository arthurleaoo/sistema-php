<?php
session_start();
require_once '../db/conexao.php'; // Correto: volta um nível para acessar db

$email = $_POST['email'] ?? '';
$senha = $_POST['senha'] ?? '';

// Consulta o usuário pelo e-mail
$sql = "SELECT * FROM usuarios WHERE email = :email";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':email', $email);
$stmt->execute();

$usuario = $stmt->fetch(PDO::FETCH_ASSOC);

// Verifica se usuário existe e senha está correta
if ($usuario && password_verify($senha, $usuario['senha'])) {
    $_SESSION['usuario_id'] = $usuario['id'];

    // Redireciona para a página de movimentações
    header('Location:/sistema-php/sistema-php/frontend/dashboard.html');
    exit;
} else {
    // Redireciona de volta para a tela de login com erro
    header('Location: /sistema-php/sistema-php/frontend/usuarios/login.html?erro=1');
    exit;
}
