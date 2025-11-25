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
            if (temaSalvo) {
                document.documentElement.setAttribute('data-theme', temaSalvo);
            } else {
                document.documentElement.setAttribute('data-theme', 'light');
            }
        })();
        
        function confirmarExclusao(id) {
            if(confirm("Tem certeza que deseja deletar este item do cardápio?")) {
                window.location.href = "excluir.php?id=" + id;
            }
        }
    </script>
</head>
<body>
    <header>
        <h1>Nossas Provisões</h1>
        <nav>
            <a href="index.html">O Refúgio</a>
            <a href="cardapio.php" class="active">Provisões</a>
            <a href="contato.html">Mensageiro</a>
            <a href="equipe.html">O Estalajadeiro</a>
            <a href="#" role="button" id="btn-tema" style="padding: 0.5rem 1rem; margin-left: 1rem;">Mudar Tema</a>
        </nav>
    </header>

    <main>
        <div style="display: flex; justify-content: space-between; align-items: center;">
            <h2>Para fortalecer o corpo e aquecer a alma.</h2>
            <a href="adicionar.php" role="button" class="contrast">Adicionar Novo Item</a>
        </div>

        <table class="cardapio-table">
            <thead>
                <tr>
                    <th>Imagem</th>
                    <th>Item</th>
                    <th>Descrição</th>
                    <th>Preço</th>
                    <th>Ações</th> 
                </tr>
            </thead>
            <tbody>
                <?php
                $sql = "SELECT * FROM cardapio";
                $result = mysqli_query($conn, $sql);

                if ($result && mysqli_num_rows($result) > 0) {
                    while($row = mysqli_fetch_assoc($result)) {
                        echo "<tr>";
                        echo "<td><img src='" . $row['imagem'] . "' alt='" . $row['item'] . "'></td>";
                        echo "<td>" . $row['item'] . "</td>";
                        echo "<td>" . $row['descricao'] . "</td>";
                        echo "<td>" . $row['preco'] . "</td>";
                        echo "<td>";
                        echo "<a href='editar.php?id=" . $row['id'] . "' role='button' class='secondary outline' style='margin-bottom: 5px;'>Editar</a><br>";
                        echo "<button onclick='confirmarExclusao(" . $row['id'] . ")' class='outline contrast' style='border-color: #d9534f; color: #d9534f;'>Excluir</button>";
                        echo "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='5'>Nenhum item encontrado no cardápio.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </main>

    <footer>
        <p>&copy; 2025 O Refúgio do Viajante. Todos os direitos reservados.</p>
    </footer>

    <script src="js/tema.js"></script>
</body>
</html>