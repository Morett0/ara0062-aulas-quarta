<?php
include 'auth.php';
include 'conexao.php';

$id = $_GET['id'];
// Proteção simples contra SQL Injection na URL
$id = mysqli_real_escape_string($conn, $id);

$sql = "SELECT * FROM cardapio WHERE id = $id";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);

// Se não achar o item, volta
if(!$row) {
    header('Location: admin.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Editar Item</title>
    <link rel="stylesheet" href="pico.css">
    <link rel="stylesheet" href="estilos.css">
    <script>
        (function() {
            const temaSalvo = localStorage.getItem('tema');
            if (temaSalvo) document.documentElement.setAttribute('data-theme', temaSalvo);
        })();
    </script>
</head>
<body>
    <header>
        <h1>Editar Provisão</h1>
        <nav><a href="admin.php">Voltar</a></nav>
    </header>
    <main class="container">
        <form action="processa_editar.php" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
            <input type="hidden" name="imagem_antiga" value="<?php echo $row['imagem']; ?>">
            
            <div class="grid">
                <div style="text-align: center; margin-bottom: 20px;">
                    <label>Imagem Atual:</label>
                    <img src="<?php echo $row['imagem']; ?>" alt="Foto atual" style="max-height: 200px; border-radius: 8px; box-shadow: var(--sombra-pequena);">
                </div>

                <div>
                    <div class="form-group">
                        <label for="item">Nome:</label>
                        <input type="text" name="item" value="<?php echo $row['item']; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="preco">Preço:</label>
                        <input type="text" name="preco" value="<?php echo $row['preco']; ?>" required>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label for="descricao">Descrição:</label>
                <textarea name="descricao" required rows="4"><?php echo $row['descricao']; ?></textarea>
            </div>
            
            <div class="form-group">
                <label for="imagem">Trocar Imagem (Opcional):</label>
                <input type="file" name="imagem" accept="image/*">
                <small>Deixe em branco para manter a imagem atual.</small>
            </div>

            <button type="submit">Salvar Alterações</button>
        </form>
    </main>
</body>
</html>