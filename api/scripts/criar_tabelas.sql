CREATE TABLE IF NOT EXISTS tb_usuarios(
    id SERIAL NOT NULL PRIMARY KEY,
    nome_completo VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    senha VARCHAR(255) NOT NULL,
    telefone_celular VARCHAR(255) NOT NULL,
    nivel_acesso TEXT NOT NULL,
    ativo BOOLEAN NOT NULL DEFAULT true
);

CREATE TABLE IF NOT EXISTS tb_clientes(
    id SERIAL NOT NULL PRIMARY KEY,
    tipo_pessoa VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    telefone_celular TEXT NOT NULL,
    telefone_complementar TEXT,
    telefone_fixo TEXT,
    nome_completo TEXT,
    razao_social TEXT,
    cpf TEXT,
    cnpj TEXT,
    data_nascimento TEXT,
    sexo TEXT,
    inscricao_estadual TEXT,
    link_site TEXT
);