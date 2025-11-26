CREATE DATABASE IF NOT EXISTS refugio_viajante;
USE refugio_viajante;

-- Tabela do Cardápio (Público)
CREATE TABLE IF NOT EXISTS cardapio (
    id INT AUTO_INCREMENT PRIMARY KEY,
    imagem VARCHAR(255),
    item VARCHAR(100),
    descricao TEXT,
    preco VARCHAR(50)
);

-- Itens Iniciais do Cardápio
INSERT INTO cardapio (imagem, item, descricao, preco) VALUES
('imagens/cafe_ferreiro.png', 'Bebida do Ferreiro', 'Um café forte e escuro como a noite, para despertar o espírito aventureiro.', '7 moedas de cobre'),
('imagens/leite_quente_vale.png', 'Leite Quente do Vale', 'Uma bebida cremosa com especiarias e um toque de mel, coberta com espuma. Aconchego puro.', '10 moedas de cobre'),
('imagens/pao_anao.png', 'Pães do Anão', 'Pequenos e robustos pães de queijo, perfeitos para acompanhar qualquer refeição.', '9 moedas de cobre'),
('imagens/torta_bosque_sombrio.png', 'Torta do Bosque Sombrio', 'Uma fatia generosa de bolo de chocolate denso, com recheio de frutas silvestres.', '14 moedas de cobre'),
('imagens/suco.png', 'Néctar do Pomar Dourado', 'Suco de laranjas e maçãs colhidas sob o sol da manhã, espremido na hora.', '8 moedas de cobre');

-- Tabela de Usuários (Área Restrita) - ESSA PARTE ESTAVA FALTANDO
CREATE TABLE IF NOT EXISTS usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100),
    login VARCHAR(50) UNIQUE,
    senha VARCHAR(255)
);

-- Usuário Admin Padrão (Login: admin / Senha: 1234)
INSERT INTO usuarios (nome, login, senha) VALUES ('Mestre Estalajadeiro', 'admin', '1234');