
<?php
session_start();
include 'conexao.php';

$login = $_POST['login'];
$senha = $_POST['senha'];

// Busca o usuário no banco
$sql = "SELECT * FROM usuarios WHERE login = '$login'";
$result = mysqli_query($conn, $sql);

if($row = mysqli_fetch_assoc($result)) {
    // Verifica a senha (comparação simples para seu trabalho)
    if($senha == $row['senha']) {
        // Sucesso! Cria a sessão
        $_SESSION['usuario_logado'] = true;
        $_SESSION['nome_usuario'] = $row['nome'];
        header('Location: admin.php');
    } else {
        header('Location: login.php?erro=senha');
    }
} else {
    header('Location: login.php?erro=senha');
}
?>