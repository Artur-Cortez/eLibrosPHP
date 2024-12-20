INSERT INTO usuario VALUES (NULL, 'Itamar Vieira Junior', 'itamar.vieira@gmail.com', '123456', '12345678910', 'media/fotos_de_perfil/itamar.webp', 'M', '19790806', '84 98132-7702', NOW());

INSERT INTO autor VALUES(NULL, 1);

INSERT INTO genero_literario VALUES(NULL, 'Romance');
INSERT INTO categoria VALUES(NULL, 'Ficção');
INSERT INTO categoria VALUES(NULL, 'Literatura Brasileira');


INSERT INTO livro VALUES (
    NULL, 
    'Torto Arado',
    NULL,
    '20190101',
    2019, 
    'media/capas/tortoarado.jpg',
    '978-6580309313',
    'Nas profundezas do sertão baiano, as irmãs Bibiana e Belonísia encontram uma velha e misteriosa faca na mala guardada sob a cama da avó. Ocorre então um acidente. E para sempre suas vidas estarão ligadas — a ponto de uma precisar ser a voz da outra. Numa trama conduzida com maestria e com uma prosa melodiosa, o romance conta uma história de vida e morte, de combate e redenção.',
    'Todavia',
    47.67,
    NULL,
    2324,
    0
    );

INSERT INTO livro_autor VALUES (1, 1);
INSERT INTO livro_genero VALUES (1, 1);
INSERT INTO livro_categoria VALUES (1, 1);
INSERT INTO livro_categoria VALUES (1, 2);
