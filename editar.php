<?php
include 'conexao.php';
$id = $_GET['id'];
$sql = "SELECT * FROM cardapio WHERE id = $id";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);
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
        <nav><a href="cardapio.php">Voltar</a></nav>
    </header>
    <main>
        <form action="processa_editar.php" method="POST">
            <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
            
            <div class="form-group">
                <label for="item">Nome:</label>
                <input type="text" name="item" value="<?php echo $row['item']; ?>" required>
            </div>
            <div class="form-group">
                <label for="descricao">Descrição:</label>
                <textarea name="descricao" required><?php echo $row['descricao']; ?></textarea>
            </div>
            <div class="form-group">
                <label for="preco">Preço:</label>
                <input type="text" name="preco" value="<?php echo $row['preco']; ?>" required>
            </div>
            <div class="form-group">
                <label for="imagem">Imagem:</label>
                <input type="text" name="imagem" value="<?php echo $row['imagem']; ?>" required>
            </div>
            <button type="submit">Salvar Alterações</button>
        </form>
    </main>
</body>
</html>