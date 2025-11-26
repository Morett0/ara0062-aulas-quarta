<?php include 'conexao.php'; ?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Provisões - O Refúgio do Viajante</title>
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
        <h1>🍺 Nossas Provisões 🍞</h1>
        <nav>
            <a href="index.html">O Refúgio</a>
            <a href="cardapio.php" class="active">Provisões</a>
            <a href="contato.html">Mensageiro</a>
            <a href="equipe.html">O Estalajadeiro</a>
            <a href="#" role="button" id="btn-tema" style="margin-left: 1rem;">Mudar Tema</a>
        </nav>
    </header>

    <main>
        <div style="text-align: center; margin-bottom: 2rem;">
            <h2>Para fortalecer o corpo e aquecer a alma.</h2>
            <p>Explore nossas delícias cuidadosamente preparadas. <br><small>(Clique nas imagens para ampliar)</small></p>
        </div>

        <div style="overflow-x: auto;">
            <table class="cardapio-table">
                <thead>
                    <tr>
                        <th>Imagem</th>
                        <th>Item</th>
                        <th>Descrição</th>
                        <th>Preço</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sql = "SELECT * FROM cardapio ORDER BY item ASC";
                    $result = mysqli_query($conn, $sql);

                    if ($result && mysqli_num_rows($result) > 0) {
                        while($row = mysqli_fetch_assoc($result)) {
                            // Sanitização para evitar erros no JS
                            $imagem = htmlspecialchars($row['imagem']);
                            $itemNome = htmlspecialchars($row['item']);
                            
                            echo "<tr>";
                            // AQUI ESTÁ A MUDANÇA: Adicionamos onclick e a classe img-cardapio
                            echo "<td>
                                    <img src='{$imagem}' 
                                         alt='{$itemNome}' 
                                         class='img-cardapio' 
                                         onclick='abrirZoom(this.src, \"{$itemNome}\")'
                                         title='Clique para ampliar'>
                                  </td>";
                            echo "<td><strong>{$row['item']}</strong></td>";
                            echo "<td>{$row['descricao']}</td>";
                            echo "<td><strong>{$row['preco']}</strong></td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='4' style='text-align:center'>O estalajadeiro está dormindo... (Sem itens)</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </main>

    <div id="modal-zoom" onclick="fecharZoom()">
        <span class="fechar-zoom">&times;</span>
        <img class="modal-conteudo" id="img-zoom-conteudo">
        <div id="caption-zoom"></div>
    </div>

    <footer>
        <p>&copy; 2025 O Refúgio do Viajante.</p>
        <small><a href="login.php" class="secondary">Área Restrita</a></small>
    </footer>

    <script src="js/tema.js"></script>
    
    <script>
        // Abre o modal
        function abrirZoom(src, alt) {
            var modal = document.getElementById("modal-zoom");
            var modalImg = document.getElementById("img-zoom-conteudo");
            var captionText = document.getElementById("caption-zoom");
            
            modal.style.display = "flex";
            modalImg.src = src;
            captionText.innerHTML = alt;
        }

        // Fecha o modal
        function fecharZoom() {
            document.getElementById("modal-zoom").style.display = "none";
        }

        // Fecha também se apertar ESC
        document.addEventListener('keydown', function(event) {
            if (event.key === "Escape") {
                fecharZoom();
            }
        });
    </script>
</body>
</html>