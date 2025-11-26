<?php
include 'auth.php';
include 'conexao.php';

$item = mysqli_real_escape_string($conn, $_POST['item']);
$descricao = mysqli_real_escape_string($conn, $_POST['descricao']);
$preco = mysqli_real_escape_string($conn, $_POST['preco']);

// Lógica de Upload de Imagem
$diretorio_destino = "imagens/"; // Pasta onde as fotos vão ficar

// Verifica se a pasta existe, se não, cria
if (!is_dir($diretorio_destino)) {
    mkdir($diretorio_destino, 0777, true);
}

// Verifica se o arquivo foi enviado
if (isset($_FILES['imagem']) && $_FILES['imagem']['error'] == 0) {
    
    $arquivo_tmp = $_FILES['imagem']['tmp_name'];
    $nome_original = $_FILES['imagem']['name'];
    
    // Pega a extensão do arquivo (jpg, png, etc)
    $extensao = strtolower(pathinfo($nome_original, PATHINFO_EXTENSION));
    
    // Gera um nome único para não sobrescrever fotos com mesmo nome
    // Exemplo: comida_654a3b1.png
    $novo_nome = uniqid('img_') . '.' . $extensao;
    
    $caminho_completo = $diretorio_destino . $novo_nome;
    
    // Lista de extensões permitidas
    $permitidos = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
    
    if (in_array($extensao, $permitidos)) {
        // Tenta mover o arquivo para a pasta
        if (move_uploaded_file($arquivo_tmp, $caminho_completo)) {
            
            // Se deu certo, salva no banco
            $sql = "INSERT INTO cardapio (item, descricao, preco, imagem) 
                    VALUES ('$item', '$descricao', '$preco', '$caminho_completo')";

            if (mysqli_query($conn, $sql)) {
                echo "<script>
                    alert('Item adicionado com sucesso!');
                    window.location.href = 'admin.php';
                </script>";
            } else {
                echo "Erro no banco: " . mysqli_error($conn);
            }
            
        } else {
            echo "Erro ao salvar o arquivo na pasta imagens.";
        }
    } else {
        echo "Formato de arquivo não permitido. Apenas imagens (JPG, PNG, GIF).";
    }
} else {
    echo "Nenhuma imagem selecionada ou erro no upload.";
}
?>