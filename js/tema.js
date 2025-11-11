// Conteúdo para: js/tema.js

document.addEventListener('DOMContentLoaded', function() {
    
    const btnTema = document.getElementById('btn-tema');
    
    if (btnTema) {
        btnTema.addEventListener('click', function(e) {
            e.preventDefault(); // Previne que o link '#' navegue
            
            // Seleciona o elemento <html>
            const html = document.documentElement;
            
            // Verifica qual o tema atual
            const temaAtual = html.getAttribute('data-theme');
            
            let novoTema;
            
            if (temaAtual === 'light') {
                novoTema = 'dark';
            } else {
                novoTema = 'light'; // Padrão é light
            }
            
            // Aplica o novo tema ao <html>
            html.setAttribute('data-theme', novoTema);
            
            // Salva a preferência no localStorage
            localStorage.setItem('tema', novoTema);
        });
    }
});