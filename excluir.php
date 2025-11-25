<?php
include 'conexao.php';

$id = $_GET['id'];

$sql = "DELETE FROM cardapio WHERE id = $id";

if (mysqli_query($conn, $sql)) {
    echo "<script>
        alert('Item deletado com sucesso!');
        window.location.href = 'cardapio.php';
    </script>";
} else {
    echo "Erro ao deletar: " . mysqli_error($conn);
}
?>