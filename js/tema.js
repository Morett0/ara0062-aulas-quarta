// ============================================
// ALTERNÂNCIA DE TEMA APRIMORADA
// ============================================

document.addEventListener('DOMContentLoaded', function() {
    
    const btnTema = document.getElementById('btn-tema');
    const html = document.documentElement;
    
    if (!btnTema) return;

    // ============================================
    // DETECTA PREFERÊNCIA DO SISTEMA
    // ============================================
    function detectarPreferenciaSistema() {
        if (window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches) {
            return 'dark';
        }
        return 'light';
    }

    // ============================================
    // CARREGA TEMA SALVO OU PREFERÊNCIA
    // ============================================
    function carregarTema() {
        const temaSalvo = localStorage.getItem('tema');
        
        if (temaSalvo) {
            return temaSalvo;
        }
        
        // Se não tem tema salvo, usa a preferência do sistema
        return detectarPreferenciaSistema();
    }

    // ============================================
    // APLICA TEMA COM ANIMAÇÃO
    // ============================================
    function aplicarTema(tema, comAnimacao = true) {
        // Adiciona classe de transição
        if (comAnimacao) {
            html.classList.add('tema-transicao');
        }
        
        // Define o tema
        html.setAttribute('data-theme', tema);
        localStorage.setItem('tema', tema);
        
        // Atualiza o texto do botão com ícones
        const icone = tema === 'dark' ? '☀️' : '🌙';
        const texto = tema === 'dark' ? 'Modo Claro' : 'Modo Escuro';
        btnTema.innerHTML = `<span style="margin-right: 0.5rem;">${icone}</span>${texto}`;
        
        // Adiciona atributo ARIA para acessibilidade
        btnTema.setAttribute('aria-label', `Ativar ${texto}`);
        
        // Efeito visual no botão
        btnTema.style.transform = 'scale(1.1)';
        setTimeout(() => btnTema.style.transform = 'scale(1)', 200);
        
        // Remove classe de transição após animação
        if (comAnimacao) {
            setTimeout(() => html.classList.remove('tema-transicao'), 300);
        }
        
        // Notificação visual (opcional)
        mostrarNotificacaoTema(tema);
    }

    // ============================================
    // NOTIFICAÇÃO DE MUDANÇA DE TEMA
    // ============================================
    function mostrarNotificacaoTema(tema) {
        const notificacao = document.createElement('div');
        notificacao.className = 'notificacao-tema';
        
        const icone = tema === 'dark' ? '🌙' : '☀️';
        const mensagem = tema === 'dark' ? 'Modo Escuro Ativado' : 'Modo Claro Ativado';
        
        notificacao.innerHTML = `
            <span style="font-size: 1.5rem; margin-right: 0.5rem;">${icone}</span>
            <span>${mensagem}</span>
        `;
        
        notificacao.style.cssText = `
            position: fixed;
            bottom: 20px;
            left: 50%;
            transform: translateX(-50%) translateY(100px);
            background: ${tema === 'dark' ? '#242B3D' : '#FFFFFF'};
            color: ${tema === 'dark' ? '#E8EAED' : '#5D544C'};
            padding: 1rem 2rem;
            border-radius: 50px;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.2);
            z-index: 10000;
            display: flex;
            align-items: center;
            font-weight: 600;
            animation: slideUp 0.3s ease forwards;
        `;
        
        document.body.appendChild(notificacao);
        
        // Adiciona estilos de animação
        if (!document.getElementById('tema-animacao-style')) {
            const style = document.createElement('style');
            style.id = 'tema-animacao-style';
            style.textContent = `
                @keyframes slideUp {
                    to {
                        transform: translateX(-50%) translateY(0);
                    }
                }
                @keyframes slideDown {
                    from {
                        transform: translateX(-50%) translateY(0);
                    }
                    to {
                        transform: translateX(-50%) translateY(100px);
                        opacity: 0;
                    }
                }
                .tema-transicao * {
                    transition: background-color 0.3s ease, 
                                color 0.3s ease, 
                                border-color 0.3s ease,
                                box-shadow 0.3s ease !important;
                }
            `;
            document.head.appendChild(style);
        }
        
        // Remove notificação após 2 segundos
        setTimeout(() => {
            notificacao.style.animation = 'slideDown 0.3s ease forwards';
            setTimeout(() => notificacao.remove(), 300);
        }, 2000);
    }

    // ============================================
    // EVENTO DE CLIQUE NO BOTÃO
    // ============================================
    btnTema.addEventListener('click', function(e) {
        e.preventDefault();
        
        const temaAtual = html.getAttribute('data-theme') || 'light';
        const novoTema = temaAtual === 'light' ? 'dark' : 'light';
        
        aplicarTema(novoTema, true);
    });

    // ============================================
    // DETECTA MUDANÇA NA PREFERÊNCIA DO SISTEMA
    // ============================================
    if (window.matchMedia) {
        window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', e => {
            // Só muda automaticamente se o usuário não tiver definido uma preferência
            if (!localStorage.getItem('tema')) {
                const novoTema = e.matches ? 'dark' : 'light';
                aplicarTema(novoTema, true);
            }
        });
    }

    // ============================================
    // ATALHO DE TECLADO (Ctrl/Cmd + K)
    // ============================================
    document.addEventListener('keydown', function(e) {
        // Ctrl+K ou Cmd+K
        if ((e.ctrlKey || e.metaKey) && e.key === 'k') {
            e.preventDefault();
            btnTema.click();
        }
    });

    // ============================================
    // INICIALIZAÇÃO
    // ============================================
    const temaInicial = carregarTema();
    aplicarTema(temaInicial, false);

    // ============================================
    // TRANSIÇÃO SUAVE AO CARREGAR A PÁGINA
    // ============================================
    window.addEventListener('load', function() {
        document.body.style.opacity = '0';
        document.body.style.transition = 'opacity 0.3s ease';
        
        setTimeout(() => {
            document.body.style.opacity = '1';
        }, 10);
    });

    // ============================================
    // SALVA PREFERÊNCIA AO SAIR DA PÁGINA
    // ============================================
    window.addEventListener('beforeunload', function() {
        const temaAtual = html.getAttribute('data-theme');
        localStorage.setItem('tema', temaAtual);
    });

    // ============================================
    // ADICIONA TOOLTIP NO BOTÃO
    // ============================================
    btnTema.setAttribute('title', 'Alternar tema (Ctrl+K)');
    
    // ============================================
    // LOG PARA DEBUG (remover em produção)
    // ============================================
    console.log(`🎨 Tema inicializado: ${temaInicial}`);
    console.log('💡 Dica: Use Ctrl+K para alternar o tema rapidamente!');
});