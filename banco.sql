CREATE DATABASE refugio_viajante;
USE refugio_viajante;

CREATE TABLE cardapio (
    id INT AUTO_INCREMENT PRIMARY KEY,
    imagem VARCHAR(255),
    item VARCHAR(100),
    descricao TEXT,
    preco VARCHAR(50)
);

INSERT INTO cardapio (imagem, item, descricao, preco) VALUES
('imagens/cafe_ferreiro.png', 'Bebida do Ferreiro', 'Um café forte e escuro como a noite, para despertar o espírito aventureiro.', '7 moedas de cobre'),
('imagens/leite_quente_vale.png', 'Leite Quente do Vale', 'Uma bebida cremosa com especiarias e um toque de mel, coberta com espuma. Aconchego puro.', '10 moedas de cobre'),
('imagens/pao_anao.png', 'Pães do Anão', 'Pequenos e robustos pães de queijo, perfeitos para acompanhar qualquer refeição.', '9 moedas de cobre'),
('imagens/torta_bosque_sombrio.png', 'Torta do Bosque Sombrio', 'Uma fatia generosa de bolo de chocolate denso, com recheio de frutas silvestres.', '14 moedas de cobre'),
('imagens/suco.png', 'Néctar do Pomar Dourado', 'Suco de laranjas e maçãs colhidas sob o sol da manhã, espremido na hora.', '8 moedas de cobre');