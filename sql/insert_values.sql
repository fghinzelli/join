    -- Diocese
    INSERT INTO `Diocese` (`id`, `nome`, `cnpj`, `email`, `telefone`, `logradouro`, `numero`, `complemento`, `bairro`, `municipioId`, `status`, `dataUltimaAlteracao`, `usuarioUltimaAlteracaoId`) VALUES (NULL, 'Diocese de Caxias do Sul', '12345649687', 'diocese@diocese.com.br', NULL, NULL, NULL, NULL, NULL, NULL, '1', NULL, '1');

    -- Paroquia
    INSERT INTO `Paroquia` (`id`, `nome`, `cnpj`, `email`, `telefone`, `logradouro`, `numero`, `complemento`, `bairro`, `municipioId`, `dioceseId`, `status`, `dataUltimaAlteracao`, `usuarioUltimaAlteracaoId`) VALUES (NULL, 'Nossa Senhora Mãe de Deus', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '1', '1', NULL, NULL);

    -- Comunidade
    INSERT INTO `Comunidade` (`id`, `nome`, `padroeiro`, `paroquiaId`, `dataFuncacao`, `responsavelCatequese`, `logradouro`, `numero`, `complemento`, `bairro`, `municipioId`, `email`, `telefone`, `status`, `dataUltimaAlteracao`, `usuarioUltimaAlteracaoId`) VALUES (NULL, 'Igreja Matriz Nossa Senhora Mãe de Deus', 'Nossa Senhora Mãe de Deus', '1', NULL, NULL, NULL, NULL, NULL, NULL, '1', NULL, NULL, '1', NULL, NULL);

    -- Nivel de acesso
    INSERT INTO `AcessoNivel` (`id`, `descricao`, `status`) VALUES (NULL, 'Administrador', '1');

    -- Pessoa
    INSERT INTO `Pessoa` (`id`, `nome`, `sexo`, `nomePai`, `nomeMae`, `dataNascimento`, `telefone1`, `telefone2`, `cpf`, `rg`, `email`, `logradouro`, `numero`, `complemento`, `bairro`, `municipioId`, `numeroDizimo`, `comunidadeId`, `observacoes`, `batizado`, `localBatismo`, `primeiraEucaristia`, `localPrimeiraEucaristia`, `status`, `dataUltimaAlteracao`, `usuarioUltimaAlteracaoId`) 
    VALUES 
    (NULL, 'Fulano de Tal', 'M', 'Adão de Tal', 'Eva de Tal', '2017-08-14', NULL, NULL, NULL, NULL, 'abc@gmail.com', NULL, NULL, NULL, NULL, NULL, '12345', 1,  NULL, 1, NULL, NULL, NULL, 1, NULL, NULL),
    (NULL, 'Maria da Silva', 'F', 'Mario da Silva', 'Isabel da Silva', '2017-06-11', NULL, NULL, NULL, NULL, 'abc@gmail.com', NULL, NULL, NULL, NULL, NULL, '12345', 1,  NULL, 1, NULL, NULL, NULL, 1, NULL, NULL),
    (NULL, 'Antônio de Jesus', 'M', 'João de Jesus', 'Marta de Jesus', '2017-08-14', NULL, NULL, NULL, NULL, 'abc@gmail.com', NULL, NULL, NULL, NULL, NULL, '12345', 1,  NULL, 1, NULL, NULL, NULL, 1, NULL, NULL),
    (NULL, 'Salete da Costa', 'F', 'Mario da Costa', 'Teresa da Costa', '2017-06-11', NULL, NULL, NULL, NULL, 'abc@gmail.com', NULL, NULL, NULL, NULL, NULL, '12345', 1,  NULL, 1, NULL, NULL, NULL, 1, NULL, NULL),
    (NULL, 'Rafael Gonçalves', 'M', 'Jose Gonçalves', 'Lourdes Gonçalves', '2017-08-14', NULL, NULL, NULL, NULL, 'abc@gmail.com', NULL, NULL, NULL, NULL, NULL, '12345', 1,  NULL, 1, NULL, NULL, NULL, 1, NULL, NULL),
    (NULL, 'Simone da Cruz', 'F', 'Mario da Cruz', 'Salete da Cruz', '2017-06-11', NULL, NULL, NULL, NULL, 'abc@gmail.com', NULL, NULL, NULL, NULL, NULL, '12345', 1,  NULL, 1, NULL, NULL, NULL, 1, NULL, NULL),
    (NULL, 'Gabriel da Costa', 'M', 'Douglas da Costa', 'Maria da Costa', '2017-08-14', NULL, NULL, NULL, NULL, 'abc@gmail.com', NULL, NULL, NULL, NULL, NULL, '12345', 1,  NULL, 1, NULL, NULL, NULL, 1, NULL, NULL),
    (NULL, 'Jéssica Antunes', 'F', 'Mario Antunes', 'Maria Antunes', '2017-06-11', NULL, NULL, NULL, NULL, 'abc@gmail.com', NULL, NULL, NULL, NULL, NULL, '12345', 1,  NULL, 1, NULL, NULL, NULL, 1, NULL, NULL);


    -- Usuario
    INSERT INTO `Usuario` (`id`, `username`, `senha`, `pessoaId`, `token`, `tokenExpiracao`, `status`, `dataUltimaAlteracao`, `usuarioUltimaAlteracaoId`) VALUES (NULL, 'fghinzelli', '$2y$10$K/V0l5OwEQH59sZiNLoG4eRWAhcGIgHgDiR2/tVNeWvJRNEGFmwDO', 1, '07d5ccaeb0da5486', '2017-10-31 03:23:13', 1, NULL, NULL);

    -- AcessoParoquia 
    INSERT INTO `AcessoParoquia` (`id`, `paroquiaId`, `usuarioId`, `nivelAcessoId`) VALUES (NULL, '1', '1', '1');

    -- Catequistas
    INSERT INTO `Catequista` (`id`, `pessoaId`, `comunidadeId`, `dataInicio`, `observacoes`, `status`, `dataUltimaAlteracao`, `usuarioUltimaAlteracaoId`) VALUES
    (1, 1, 1, '2017-11-01 00:00:00', 'Observacoes abc', 1, '2017-11-07 06:02:31', NULL),
    (2, 2, 1, '2017-11-01 00:00:00', 'Observacoes ALTERACAO', 1, '2017-11-07 06:05:00', NULL),
    (3, 3, 1, '2017-11-01 00:00:00', 'Observacoessss', 1, '2017-11-07 06:04:50', NULL),
    (4, 4, 1, '2017-11-01 00:00:00', 'Observacoessss', 1, '2017-11-07 06:04:39', NULL),
    (5, 5, 1, '2017-11-01 00:00:00', 'Observacoes', 1, '2017-11-07 06:06:44', NULL);


    -- etapas catequese

    INSERT INTO `EtapaCatequese` (`id`, `descricao`, `status`) 
    VALUES 
    (NULL, 'Primeira Etapa', '1'), 
    (NULL, 'Segunda Etapa', '1'), 
    (NULL, 'Terceira Etapa', '1'), 
    (NULL, 'Quarta Etapa', '1'),
    (NULL, 'Catequese de Adultos', '1');

    -- Etapas escola

    INSERT INTO `EtapaEscola` (`id`, `descricao`, `status`) VALUES (NULL, 'Primeiro Ano', '1');

    -- ESCOLAS

    INSERT INTO `Escola` (`id`, `nome`, `email`, `telefone`, `pessoaContato`, `observacoes`, `status`) VALUES 
    (NULL, 'Escola Municipal Antonia da Silva', 'antonia@escola.com.br', '23451234', 'Maria da Costa', 'observaçoes da escola teste', '1'),
    (NULL, 'Escola Estadual Santana', 'santana@escola.com.br', '23451234', 'Jose Panisson', 'observaçoes da escola teste', '1'),
    (NULL, 'Escola Estadual Ulisses Cabral', 'ulisses@escola.com.br', '23451234', 'Sonia da Costa', 'observaçoes da escola teste', '1'),
    (NULL, 'Escola Marista Santo Antonio', 'stoantonio@escola.com.br', '23451234', 'Ir Moacir', 'observaçoes da escola teste', '1');

    -- turnos

    INSERT INTO `Turno` (`id`, `descricao`, `status`) 
    VALUES
    (NULL, 'Manhã', '1'),
    (NULL, 'Tarde', '1'),
    (NULL, 'Vespertino', '1'),
    (NULL, 'Noite', '1');

    -- Situacao dizimo

    INSERT INTO `SituacaoDizimo` (`id`, `descricao`, `status`) VALUES 
    (1, 'Pago', '1'), (2, 'Parcelado', '1');

    -- Situacao Inscricao

    INSERT INTO `SituacaoInscricao` (`id`, `descricao`, `status`) VALUES 
    (1, 'Cadastrada', '1'), (2, 'Pendente', '1');


    -- TurmasCatequese

    INSERT INTO `TurmaCatequese` (`id`, `etapaCatequeseId`, `catequistaId`, `observacoes`, `turnoId`, `diaSemana`, `status`, `dataUltimaAlteracao`, `usuarioUltimaAlteracaoId`, `horario`, `comunidadeId`, `dataInicio`, `dataTermino`) 
    VALUES 
    (1, '1', '1', 'obs', '1', '1', '1', NULL, NULL, '13:00', '1', '2017-11-08', NULL),
    (2, '2', '2', 'obs', '2', '2', '1', NULL, NULL, '13:00', '1', '2017-11-08', NULL);


    -- InscricaoCatequese

    INSERT INTO `InscricaoCatequese` (`id`, `pessoaId`, `etapaCatequeseId`, `escolaId`, `turmaId`, `etapaEscolaId`, `observacoes`, `situacaoInscricaoId`, `turnoId`, `situacaoDizimoId`, `comunidadeId`, `dataInscricao`, `status`, `dataUltimaAlteracao`, `usuarioUltimaAlteracaoId`) 
    VALUES
    (NULL, 2, 3, 3, NULL, 1, 'xxxxx', 1, 2, 2, 1, '2017-11-07', 1, NULL, NULL),
    (NULL, 2, 3, 1, 2, 1, 'abcde', 1, 2, 2, 1, '2017-11-07', 2, '2017-11-08 21:42:57', NULL),
    (NULL, 2, 3, 1, 2, NULL, 'abcde', 1, 2, 2, 1, '2017-11-07', 2, '2017-11-08 21:43:32', NULL);