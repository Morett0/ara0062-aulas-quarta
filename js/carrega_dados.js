// Conteúdo para: js/carrega_dados.js

document.addEventListener('DOMContentLoaded', function() {
    
    // Seleciona o corpo da tabela onde os dados serão inseridos
    const tbody = document.querySelector('.cardapio-table tbody');

    // Função para carregar e exibir os dados
    async function carregarCardapio() {
        try {
            // 1. Busca o arquivo JSON (deve estar na raiz do projeto)
            const response = await fetch('dados.json');
            
            if (!response.ok) {
                throw new Error(`Erro ao buscar dados: ${response.statusText}`);
            }

            // 2. Converte a resposta para JSON
            const data = await response.json();
            
            // 3. Limpa o corpo da tabela (caso tenha algo, como uma msg de "carregando")
            tbody.innerHTML = '';
            
            // 4. Itera sobre cada item e cria a linha da tabela
            data.forEach(item => {
                // Cria a linha (tr)
                const tr = document.createElement('tr');
                
                // Adiciona o HTML interno da linha com os dados do item
                tr.innerHTML = `
                    <td><img src="${item.imagem}" alt="${item.alt}"></td>
                    <td>${item.item}</td>
                    <td>${item.descricao}</td>
                    <td>${item.preco}</td>
                `;
                
                // 5. Adiciona a linha ao corpo da tabela
                tbody.appendChild(tr);
            });

        } catch (error) {
            // Exibe um erro no console se algo falhar
            console.error('Erro ao carregar os dados do cardápio:', error);
            tbody.innerHTML = '<tr><td colspan="4">Erro ao carregar o cardápio. Tente novamente mais tarde.</td></tr>';
        }
    }

    // Chama a função para carregar os dados
    if (tbody) {
        carregarCardapio();
    }
});