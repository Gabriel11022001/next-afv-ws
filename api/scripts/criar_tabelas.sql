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

CREATE TABLE IF NOT EXISTS tb_categorias_produtos(
    id SERIAL NOT NULL PRIMARY KEY,
    descricao TEXT NOT NULL,
    status BOOLEAN DEFAULT true
);

CREATE TABLE IF NOT EXISTS tb_produtos(
    id SERIAL NOT NULL PRIMARY KEY,
    nome_produto TEXT NOT NULL,
    codigo TEXT,
    codigo_barras TEXT,
    status BOOLEAN DEFAULT true,
    preco_venda DECIMAL NOT NULL,
    preco_compra DECIMAL NOT NULL,
    unidades_estoque INTEGER NOT NULL,
    url_foto TEXT NOT NULL,
    categoria_id INTEGER NOT NULL,
    FOREIGN KEY(categoria_id) REFERENCES tb_categorias_produtos(id)
);