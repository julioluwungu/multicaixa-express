USE multicaixa_express;

-- UTILIZADOR TESTE 1
INSERT INTO usuarios (nome, email, senha, saldo)
VALUES (
    'João Silva',
    'joao@test.com',
    '$2y$10$abcdefghijklmnopqrstuv1234567890abcdef',
    50000
);

-- UTILIZADOR TESTE 2
INSERT INTO usuarios (nome, email, senha, saldo)
VALUES (
    'Maria Fernandes',
    'maria@test.com',
    '$2y$10$abcdefghijklmnopqrstuv1234567890abcdef',
    30000
);