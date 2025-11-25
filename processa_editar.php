<?php
include 'conexao.php';

$id = $_POST['id'];
$item = $_POST['item'];
$descricao = $_POST['descricao'];
$preco = $_POST['preco'];
$imagem = $_POST['imagem'];

$sql = "UPDATE cardapio SET item='$item', descricao='$descricao', preco='$preco', imagem='$imagem' WHERE id=$id";

if (mysqli_query($conn, $sql)) {
    echo "<script>
        alert('Item alterado com sucesso!');
        window.location.href = 'cardapio.php';
    </script>";
} else {
    echo "Erro ao atualizar: " . mysqli_error($conn);
}
?>