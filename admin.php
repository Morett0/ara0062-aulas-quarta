<?php 
// PROTEÇÃO: Só entra se estiver logado
include 'auth.php'; 
include 'conexao.php'; 
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Painel do Estalajadeiro</title>
    <link rel="stylesheet" href="pico.css">
    <link rel="stylesheet" href="estilos.css">
    <script>
        (function() {
            const temaSalvo = localStorage.getItem('tema');
            if (temaSalvo) document.documentElement.setAttribute('data-theme', temaSalvo);
        })();
        
        function confirmarExclusao(id, nome) {
            if(confirm('Tem certeza que deseja remover "' + nome + '" das provisões?')) {
                window.location.href = 'excluir.php?id=' + id;
            }
        }
    </script>
</head>
<body>
    <header>
        <h1>🛠️ Painel de Controle</h1>
        <nav>
            <strong style="color: var(--cor-destaque);">Olá, <?php echo $_SESSION['nome_usuario']; ?></strong>
            <a href="index.html" target="_blank">Ver Site</a>
            <a href="logout.php" role="button" class="secondary">Sair (Logout)</a>
        </nav>
    </header>

    <main>
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
            <h2>Gerenciar Provisões</h2>
            <a href="adicionar.php" role="button" class="contrast">➕ Adicionar Novo Item</a>
        </div>

        <div style="overflow-x: auto;">
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
                    $sql = "SELECT * FROM cardapio ORDER BY item ASC";
                    $result = mysqli_query($conn, $sql);

                    while($row = mysqli_fetch_assoc($result)) {
                        echo "<tr>";
                        echo "<td><img src='{$row['imagem']}' style='max-width: 80px;'></td>";
                        echo "<td>{$row['item']}</td>";
                        echo "<td>{$row['descricao']}</td>";
                        echo "<td>{$row['preco']}</td>";
                        echo "<td>
                                <div class='acoes-botoes'>
                                    <a href='editar.php?id={$row['id']}' role='button' class='outline'>✏️ Editar</a>
                                    <button onclick=\"confirmarExclusao({$row['id']}, '{$row['item']}')\" class='outline contrast'>🗑️ Excluir</button>
                                </div>
                              </td>";
                        echo "</tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </main>
    <script src="js/tema.js"></script>
</body>
</html>