<?php
require_once '../db/conexao.php';

$id = $_GET['id'];

$sql = "DELETE FROM usuarios WHERE id = :id";
$stmt = $pdo->prepare($sql);
$stmt->execute([':id' => $id]);

echo json_encode(['status' => 'ok']);
?>