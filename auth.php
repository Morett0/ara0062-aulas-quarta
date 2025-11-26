<?php
session_start();

// Verifica se existe a sessão do usuário
if(!isset($_SESSION['usuario_logado'])) {
    // Se não estiver logado, manda para o login com erro
    header('Location: login.php?erro=sem_permissao');
    exit;
}
?>