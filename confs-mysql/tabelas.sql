CREATE TABLE usuario (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100),
    email VARCHAR(100) UNIQUE NOT NULL,
    senha VARCHAR(63) NOT NULL,
    CPF VARCHAR(11) UNIQUE,
    foto_de_perfil VARCHAR(255),
    genero ENUM('F', 'M', 'NB', 'PND', 'NI') DEFAULT 'NI',
    data_de_nascimento DATE,
    telefone VARCHAR(15),
    criado_em DATETIME DEFAULT CURRENT_TIMESTAMP,
    username VARCHAR(20) UNIQUE
);

CREATE TABLE administrador (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_usuario INT NOT NULL,
    tipo ENUM('ADM', 'FUN') DEFAULT 'ADM' NOT NULL,
    rg VARCHAR(9),
    CONSTRAINT fk_administrador_user FOREIGN KEY (id_usuario) REFERENCES usuario(id) ON DELETE CASCADE
);

CREATE TABLE endereco (
    id INT AUTO_INCREMENT PRIMARY KEY,
    cep VARCHAR(9) NOT NULL,
    uf VARCHAR(2) NOT NULL,
    cidade VARCHAR(30) NOT NULL,
    bairro VARCHAR(50) NOT NULL,
    rua VARCHAR(100) NOT NULL,
    numero INT NOT NULL,
    complemento VARCHAR(30)
    -- criado_em DATETIME DEFAULT CURRENT_TIMESTAMP
    -- atualizado_em DATETIME DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE cliente (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_usuario INT NOT NULL,
    endereco_id INT,
    CONSTRAINT fk_cliente_user FOREIGN KEY (id_usuario) REFERENCES usuario(id) ON DELETE CASCADE,
    CONSTRAINT fk_cliente_endereco FOREIGN KEY (endereco_id) REFERENCES endereco(id) ON DELETE SET NULL
);

CREATE TABLE livro (
    id INT AUTO_INCREMENT PRIMARY KEY,
    titulo VARCHAR(200) NOT NULL,
    subtitulo VARCHAR(200),
    data_de_publicacao DATE,
    ano_de_publicacao INT NOT NULL,
    capa VARCHAR(255),
    ISBN VARCHAR(15) UNIQUE NOT NULL,
    sinopse TEXT,
    editora VARCHAR(100) DEFAULT 'Editora não informada',
    preco DECIMAL(5, 2) DEFAULT 0.00 NOT NULL,
    desconto DECIMAL(5, 2),
    quantidade INT NOT NULL,
    qtd_vendidos INT DEFAULT 0
);

CREATE TABLE livro_historico (
    id INT AUTO_INCREMENT PRIMARY KEY,
    livro_id INT NOT NULL,
    tipo_alteracao ENUM('1', '2', '3') NOT NULL,
    detalhes TEXT,
    data_alteracao DATETIME NOT NULL,
    id_usuario INT NOT NULL,
    CONSTRAINT fk_livro_historico_livro FOREIGN KEY (livro_id) REFERENCES livro(id) ON DELETE CASCADE,
    CONSTRAINT fk_livro_historico_user FOREIGN KEY (id_usuario) REFERENCES usuario(id) ON DELETE CASCADE
);

CREATE TABLE autor (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_usuario INT NOT NULL,
    CONSTRAINT fk_autor_user FOREIGN KEY (id_usuario) REFERENCES usuario(id) ON DELETE CASCADE
);

CREATE TABLE autor_historico(
    id INT AUTO_INCREMENT PRIMARY KEY,
    autor_id INT NOT NULL,
    tipo_alteracao ENUM('1', '2', '3') NOT NULL,
    detalhes TEXT,
    data_alteracao DATETIME NOT NULL,
    id_usuario INT NOT NULL,
    CONSTRAINT fk_autor_historico_autor FOREIGN KEY (autor_id) REFERENCES autor(id) ON DELETE CASCADE,
    CONSTRAINT fk_autor_historico_user FOREIGN KEY (id_usuario) REFERENCES usuario(id) ON DELETE CASCADE
);

CREATE TABLE livro_autor (
    livro_id INT NOT NULL,
    autor_id INT NOT NULL,
    PRIMARY KEY (livro_id, autor_id),
    CONSTRAINT fk_livro_autor_livro FOREIGN KEY (livro_id) REFERENCES livro(id) ON DELETE CASCADE,
    CONSTRAINT fk_livro_autor_autor FOREIGN KEY (autor_id) REFERENCES autor(id) ON DELETE CASCADE
);


CREATE TABLE livro_autor_historico (
    id INT AUTO_INCREMENT PRIMARY KEY,
    livro_id INT NOT NULL,
    autor_id INT NOT NULL,
    tipo_alteracao ENUM('1', '2', '3') NOT NULL,
    detalhes TEXT,
    data_alteracao DATETIME NOT NULL,
    id_usuario INT NOT NULL,
    CONSTRAINT fk_livro_autor_historico_livro FOREIGN KEY (livro_id) REFERENCES livro(id) ON DELETE CASCADE,
    CONSTRAINT fk_livro_autor_historico_autor FOREIGN KEY (autor_id) REFERENCES autor(id) ON DELETE CASCADE,
    CONSTRAINT fk_livro_autor_historico_user FOREIGN KEY (id_usuario) REFERENCES usuario(id) ON DELETE CASCADE
);

CREATE TABLE categoria (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL
);

CREATE TABLE categoria_historico (
    id INT AUTO_INCREMENT PRIMARY KEY,
    categoria_id INT NOT NULL,
    tipo_alteracao ENUM('1', '2', '3') NOT NULL,
    detalhes TEXT,
    data_alteracao DATETIME NOT NULL,
    id_usuario INT NOT NULL,
    CONSTRAINT fk_categoria_historico_categoria FOREIGN KEY (categoria_id) REFERENCES categoria(id) ON DELETE CASCADE,
    CONSTRAINT fk_categoria_historico_user FOREIGN KEY (id_usuario) REFERENCES usuario(id) ON DELETE CASCADE
);

CREATE TABLE livro_categoria (
    livro_id INT NOT NULL,
    categoria_id INT NOT NULL,
    PRIMARY KEY (livro_id, categoria_id),
    CONSTRAINT fk_livro_categoria_livro FOREIGN KEY (livro_id) REFERENCES livro(id) ON DELETE CASCADE,
    CONSTRAINT fk_livro_categoria_categoria FOREIGN KEY (categoria_id) REFERENCES categoria(id) ON DELETE CASCADE
);

CREATE TABLE livro_categoria_historico (
    id INT AUTO_INCREMENT PRIMARY KEY,
    livro_id INT NOT NULL,
    categoria_id INT NOT NULL,
    tipo_alteracao ENUM('1', '2', '3') NOT NULL,
    detalhes TEXT,
    data_alteracao DATETIME NOT NULL,
    id_usuario INT NOT NULL,
    CONSTRAINT fk_livro_categoria_historico_livro FOREIGN KEY (livro_id) REFERENCES livro(id) ON DELETE CASCADE,
    CONSTRAINT fk_livro_categoria_historico_categoria FOREIGN KEY (categoria_id) REFERENCES categoria(id) ON DELETE CASCADE,
    CONSTRAINT fk_livro_categoria_historico_user FOREIGN KEY (id_usuario) REFERENCES usuario(id) ON DELETE CASCADE
);

CREATE TABLE genero_literario (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(50) UNIQUE NOT NULL
);

CREATE TABLE genero_literario_historico (
    id INT AUTO_INCREMENT PRIMARY KEY,
    genero_id INT NOT NULL,
    tipo_alteracao ENUM('1', '2', '3') NOT NULL,
    detalhes TEXT,
    data_alteracao DATETIME NOT NULL,
    id_usuario INT NOT NULL,
    CONSTRAINT fk_genero_literario_historico_genero FOREIGN KEY (genero_id) REFERENCES genero_literario(id) ON DELETE CASCADE,
    CONSTRAINT fk_genero_literario_historico_user FOREIGN KEY (id_usuario) REFERENCES usuario(id) ON DELETE CASCADE
);

CREATE TABLE livro_genero (
    livro_id INT NOT NULL,
    genero_id INT NOT NULL,
    PRIMARY KEY (livro_id, genero_id),
    CONSTRAINT fk_livro_genero_livro FOREIGN KEY (livro_id) REFERENCES livro(id) ON DELETE CASCADE,
    CONSTRAINT fk_livro_genero_genero FOREIGN KEY (genero_id) REFERENCES genero_literario(id) ON DELETE CASCADE
);

CREATE TABLE livro_genero_literario_historico (
    id INT AUTO_INCREMENT PRIMARY KEY,
    livro_id INT NOT NULL,
    genero_id INT NOT NULL,
    id_usuario INT NOT NULL,
    tipo_alteracao ENUM('1', '2', '3') NOT NULL,
    detalhes TEXT,
    data_alteracao DATETIME NOT NULL,
    CONSTRAINT fk_livro_genero_literario_historico_livro FOREIGN KEY (livro_id) REFERENCES livro(id) ON DELETE CASCADE,
    CONSTRAINT fk_livro_genero_literario_historico_genero FOREIGN KEY (genero_id) REFERENCES genero_literario(id) ON DELETE CASCADE,
    CONSTRAINT fk_livro_genero_literario_historico_user FOREIGN KEY (id_usuario) REFERENCES usuario(id) ON DELETE CASCADE
);



-- CREATE TABLE endereco_historico (
--     id INT AUTO_INCREMENT PRIMARY KEY,
--     endereco_id INT NOT NULL,
--     tipo_alteracao ENUM('1', '2', '3') NOT NULL,
--     detalhes TEXT,
--     data_alteracao DATETIME NOT NULL,
--     id_usuario INT NOT NULL,
--     CONSTRAINT fk_endereco_historico_endereco FOREIGN KEY (endereco_id) REFERENCES endereco(id) ON DELETE CASCADE,
--     CONSTRAINT fk_endereco_historico_user FOREIGN KEY (id_usuario) REFERENCES usuario(id) ON DELETE CASCADE
-- );

CREATE TABLE carrinho (
    id INT AUTO_INCREMENT PRIMARY KEY,
    session_id VARCHAR(100),
    cliente_id INT,
    total DECIMAL(5, 2) DEFAULT 0.00 NOT NULL,
    CONSTRAINT fk_carrinho_cliente FOREIGN KEY (cliente_id) REFERENCES cliente(id) ON DELETE CASCADE
);

-- CREATE TABLE carrinho_historico (
--     id INT AUTO_INCREMENT PRIMARY KEY,
--     carrinho_id INT NOT NULL,
--     tipo_alteracao ENUM('1', '2', '3') NOT NULL,
--     detalhes TEXT,
--     data_alteracao DATETIME NOT NULL,
--     id_usuario INT NOT NULL,
--     CONSTRAINT fk_carrinho_historico_carrinho FOREIGN KEY (carrinho_id) REFERENCES carrinho(id) ON DELETE CASCADE,
--     CONSTRAINT fk_carrinho_historico_user FOREIGN KEY (id_usuario) REFERENCES usuario(id) ON DELETE CASCADE
-- );

CREATE TABLE cupom (
    id INT AUTO_INCREMENT PRIMARY KEY,
    codigo VARCHAR(50) UNIQUE NOT NULL,
    valor INT NOT NULL DEFAULT 0,
    tipo_valor ENUM('1', '2') DEFAULT '1' NOT NULL,
    ativo BOOLEAN NOT NULL DEFAULT TRUE,
    data_inicio DATETIME NOT NULL,
    data_fim DATETIME NOT NULL
);

CREATE TABLE cupom_historico (
    id INT AUTO_INCREMENT PRIMARY KEY,
    cupom_id INT NOT NULL,
    tipo_alteracao ENUM('1', '2', '3') NOT NULL,
    detalhes TEXT,
    data_alteracao DATETIME NOT NULL,
    id_usuario INT NOT NULL,
    CONSTRAINT fk_cupom_historico_cupom FOREIGN KEY (cupom_id) REFERENCES cupom(id) ON DELETE CASCADE,
    CONSTRAINT fk_cupom_historico_user FOREIGN KEY (id_usuario) REFERENCES usuario(id) ON DELETE CASCADE
);

CREATE TABLE item_carrinho (
    id INT AUTO_INCREMENT PRIMARY KEY,
    livro_id INT NOT NULL,
    quantidade INT NOT NULL,
    preco DECIMAL(5, 2) NOT NULL,
    carrinho_id INT NOT NULL,
    CONSTRAINT fk_item_carrinho_livro FOREIGN KEY (livro_id) REFERENCES livro(id) ON DELETE CASCADE,
    CONSTRAINT fk_item_carrinho_carrinho FOREIGN KEY (carrinho_id) REFERENCES carrinho(id) ON DELETE CASCADE
);

CREATE TABLE pedido (
    numero_pedido VARCHAR(12) PRIMARY KEY,
    cliente_id INT NOT NULL,
    endereco_id INT NOT NULL,
    status_pedido ENUM('PRO', 'CAN', 'CON', 'ENV', 'ENT') DEFAULT 'PRO' NOT NULL,
    data_de_pedido DATETIME NOT NULL,
    entrega_estimada DATETIME NOT NULL,
    data_de_entrega DATETIME NOT NULL,
    valor_total DECIMAL(5, 2) DEFAULT 0.0 NOT NULL,
    desconto DECIMAL(5, 2) DEFAULT 0.0,
    quantia_itens INT DEFAULT 0 NOT NULL,
    cupom_id INT,
    CONSTRAINT fk_pedido_cupom FOREIGN KEY (cupom_id) REFERENCES cupom(id) ON DELETE SET NULL,
    CONSTRAINT fk_pedido_cliente FOREIGN KEY (cliente_id) REFERENCES cliente(id) ON DELETE CASCADE,
    CONSTRAINT fk_pedido_endereco FOREIGN KEY (endereco_id) REFERENCES endereco(id) ON DELETE CASCADE
);

CREATE TABLE pedido_item (
    pedido_id VARCHAR(12) NOT NULL,
    item_id INT NOT NULL,
    PRIMARY KEY (pedido_id, item_id),
    CONSTRAINT fk_pedido_item_pedido FOREIGN KEY (pedido_id) REFERENCES pedido(numero_pedido) ON DELETE CASCADE,
    CONSTRAINT fk_pedido_item_item FOREIGN KEY (item_id) REFERENCES item_carrinho(id) ON DELETE CASCADE
);

-- CREATE TABLE pedido_item_historico (
--     id INT AUTO_INCREMENT PRIMARY KEY,
--     pedido_id VARCHAR(12) NOT NULL,
--     item_id INT NOT NULL,
--     tipo_alteracao ENUM('1', '2', '3') NOT NULL,
--     detalhes TEXT,
--     data_alteracao DATETIME NOT NULL,
--     id_usuario INT NOT NULL,
--     CONSTRAINT fk_pedido_item_historico_pedido FOREIGN KEY (pedido_id) REFERENCES pedido(numero_pedido) ON DELETE CASCADE,
--     CONSTRAINT fk_pedido_item_historico_item FOREIGN KEY (item_id) REFERENCES item_carrinho(id) ON DELETE CASCADE,
--     CONSTRAINT fk_pedido_item_historico_user FOREIGN KEY (id_usuario) REFERENCES usuario(id) ON DELETE CASCADE
-- );