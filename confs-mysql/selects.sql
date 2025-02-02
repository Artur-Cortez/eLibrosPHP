/*Ver nome de autor*/

select nome as 'Nome do autor' from usuario
inner join autor on autor.id_usuario = usuario.id;


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
where carrinho.session_id = ' 9f5087c7d9b3a6f5245a38a88a155fdc';
