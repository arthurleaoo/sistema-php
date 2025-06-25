<?php
session_start();
require_once '../db/conexao.php';

$email = $_POST['email'] ?? '';
$senha = $_POST['senha'] ?? '';

// Consulta o usuário pelo e-mail
$sql = "SELECT * FROM usuarios WHERE email = :email";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':email', $email);
$stmt->execute();

$usuario = $stmt->fetch(PDO::FETCH_ASSOC);


if ($usuario && password_verify($senha, $usuario['senha'])) {
    $_SESSION['usuario_id'] = $usuario['id'];

    // Redireciona para a página de movimentações
    header('Location:/sistema-php/sistema-php/frontend/dashboard.html');
    exit;
} else {
    
    header('Location: /sistema-php/sistema-php/frontend/usuarios/login.html?erro=1');
    exit;
}
