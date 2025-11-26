<?php
include 'conexao.php';

echo "<h1>Diagnóstico do Refúgio</h1>";

// 1. Teste de Conexão
if ($conn) {
    echo "<p style='color:green'>✅ Conexão com o banco realizada com sucesso!</p>";
} else {
    die("<p style='color:red'>❌ Erro na conexão: " . mysqli_connect_error() . "</p>");
}

// 2. Teste da Tabela de Usuários
$sql = "SELECT * FROM usuarios";
$result = mysqli_query($conn, $sql);

if ($result) {
    echo "<p style='color:green'>✅ Tabela 'usuarios' encontrada!</p>";
    echo "<h3>Lista de Usuários:</h3><ul>";
    while($row = mysqli_fetch_assoc($result)) {
        echo "<li>Login: <strong>" . $row['login'] . "</strong> | Senha: <strong>" . $row['senha'] . "</strong></li>";
    }
    echo "</ul>";
} else {
    echo "<p style='color:red'>❌ Erro: A tabela 'usuarios' NÃO EXISTE ou ocorreu um erro.</p>";
    echo "<p>Erro SQL: " . mysqli_error($conn) . "</p>";
}
?>