<?php
include 'auth.php';
include 'conexao.php';

$item = mysqli_real_escape_string($conn, $_POST['item']);
$descricao = mysqli_real_escape_string($conn, $_POST['descricao']);
$preco = mysqli_real_escape_string($conn, $_POST['preco']);

$diretorio_destino = "imagens/";
if (!is_dir($diretorio_destino)) { mkdir($diretorio_destino, 0777, true); }

if (isset($_FILES['imagem']) && $_FILES['imagem']['error'] == 0) {
    $arquivo_tmp = $_FILES['imagem']['tmp_name'];
    $nome_orig = $_FILES['imagem']['name'];
    $extensao = strtolower(pathinfo($nome_orig, PATHINFO_EXTENSION));
    $permitidos = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
    
    if (in_array($extensao, $permitidos)) {
        $novo_nome = uniqid('img_') . '.' . $extensao;
        $caminho_completo = $diretorio_destino . $novo_nome;
        
        if (move_uploaded_file($arquivo_tmp, $caminho_completo)) {
            $sql = "INSERT INTO cardapio (item, descricao, preco, imagem) VALUES ('$item', '$descricao', '$preco', '$caminho_completo')";

            if (mysqli_query($conn, $sql)) {
                // SUCESSO
                $_SESSION['mensagem'] = "Item <strong>$item</strong> adicionado com sucesso!";
                $_SESSION['tipo_mensagem'] = "mensagem-sucesso";
                header('Location: admin.php');
                exit;
            } else {
                // ERRO BANCO
                $_SESSION['mensagem'] = "Erro no banco de dados.";
                $_SESSION['tipo_mensagem'] = "mensagem-erro";
                header('Location: adicionar.php');
                exit;
            }
        }
    }
}

// Se chegou aqui, deu erro no upload ou arquivo inválido
$_SESSION['mensagem'] = "Erro ao enviar imagem ou formato inválido.";
$_SESSION['tipo_mensagem'] = "mensagem-erro";
header('Location: adicionar.php');
exit;
?>