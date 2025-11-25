<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Adicionar Item - O Refúgio</title>
    <link rel="stylesheet" href="pico.css">
    <link rel="stylesheet" href="estilos.css">
    <script src="js/tema-inline.js"></script> <script>
        // Script inline do tema caso não tenha separado
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
            <a href="cardapio.php">Voltar ao Cardápio</a>
        </nav>
    </header>

    <main>
        <form action="processa_adicionar.php" method="POST">
            <div class="form-group">
                <label for="item">Nome do Item:</label>
                <input type="text" id="item" name="item" required>
            </div>
            
            <div class="form-group">
                <label for="descricao">Descrição:</label>
                <textarea id="descricao" name="descricao" required></textarea>
            </div>

            <div class="form-group">
                <label for="preco">Preço:</label>
                <input type="text" id="preco" name="preco" placeholder="Ex: 10 moedas de ouro" required>
            </div>

            <div class="form-group">
                <label for="imagem">Caminho da Imagem:</label>
                <input type="text" id="imagem" name="imagem" value="imagens/pao_anao.png" required>
                <small>Coloque o caminho da imagem (ex: imagens/suco.png)</small>
            </div>

            <button type="submit">Salvar Novo Item</button>
        </form>
    </main>
</body>
</html>