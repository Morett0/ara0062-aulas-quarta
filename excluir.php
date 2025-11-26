<?php
include 'auth.php';
include 'conexao.php';

$id = $_GET['id'];
$id = mysqli_real_escape_string($conn, $id); // Segurança extra

$sql = "DELETE FROM cardapio WHERE id = $id";

if (mysqli_query($conn, $sql)) {
    $_SESSION['mensagem'] = "Item removido do cardápio.";
    $_SESSION['tipo_mensagem'] = "mensagem-sucesso";
} else {
    $_SESSION['mensagem'] = "Não foi possível remover o item.";
    $_SESSION['tipo_mensagem'] = "mensagem-erro";
}

header('Location: admin.php');
exit;
?>