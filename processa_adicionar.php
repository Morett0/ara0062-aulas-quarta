<?php
include 'conexao.php';

$item = $_POST['item'];
$descricao = $_POST['descricao'];
$preco = $_POST['preco'];
$imagem = $_POST['imagem'];

$sql = "INSERT INTO cardapio (item, descricao, preco, imagem) VALUES ('$item', '$descricao', '$preco', '$imagem')";

if (mysqli_query($conn, $sql)) {
    // Requisito: Mostrar mensagem de sucesso e ao clicar OK voltar para tabela
    echo "<script>
        alert('Item adicionado com sucesso!');
        window.location.href = 'cardapio.php';
    </script>";
} else {
    echo "Erro: " . $sql . "<br>" . mysqli_error($conn);
}
?>