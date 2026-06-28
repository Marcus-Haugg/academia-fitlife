-- ============================================================
--  Academia FitLife — Script de criação das tabelas
-- ============================================================

-- Tabela de Planos (deve ser criada antes de alunos)
CREATE TABLE planos (
    id            SERIAL PRIMARY KEY,
    nome          VARCHAR(100)   NOT NULL,
    descricao     TEXT,
    preco_mensal  DECIMAL(10,2)  NOT NULL,
    duracao_meses INTEGER        NOT NULL DEFAULT 1,
    criado_em     TIMESTAMP      DEFAULT CURRENT_TIMESTAMP
);

-- Tabela de Alunos (referencia planos)
CREATE TABLE alunos (
    id               SERIAL PRIMARY KEY,
    nome             VARCHAR(150) NOT NULL,
    email            VARCHAR(150) NOT NULL UNIQUE,
    telefone         VARCHAR(20),
    data_nascimento  DATE         NOT NULL,
    data_matricula   DATE         NOT NULL DEFAULT CURRENT_DATE,
    plano_id         INTEGER      REFERENCES planos(id) ON DELETE SET NULL,
    cep              VARCHAR(9),
    rua              VARCHAR(200),
    bairro           VARCHAR(100),
    cidade           VARCHAR(100),
    criado_em        TIMESTAMP    DEFAULT CURRENT_TIMESTAMP
);

-- Se o banco já existia, rode para adicionar os campos de endereço:
-- ALTER TABLE alunos ADD COLUMN IF NOT EXISTS cep     VARCHAR(9);
-- ALTER TABLE alunos ADD COLUMN IF NOT EXISTS rua     VARCHAR(200);
-- ALTER TABLE alunos ADD COLUMN IF NOT EXISTS bairro  VARCHAR(100);
-- ALTER TABLE alunos ADD COLUMN IF NOT EXISTS cidade  VARCHAR(100);
