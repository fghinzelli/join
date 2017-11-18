CREATE OR REPLACE VIEW ViewUsuario AS (
    SELECT 
        u.id,
        u.username,
        u.senha,
        p.nome
    FROM 
        Usuario u 
        INNER JOIN Pessoa p ON p.id = u.pessoaId
);
