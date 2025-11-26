// ============================================
// VALIDAÇÃO DE FORMULÁRIO APRIMORADA
// ============================================

document.addEventListener('DOMContentLoaded', function() {
    
    const form = document.getElementById('form-contato');
    const cpfInput = document.getElementById('cpf');
    const emailInput = document.getElementById('email');
    const nomeInput = document.getElementById('nome');
    const mensagemInput = document.getElementById('mensagem');

    if (!form) return;

    // ============================================
    // MÁSCARA DO CPF COM FEEDBACK VISUAL
    // ============================================
    if(cpfInput) {
        cpfInput.addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, '');
            
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
            
            // Validação em tempo real
            if (value.length === 11) {
                if (validarCPF(value)) {
                    mostrarSucesso(cpfInput);
                } else {
                    mostrarErro(cpfInput, 'CPF inválido');
                }
            } else if (value.length > 0) {
                removeErro(cpfInput);
                removeSucesso(cpfInput);
            }
        });
    }

    // ============================================
    // VALIDAÇÃO DE EMAIL EM TEMPO REAL
    // ============================================
    if(emailInput) {
        emailInput.addEventListener('blur', function() {
            const email = this.value.trim();
            const emailRegex = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
            
            if (email && !emailRegex.test(email)) {
                mostrarErro(emailInput, 'Formato de e-mail inválido');
            } else if (email) {
                mostrarSucesso(emailInput);
            }
        });

        emailInput.addEventListener('input', function() {
            if (this.classList.contains('input-erro')) {
                removeErro(this);
            }
        });
    }

    // ============================================
    // VALIDAÇÃO DE NOME
    // ============================================
    if(nomeInput) {
        nomeInput.addEventListener('blur', function() {
            const nome = this.value.trim();
            
            if (nome.length < 3) {
                mostrarErro(nomeInput, 'Nome deve ter pelo menos 3 caracteres');
            } else if (nome.length > 0) {
                mostrarSucesso(nomeInput);
            }
        });

        nomeInput.addEventListener('input', function() {
            if (this.classList.contains('input-erro')) {
                removeErro(this);
            }
        });
    }

    // ============================================
    // CONTADOR DE CARACTERES PARA MENSAGEM
    // ============================================
    if(mensagemInput) {
        const maxLength = 500;
        const contador = document.createElement('small');
        contador.className = 'contador-caracteres';
        contador.style.cssText = 'display: block; text-align: right; margin-top: 0.25rem; color: #7b8495;';
        mensagemInput.parentNode.appendChild(contador);

        function atualizarContador() {
            const length = mensagemInput.value.length;
            contador.textContent = `${length}/${maxLength} caracteres`;
            
            if (length > maxLength) {
                contador.style.color = '#C85A54';
            } else if (length > maxLength * 0.9) {
                contador.style.color = '#E89F7A';
            } else {
                contador.style.color = '#7b8495';
            }
        }

        mensagemInput.addEventListener('input', atualizarContador);
        atualizarContador();
    }

    // ============================================
    // VALIDAÇÃO NO SUBMIT
    // ============================================
    form.addEventListener('submit', function(event) {
        
        const nome = nomeInput.value.trim();
        const email = emailInput.value.trim();
        const cpf = cpfInput.value.trim();
        
        // Limpa mensagens anteriores
        removeErro(emailInput);
        removeErro(cpfInput);
        removeErro(nomeInput);
        
        let formValido = true;
        let erros = [];

        // Validação do Nome
        if (!nome || nome.length < 3) {
            mostrarErro(nomeInput, 'Nome deve ter pelo menos 3 caracteres');
            erros.push('Nome inválido');
            formValido = false;
        }

        // Validação do E-mail
        const emailRegex = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
        if (!email || !emailRegex.test(email)) {
            mostrarErro(emailInput, 'Formato de e-mail inválido. Use o formato seu.nome@dominio.com');
            erros.push('E-mail inválido');
            formValido = false;
        }
        
        // Validação do CPF
        const cpfRegex = /^\d{3}\.\d{3}\.\d{3}-\d{2}$/;
        if (cpf && !cpfRegex.test(cpf)) {
            mostrarErro(cpfInput, 'Formato de CPF inválido. Use o formato 999.999.999-99');
            erros.push('CPF com formato inválido');
            formValido = false;
        } else if (cpf) {
            const cpfNumeros = cpf.replace(/\D/g, '');
            if (!validarCPF(cpfNumeros)) {
                mostrarErro(cpfInput, 'CPF inválido');
                erros.push('CPF inválido');
                formValido = false;
            }
        }

        // Se inválido, previne envio e mostra notificação
        if (!formValido) {
            event.preventDefault();
            
            // Notificação visual melhorada
            mostrarNotificacao(
                'Atenção!', 
                'Por favor, corrija os campos destacados antes de enviar.', 
                'erro'
            );

            // Scroll para o primeiro erro
            const primeiroErro = form.querySelector('.input-erro');
            if (primeiroErro) {
                primeiroErro.scrollIntoView({ behavior: 'smooth', block: 'center' });
                primeiroErro.focus();
            }
        } else {
            // Feedback de sucesso
            mostrarNotificacao(
                'Enviando...', 
                'Seu pergaminho está sendo preparado para envio!', 
                'sucesso'
            );
        }
    });

    // ============================================
    // VALIDAÇÃO ALGORÍTMICA DE CPF
    // ============================================
    function validarCPF(cpf) {
        // Remove caracteres não numéricos
        cpf = cpf.replace(/\D/g, '');
        
        // Verifica se tem 11 dígitos
        if (cpf.length !== 11) return false;
        
        // Verifica se todos os dígitos são iguais
        if (/^(\d)\1{10}$/.test(cpf)) return false;
        
        // Validação do primeiro dígito verificador
        let soma = 0;
        for (let i = 0; i < 9; i++) {
            soma += parseInt(cpf.charAt(i)) * (10 - i);
        }
        let resto = (soma * 10) % 11;
        if (resto === 10 || resto === 11) resto = 0;
        if (resto !== parseInt(cpf.charAt(9))) return false;
        
        // Validação do segundo dígito verificador
        soma = 0;
        for (let i = 0; i < 10; i++) {
            soma += parseInt(cpf.charAt(i)) * (11 - i);
        }
        resto = (soma * 10) % 11;
        if (resto === 10 || resto === 11) resto = 0;
        if (resto !== parseInt(cpf.charAt(10))) return false;
        
        return true;
    }

    // ============================================
    // FUNÇÕES AUXILIARES DE UI
    // ============================================
    
    function mostrarErro(input, mensagem) {
        removeErro(input);
        removeSucesso(input);
        
        const erroMsg = document.createElement('small');
        erroMsg.className = 'msg-erro';
        erroMsg.innerHTML = `<span style="font-size: 1.2em;">⚠️</span> ${mensagem}`;
        
        input.classList.add('input-erro');
        input.parentNode.appendChild(erroMsg);
        
        // Animação de shake
        input.style.animation = 'shake 0.3s';
        setTimeout(() => input.style.animation = '', 300);
        
        aplicarEstilosErro();
    }

    function mostrarSucesso(input) {
        removeErro(input);
        removeSucesso(input);
        
        input.classList.add('input-sucesso');
        
        const sucessoMsg = document.createElement('small');
        sucessoMsg.className = 'msg-sucesso';
        sucessoMsg.innerHTML = '<span style="font-size: 1.2em;">✓</span> Campo válido';
        
        input.parentNode.appendChild(sucessoMsg);
        
        aplicarEstilosSucesso();
    }

    function removeErro(input) {
        input.classList.remove('input-erro');
        const erroMsg = input.parentNode.querySelector('.msg-erro');
        if (erroMsg) erroMsg.remove();
    }

    function removeSucesso(input) {
        input.classList.remove('input-sucesso');
        const sucessoMsg = input.parentNode.querySelector('.msg-sucesso');
        if (sucessoMsg) sucessoMsg.remove();
    }

    function aplicarEstilosErro() {
        if (document.getElementById('validacao-estilos-erro')) return;
        
        const style = document.createElement('style');
        style.id = 'validacao-estilos-erro';
        style.textContent = `
            .input-erro {
                border-color: #C85A54 !important;
                background-color: rgba(200, 90, 84, 0.05) !important;
                box-shadow: 0 0 0 3px rgba(200, 90, 84, 0.1) !important;
            }
            .msg-erro {
                color: #C85A54;
                display: block;
                margin-top: 0.5rem;
                font-weight: 500;
                animation: fadeInUp 0.3s ease;
            }
            @keyframes shake {
                0%, 100% { transform: translateX(0); }
                25% { transform: translateX(-10px); }
                75% { transform: translateX(10px); }
            }
        `;
        document.head.appendChild(style);
    }

    function aplicarEstilosSucesso() {
        if (document.getElementById('validacao-estilos-sucesso')) return;
        
        const style = document.createElement('style');
        style.id = 'validacao-estilos-sucesso';
        style.textContent = `
            .input-sucesso {
                border-color: #6B9B7A !important;
                background-color: rgba(107, 155, 122, 0.05) !important;
            }
            .msg-sucesso {
                color: #6B9B7A;
                display: block;
                margin-top: 0.5rem;
                font-weight: 500;
                animation: fadeInUp 0.3s ease;
            }
        `;
        document.head.appendChild(style);
    }

    function mostrarNotificacao(titulo, mensagem, tipo) {
        // Remove notificação anterior se existir
        const notifAnterior = document.querySelector('.notificacao-custom');
        if (notifAnterior) notifAnterior.remove();
        
        const notificacao = document.createElement('div');
        notificacao.className = 'notificacao-custom';
        
        const cores = {
            erro: { bg: '#C85A54', icon: '⚠️' },
            sucesso: { bg: '#6B9B7A', icon: '✓' },
            info: { bg: '#5D7A99', icon: 'ℹ️' }
        };
        
        const config = cores[tipo] || cores.info;
        
        notificacao.innerHTML = `
            <div style="display: flex; align-items: center; gap: 1rem;">
                <span style="font-size: 2rem;">${config.icon}</span>
                <div>
                    <strong style="display: block; margin-bottom: 0.25rem;">${titulo}</strong>
                    <span>${mensagem}</span>
                </div>
            </div>
        `;
        
        notificacao.style.cssText = `
            position: fixed;
            top: 20px;
            right: 20px;
            background: ${config.bg};
            color: white;
            padding: 1.5rem;
            border-radius: 8px;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.3);
            z-index: 10000;
            max-width: 400px;
            animation: slideInRight 0.3s ease;
        `;
        
        document.body.appendChild(notificacao);
        
        // Adiciona animação
        const styleAnim = document.createElement('style');
        styleAnim.textContent = `
            @keyframes slideInRight {
                from {
                    transform: translateX(400px);
                    opacity: 0;
                }
                to {
                    transform: translateX(0);
                    opacity: 1;
                }
            }
            @keyframes fadeOut {
                to {
                    opacity: 0;
                    transform: translateX(400px);
                }
            }
        `;
        document.head.appendChild(styleAnim);
        
        // Remove após 4 segundos
        setTimeout(() => {
            notificacao.style.animation = 'fadeOut 0.3s ease';
            setTimeout(() => notificacao.remove(), 300);
        }, 4000);
    }
});