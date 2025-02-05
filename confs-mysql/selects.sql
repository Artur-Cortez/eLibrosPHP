/*Ver nome de autor*/

select nome as 'Nome do autor' from usuario
inner join autor on autor.id_usuario = usuario.id;

/*Ver nome de cliente*/
select cliente.id, usuario.nome as 'Nome do cliente' from usuario
inner join cliente on cliente.id_usuario = usuario.id;


/*Ver título do livro e nome do autor*/

select titulo, usuario.nome as 'Nome do autor' from livro
inner join livro_autor on livro_autor.livro_id = livro.id
inner join autor on autor.id = livro_autor.autor_id
inner join usuario on usuario.id = autor.id_usuario;

/*Ver título do livro e gênero do livro*/
select titulo, genero_literario.nome as 'Gênero do livro' from livro
inner join livro_genero on livro_genero.livro_id = livro.id
inner join genero_literario on genero_literario.id = livro_genero.genero_id;

/*Ver título do livro e categoria do livro*/
select titulo, categoria.nome as 'Categoria do livro' from livro
inner join livro_categoria on livro_categoria.livro_id = livro.id
inner join categoria on categoria.id = livro_categoria.categoria_id;

/*Ver itens do carrinho*/
select livro.titulo, item_carrinho.quantidade as 'Quantidade adicionada ao carrinho', item_carrinho.preco from livro
inner join item_carrinho on item_carrinho.livro_id = livro.id
inner join carrinho on carrinho.id = item_carrinho.carrinho_id
where item_carrinho.carrinho_id = 1;
-- where carrinho.session_id = ' 9f5087c7d9b3a6f5245a38a88a155fdc';

/*Ver numero_pedido, itens e cliente que o fez*/
SELECT 
    p.numero_pedido,
    l.titulo,
    ic.quantidade as 'Quantidade comprada',
    ic.preco,
    u.nome as 'Nome do cliente'
FROM pedido p
INNER JOIN pedido_item pi ON pi.pedido_id = p.numero_pedido
INNER JOIN item_carrinho ic ON ic.id = pi.item_id
INNER JOIN livro l ON l.id = ic.livro_id
INNER JOIN cliente c ON c.id = p.cliente_id
INNER JOIN usuario u ON u.id = c.id_usuario
ORDER BY p.data_de_pedido DESC;


select titulo, quantidade as 'Estoque', qtd_vendidos as 'Exemplares vendidos' from livro;


SELECT ic.id, preco, carrinho_id, cl.id
FROM item_carrinho ic
INNER JOIN carrinho c ON c.id = ic.carrinho_id
INNER JOIN cliente cl ON cl.id = c.cliente_id;
WHERE cl.id != 1;