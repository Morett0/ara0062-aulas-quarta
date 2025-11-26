<?php
include 'auth.php'; // Proteção
include 'conexao.php';
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Adicionar Item - O Refúgio</title>
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
        <h1>Adicionar Provisão</h1>
        <nav>
            <a href="admin.php">Voltar ao Painel</a>
        </nav>
    </header>

    <main class="container">
        <form action="processa_adicionar.php" method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label for="item">Nome do Item:</label>
                <input type="text" id="item" name="item" required placeholder="Ex: Hidromel Antigo">
            </div>
            
            <div class="form-group">
                <label for="descricao">Descrição:</label>
                <textarea id="descricao" name="descricao" required placeholder="Descreva os sabores e aromas..."></textarea>
            </div>

            <div class="form-group">
                <label for="preco">Preço:</label>
                <input type="text" id="preco" name="preco" placeholder="Ex: 10 moedas de ouro" required>
            </div>

            <div class="form-group">
                <label for="imagem">Foto do Item:</label>
                <input type="file" id="imagem" name="imagem" accept="image/*" required>
                <small>Formatos aceitos: JPG, PNG, GIF</small>
            </div>

            <button type="submit">Salvar Novo Item</button>
        </form>
    </main>
</body>
</html>