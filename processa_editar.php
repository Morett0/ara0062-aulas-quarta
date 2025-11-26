<?php
include 'auth.php';
include 'conexao.php';

$id = mysqli_real_escape_string($conn, $_POST['id']);
$item = mysqli_real_escape_string($conn, $_POST['item']);
$descricao = mysqli_real_escape_string($conn, $_POST['descricao']);
$preco = mysqli_real_escape_string($conn, $_POST['preco']);
$caminho_final = $_POST['imagem_antiga'];

// Se enviou nova imagem
if (isset($_FILES['imagem']) && $_FILES['imagem']['error'] == 0) {
    $diretorio = "imagens/";
    $arquivo_tmp = $_FILES['imagem']['tmp_name'];
    $nome_orig = $_FILES['imagem']['name'];
    $extensao = strtolower(pathinfo($nome_orig, PATHINFO_EXTENSION));
    $permitidos = ['jpg', 'jpeg', 'png', 'gif', 'webp'];

    if (in_array($extensao, $permitidos)) {
        $novo_nome = uniqid('img_') . '.' . $extensao;
        $destino = $diretorio . $novo_nome;

        if (move_uploaded_file($arquivo_tmp, $destino)) {
            $caminho_final = $destino;
        }
    }
}

$sql = "UPDATE cardapio SET item='$item', descricao='$descricao', preco='$preco', imagem='$caminho_final' WHERE id=$id";

if (mysqli_query($conn, $sql)) {
    $_SESSION['mensagem'] = "Item atualizado com maestria!";
    $_SESSION['tipo_mensagem'] = "mensagem-sucesso";
    header('Location: admin.php');
} else {
    $_SESSION['mensagem'] = "Erro ao atualizar item.";
    $_SESSION['tipo_mensagem'] = "mensagem-erro";
    header('Location: editar.php?id='.$id);
}
exit;
?>