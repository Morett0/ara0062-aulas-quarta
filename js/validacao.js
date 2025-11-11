// Conteúdo para: js/validacao.js

// Aguarda o DOM estar completamente carregado
document.addEventListener('DOMContentLoaded', function() {
    
    // Seleciona o formulário pelo ID que definimos
    const form = document.getElementById('form-contato');
    
    // Seleciona o campo do CPF para a máscara
    const cpfInput = document.getElementById('cpf');

    // Se o formulário não existir, não faz nada
    if (!form) {
        return;
    }

    // --- Máscara do CPF ---
    // Adiciona a máscara enquanto o usuário digita
    if(cpfInput) {
        cpfInput.addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, ''); // Remove tudo que não é dígito
            
            if (value.length > 11) {
                value = value.substring(0, 11);
            }

            let formattedValue = '';
            if (value.length > 9) {
                formattedValue = value.replace(/(\d{3})(\d{3})(\d{3})(\d{2})/, '$1.$2.$3-$4');
            } else if (value.length > 6) {
                formattedValue = value.replace(/(\d{3})(\d{3})(\d{1,3})/, '$1.$2.$3');
            } else if (value.length > 3) {
                formattedValue = value.replace(/(\d{3})(\d{1,3})/, '$1.$2');
            } else {
                formattedValue = value;
            }
            e.target.value = formattedValue;
        });
    }

    
    // Adiciona um ouvinte para o evento 'submit' (envio)
    form.addEventListener('submit', function(event) {
        
        // Seleciona o campo de email
        const emailInput = document.getElementById('email');
        
        // Pega os valores (removendo espaços em branco)
        const email = emailInput.value.trim();
        const cpf = cpfInput.value.trim();
        
        // Reseta mensagens de erro (caso existam)
        removeErro(emailInput);
        removeErro(cpfInput);
        
        let formValido = true;

        // 1. Validação do E-mail
        // Regex para validar o formato "joao.silva@net.com"
        const emailRegex = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
        if (!emailRegex.test(email)) {
            mostraErro(emailInput, 'Formato de e-mail inválido. Use o formato seu.nome@dominio.com');
            formValido = false;
        }
        
        // 2. Validação do CPF
        // Regex para o formato "999.999.999-99"
        const cpfRegex = /^\d{3}\.\d{3}\.\d{3}-\d{2}$/;
        if (cpf && !cpfRegex.test(cpf)) { // Só valida se o CPF foi preenchido
            mostraErro(cpfInput, 'Formato de CPF inválido. Use o formato 999.999.999-99');
            formValido = false;
        }

        // Se o formulário NÃO for válido, impede o envio
        if (!formValido) {
            event.preventDefault(); // Impede o envio do formulário
            alert("Por favor, corrija os campos destacados antes de enviar.");
        }
    });

    // --- Funções Auxiliares para mostrar e limpar erros ---

    function mostraErro(input, mensagem) {
        // Cria um elemento <small> para exibir a mensagem de erro
        const erroMsg = document.createElement('small');
        erroMsg.className = 'msg-erro'; // Classe para estilização
        erroMsg.textContent = mensagem;
        
        // Adiciona a classe de erro ao input e insere a mensagem
        input.classList.add('input-erro');
        // Insere a mensagem logo após o input
        input.insertAdjacentElement('afterend', erroMsg);

        // Adiciona estilos de erro dinamicamente (para não ter que criar no CSS)
        const styleId = 'validacao-estilos-erro';
        if (!document.getElementById(styleId)) {
            const style = document.createElement('style');
            style.id = styleId;
            style.textContent = `
                .input-erro {
                    border-color: #E87A7A !important;
                    background-color: #FBF0F0 !important;
                }
                .msg-erro {
                    color: #D96A6A;
                    display: block;
                    margin-top: -0.75rem;
                    margin-bottom: 1rem;
                }
            `;
            document.head.appendChild(style);
        }
    }

    function removeErro(input) {
        // Remove a classe de erro
        input.classList.remove('input-erro');
        
        // Encontra e remove a mensagem de erro, se existir
        const erroMsg = input.nextElementSibling;
        if (erroMsg && erroMsg.classList.contains('msg-erro')) {
            erroMsg.remove();
        }
    }
});