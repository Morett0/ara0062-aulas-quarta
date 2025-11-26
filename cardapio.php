<?php include 'conexao.php'; ?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Descubra as deliciosas provisões do Refúgio do Viajante - uma estalagem temática medieval">
    <meta name="theme-color" content="#587458">
    <title>Provisões - O Refúgio do Viajante</title>
    
    <!-- Preload de fontes importantes -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    
    <link rel="stylesheet" href="pico.css">
    <link rel="stylesheet" href="estilos.css">
    
    <script>
        // Script inline para evitar flash de tema
        (function() {
            const temaSalvo = localStorage.getItem('tema');
            if (temaSalvo) {
                document.documentElement.setAttribute('data-theme', temaSalvo);
            } else {
                const prefereEscuro = window.matchMedia('(prefers-color-scheme: dark)').matches;
                document.documentElement.setAttribute('data-theme', prefereEscuro ? 'dark' : 'light');
            }
        })();
        
        // Função de confirmação melhorada com feedback visual
        function confirmarExclusao(id, nome) {
            // Cria modal customizado
            const modal = document.createElement('div');
            modal.className = 'modal-confirmacao';
            modal.innerHTML = `
                <div class="modal-overlay" onclick="this.parentElement.remove()"></div>
                <div class="modal-conteudo">
                    <div class="modal-icone">⚠️</div>
                    <h3>Confirmar Exclusão</h3>
                    <p>Tem certeza que deseja deletar <strong>"${nome}"</strong> do cardápio?</p>
                    <p style="color: #7b8495; font-size: 0.9rem;">Esta ação não pode ser desfeita.</p>
                    <div class="modal-botoes">
                        <button onclick="this.closest('.modal-confirmacao').remove()" class="btn-cancelar">
                            Cancelar
                        </button>
                        <button onclick="window.location.href='excluir.php?id=${id}'" class="btn-confirmar">
                            Sim, Deletar
                        </button>
                    </div>
                </div>
            `;
            
            // Estilos do modal
            const style = document.createElement('style');
            style.textContent = `
                .modal-confirmacao {
                    position: fixed;
                    top: 0;
                    left: 0;
                    width: 100%;
                    height: 100%;
                    z-index: 9999;
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    animation: fadeIn 0.3s ease;
                }
                .modal-overlay {
                    position: absolute;
                    top: 0;
                    left: 0;
                    width: 100%;
                    height: 100%;
                    background: rgba(0, 0, 0, 0.5);
                    backdrop-filter: blur(4px);
                }
                .modal-conteudo {
                    position: relative;
                    background: var(--cor-fundo-container);
                    padding: 2rem;
                    border-radius: var(--border-radius);
                    max-width: 400px;
                    width: 90%;
                    box-shadow: var(--sombra-grande);
                    text-align: center;
                    animation: scaleIn 0.3s ease;
                }
                .modal-icone {
                    font-size: 3rem;
                    margin-bottom: 1rem;
                }
                .modal-conteudo h3 {
                    margin-bottom: 1rem;
                    color: var(--cor-titulo);
                }
                .modal-botoes {
                    display: flex;
                    gap: 1rem;
                    margin-top: 1.5rem;
                }
                .modal-botoes button {
                    flex: 1;
                    padding: 0.75rem 1.5rem;
                    border: none;
                    border-radius: var(--border-radius);
                    font-weight: 600;
                    cursor: pointer;
                    transition: all 0.2s ease;
                }
                .btn-cancelar {
                    background: var(--cor-borda-suave);
                    color: var(--cor-texto);
                }
                .btn-cancelar:hover {
                    background: #d0d6e0;
                }
                .btn-confirmar {
                    background: var(--cor-erro);
                    color: white;
                }
                .btn-confirmar:hover {
                    background: #b04a44;
                    transform: translateY(-2px);
                }
                @keyframes fadeIn {
                    from { opacity: 0; }
                    to { opacity: 1; }
                }
                @keyframes scaleIn {
                    from { transform: scale(0.9); opacity: 0; }
                    to { transform: scale(1); opacity: 1; }
                }
            `;
            
            if (!document.getElementById('modal-confirmacao-style')) {
                style.id = 'modal-confirmacao-style';
                document.head.appendChild(style);
            }
            
            document.body.appendChild(modal);
        }
    </script>
</head>
<body>
    <!-- Loading Overlay -->
    <div id="loading" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.3); z-index: 9998; backdrop-filter: blur(4px);">
        <div style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); color: white; font-size: 1.5rem;">
            Carregando...
        </div>
    </div>

    <header>
        <h1>🍺 Nossas Provisões 🍞</h1>
        <nav role="navigation" aria-label="Navegação principal">
            <a href="index.html" aria-label="Ir para página inicial">O Refúgio</a>
            <a href="cardapio.php" class="active" aria-current="page">Provisões</a>
            <a href="contato.html" aria-label="Entre em contato">Mensageiro</a>
            <a href="equipe.html" aria-label="Conheça nossa equipe">O Estalajadeiro</a>
            <button 
                type="button"
                id="btn-tema" 
                aria-label="Alternar tema"
                title="Alternar entre tema claro e escuro (Ctrl+K)"
                style="padding: 0.5rem 1rem; margin-left: 1rem;">
                Mudar Tema
            </button>
        </nav>
    </header>

    <main>
        <!-- Cabeçalho da seção -->
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem; flex-wrap: wrap; gap: 1rem;">
            <div>
                <h2 style="margin-bottom: 0.5rem;">Para fortalecer o corpo e aquecer a alma.</h2>
                <p style="color: var(--cor-texto); opacity: 0.8; margin: 0;">
                    Explore nossas delícias cuidadosamente preparadas
                </p>
            </div>
            <a href="adicionar.php" 
               role="button" 
               class="contrast"
               style="white-space: nowrap;"
               aria-label="Adicionar novo item ao cardápio">
                <span style="font-size: 1.2em; margin-right: 0.5rem;">➕</span>
                Adicionar Novo Item
            </a>
        </div>

        <!-- Estatísticas (opcional) -->
        <?php
        $sql_count = "SELECT COUNT(*) as total FROM cardapio";
        $result_count = mysqli_query($conn, $sql_count);
        $total_items = mysqli_fetch_assoc($result_count)['total'];
        ?>
        
        <div style="background: var(--cor-fundo-container); padding: 1rem; border-radius: var(--border-radius); margin-bottom: 1.5rem; text-align: center; box-shadow: var(--sombra-pequena);">
            <strong style="color: var(--cor-destaque); font-size: 1.5rem;"><?php echo $total_items; ?></strong>
            <span style="color: var(--cor-texto); margin-left: 0.5rem;">
                <?php echo $total_items == 1 ? 'item disponível' : 'itens disponíveis'; ?>
            </span>
        </div>

        <!-- Tabela do Cardápio -->
        <div style="overflow-x: auto;">
            <table class="cardapio-table" role="table" aria-label="Cardápio de provisões">
                <thead>
                    <tr>
                        <th scope="col">Imagem</th>
                        <th scope="col">Item</th>
                        <th scope="col">Descrição</th>
                        <th scope="col">Preço</th>
                        <th scope="col">Ações</th> 
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sql = "SELECT * FROM cardapio ORDER BY item ASC";
                    $result = mysqli_query($conn, $sql);

                    if ($result && mysqli_num_rows($result) > 0) {
                        while($row = mysqli_fetch_assoc($result)) {
                            // Sanitiza os dados para segurança
                            $id = htmlspecialchars($row['id']);
                            $item = htmlspecialchars($row['item']);
                            $descricao = htmlspecialchars($row['descricao']);
                            $preco = htmlspecialchars($row['preco']);
                            $imagem = htmlspecialchars($row['imagem']);
                            
                            echo "<tr class='item-row' data-id='{$id}'>";
                            
                            // Célula da Imagem
                            echo "<td data-label='Imagem'>";
                            echo "<img src='{$imagem}' alt='{$item}' loading='lazy'>";
                            echo "</td>";
                            
                            // Célula do Item
                            echo "<td data-label='Item'><strong>{$item}</strong></td>";
                            
                            // Célula da Descrição
                            echo "<td data-label='Descrição'>{$descricao}</td>";
                            
                            // Célula do Preço
                            echo "<td data-label='Preço'><strong>{$preco}</strong></td>";
                            
                            // Coluna de Ações
                            echo "<td data-label='Ações'>";
                            echo "<div class='acoes-botoes'>";
                            echo "<a href='editar.php?id={$id}' role='button' class='secondary outline' aria-label='Editar {$item}'>";
                            echo "<span style='margin-right: 0.5rem;'>✏️</span>Editar";
                            echo "</a>";
                            echo "<button onclick=\"confirmarExclusao({$id}, '{$item}')\" class='outline contrast btn-excluir' aria-label='Excluir {$item}'>";
                            echo "<span style='margin-right: 0.5rem;'>🗑️</span>Excluir";
                            echo "</button>";
                            echo "</div>";
                            echo "</td>";
                            
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='5' style='text-align: center; padding: 3rem;'>";
                        echo "<div style='font-size: 3rem; margin-bottom: 1rem;'>🍽️</div>";
                        echo "<p style='color: var(--cor-texto); font-size: 1.2rem;'>Nenhum item encontrado no cardápio.</p>";
                        echo "<p style='color: var(--cor-texto); opacity: 0.7;'>Que tal adicionar o primeiro item?</p>";
                        echo "</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>

        <!-- Botão voltar ao topo -->
        <button 
            id="voltarTopo" 
            onclick="window.scrollTo({top: 0, behavior: 'smooth'})"
            style="display: none; position: fixed; bottom: 20px; right: 20px; z-index: 1000; padding: 1rem; border-radius: 50%; font-size: 1.5rem;"
            aria-label="Voltar ao topo">
            ⬆️
        </button>
    </main>

    <footer role="contentinfo">
        <p>&copy; 2025 O Refúgio do Viajante. Todos os direitos reservados.</p>
        <p style="font-size: 0.9rem; opacity: 0.7; margin-top: 0.5rem;">
            Feito com ❤️ e um toque de magia
        </p>
    </footer>

    <script src="js/tema.js"></script>
    
    <script>
        // Mostra botão "Voltar ao topo" ao rolar
        window.addEventListener('scroll', function() {
            const botao = document.getElementById('voltarTopo');
            if (window.scrollY > 300) {
                botao.style.display = 'block';
            } else {
                botao.style.display = 'none';
            }
        });

        // Animação suave ao carregar itens
        document.addEventListener('DOMContentLoaded', function() {
            const rows = document.querySelectorAll('.item-row');
            rows.forEach((row, index) => {
                row.style.opacity = '0';
                row.style.transform = 'translateY(20px)';
                setTimeout(() => {
                    row.style.transition = 'all 0.5s ease';
                    row.style.opacity = '1';
                    row.style.transform = 'translateY(0)';
                }, index * 100);
            });
        });
    </script>
</body>
</html>