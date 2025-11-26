<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Acesso Restrito - O Refúgio</title>
    <link rel="stylesheet" href="pico.css">
    <link rel="stylesheet" href="estilos.css">
    <script src="js/tema-inline.js"></script> <script>
        (function() {
            const temaSalvo = localStorage.getItem('tema');
            if (temaSalvo) document.documentElement.setAttribute('data-theme', temaSalvo);
        })();
    </script>
</head>
<body>
    <header>
        <h1>Área do Estalajadeiro</h1>
        <nav>
            <a href="index.html">Voltar ao Refúgio</a>
        </nav>
    </header>

    <main class="container">
        <article>
            <h3 style="text-align: center;">Identifique-se</h3>
            
            <?php if(isset($_GET['erro'])): ?>
                <div style="background-color: var(--cor-erro); color: white; padding: 10px; border-radius: 5px; margin-bottom: 20px; text-align: center;">
                    <?php 
                        if($_GET['erro'] == 'senha') echo "Credenciais incorretas, viajante.";
                        if($_GET['erro'] == 'sem_permissao') echo "Você precisa entrar primeiro.";
                    ?>
                </div>
            <?php endif; ?>

            <form action="processa_login.php" method="POST">
                <label for="login">Login:</label>
                <input type="text" name="login" required placeholder="Ex: admin">

                <label for="senha">Senha:</label>
                <input type="password" name="senha" required placeholder="Sua palavra-passe">

                <button type="submit" class="contrast">Abrir os Portões</button>
            </form>
        </article>
    </main>

    <footer>
        <p>&copy; 2025 O Refúgio do Viajante.</p>
    </footer>
</body>
</html>