-- INSERT INTO usuario VALUES (NULL, 'Itamar Vieira Junior', 'itamar.vieira@gmail.com', '123456', '12345678910', 'media/fotos_de_perfil/itamar.webp', 'M', '19790806', '84 98132-7702', NOW());

-- INSERT INTO autor VALUES(NULL, 1);

-- INSERT INTO genero_literario VALUES(NULL, 'Romance');
-- INSERT INTO categoria VALUES(NULL, 'Ficção');
-- INSERT INTO categoria VALUES(NULL, 'Literatura Brasileira');


-- INSERT INTO livro VALUES (
--     NULL, 
--     'Torto Arado',
--     NULL,
--     '20190101',
--     2019, 
--     'media/capas/tortoarado.jpg',
--     '978-6580309313',
--     'Nas profundezas do sertão baiano, as irmãs Bibiana e Belonísia encontram uma velha e misteriosa faca na mala guardada sob a cama da avó. Ocorre então um acidente. E para sempre suas vidas estarão ligadas — a ponto de uma precisar ser a voz da outra. Numa trama conduzida com maestria e com uma prosa melodiosa, o romance conta uma história de vida e morte, de combate e redenção.',
--     'Todavia',
--     47.67,
--     NULL,
--     2324,
--     0
--     );

-- INSERT INTO livro_autor VALUES (1, 1);
-- INSERT INTO livro_genero VALUES (1, 1);
-- INSERT INTO livro_categoria VALUES (1, 1);
-- INSERT INTO livro_categoria VALUES (1, 2);

-- Criação da tabela "livro"
CREATE TABLE livro (
  id INT NOT NULL AUTO_INCREMENT,
  titulo VARCHAR(100) NOT NULL,
  subtitulo VARCHAR(100),
  ISBN VARCHAR(15) NOT NULL UNIQUE, 
  sinopse TEXT NOT NULL,
  capa VARCHAR(255) NOT NULL,  
  autor VARCHAR(200) NOT NULL,
  editora VARCHAR(30) NOT NULL,
  data_publicacao DATE NOT NULL,
  preco DECIMAL(10,2) NOT NULL,
  porc_desconto INT DEFAULT NULL, 
  data_adicao DATE NOT NULL DEFAULT CURRENT_DATE, 
  quantidade_vendida INT NOT NULL,
  estoque INT NOT NULL,
  PRIMARY KEY (id)
);

-- Inserção de dados na tabela "livro"
INSERT INTO livro (
  titulo,
  subtitulo,
  ISBN,
  sinopse,
  capa,
  autor,
  editora,
  data_publicacao,
  preco,
  porc_desconto,
  data_adicao,
  quantidade_vendida,
  estoque
) VALUES 
(
  'Torto Arado',
  'Um arado que era torto e se endireitou',
  '978-6556920993',
  'Nas profundezas do sertão baiano, as irmãs Bibiana e Belonísia encontram uma velha e misteriosa faca na mala guardada sob a cama da avó. Ocorre então um acidente. E para sempre suas vidas estarão ligadas — a ponto de uma precisar ser a voz da outra. Numa trama conduzida com maestria e com uma prosa melodiosa, o romance conta uma história de vida e morte, de combate e redenção.', 
  'media/capas/tortoarado.jpg',
  'Itamar Vieira Junior',
  'Todavia',
  '2019-08-01',
  47.67,
  NULL,
  '2025-02-01',
  2324,
  17
),
(
  '1984',
  'Uma distopia clássica sobre um futuro totalitário',
  '978-8535905783',
  'Em uma sociedade controlada pelo Grande Irmão, Winston Smith começa a questionar o regime opressor. "1984" é um dos maiores clássicos da literatura mundial sobre vigilância e manipulação.',
  'media/capas/1984.jpg',
  'George Orwell',
  'Companhia das Letras',
  '1949-06-08',
  39.90,
  10,
  '2025-02-01',
  5421,
  30
),
(
  'Dom Casmurro',
  'O mistério de Capitu e seus olhos de ressaca',
  '978-8572329870',
  'A história de Bentinho e Capitu é um dos maiores romances da literatura brasileira. Machado de Assis nos envolve em uma narrativa enigmática sobre ciúme e traição.',
  'media/capas/domcasmurro.jpg',
  'Machado de Assis',
  'Editora Globo',
  '1899-01-01',
  29.90,
  5,
  '2025-02-01',
  3520,
  22
),
(
  'O Hobbit',
  'Uma aventura inesperada na Terra-Média',
  '978-8533613376',
  'Bilbo Bolseiro, um hobbit pacato, é arrastado para uma jornada épica ao lado de anões e do mago Gandalf para recuperar um tesouro roubado pelo dragão Smaug.',
  'media/capas/ohobbit.jpg',
  'J.R.R. Tolkien',
  'HarperCollins Brasil',
  '1937-09-21',
  49.90,
  NULL,
  '2025-02-01',
  6457,
  40
),
(
  'Sapiens: Uma Breve História da Humanidade',
  'A trajetória da nossa espécie',
  '978-8535923824',
  'Yuval Noah Harari narra a história da humanidade, desde os primeiros hominídeos até as inovações tecnológicas modernas, questionando o impacto do ser humano no planeta.',
  'media/capas/sapiens.jpg',
  'Yuval Noah Harari',
  'Companhia das Letras',
  '2011-01-01',
  69.90,
  15,
  '2025-02-01',
  9872,
  25
),
(
  'O Pequeno Príncipe',
  'Uma fábula sobre a essência da vida',
  '978-8522031509',
  'A clássica história de Saint-Exupéry sobre um pequeno príncipe que viaja entre planetas e aprende lições sobre amizade, amor e a simplicidade da vida.',
  'media/capas/opequenoprincipe.jpg',
  'Antoine de Saint-Exupéry',
  'Agir',
  '1943-04-06',
  19.90,
  20,
  '2025-02-01',
  20321,
  50
),
(
  'A Revolução dos Bichos',
  'Uma sátira política atemporal',
  '978-8525420058',
  'Nesta fábula política, os animais de uma fazenda se revoltam contra os humanos, mas logo descobrem que o poder pode ser tão corruptor quanto a opressão que tentaram destruir.',
  'media/capas/arevolucaodosbichos.jpg',
  'George Orwell',
  'Companhia das Letras',
  '1945-08-17',
  34.90,
  5,
  '2025-02-01',
  8320,
  28
),
(
  'Crime e Castigo',
  'O dilema moral de um assassino',
  '978-8572322314',
  'O jovem Raskólnikov, um estudante pobre, comete um assassinato e mergulha em uma espiral de culpa e paranoia. Um dos maiores romances psicológicos da literatura mundial.',
  'media/capas/crimeecastigo.jpg',
  'Fiódor Dostoiévski',
  'Editora 34',
  '1866-01-01',
  54.90,
  8,
  '2025-02-01',
  4102,
  18
),
(
  'A Menina que Roubava Livros',
  'Uma história emocionante sobre a Segunda Guerra',
  '978-8598078175',
  'Liesel Meminger descobre o poder das palavras em plena Alemanha nazista, onde livros proibidos se tornam seu refúgio em tempos sombrios.',
  'media/capas/ameninaqueroubavalivros.jpg',
  'Markus Zusak',
  'Intrínseca',
  '2005-09-01',
  45.00,
  NULL,
  '2025-02-01',
  11230,
  35
);


