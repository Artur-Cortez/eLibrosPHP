<?php 
/*
Precisamos saber qual foi o item selecionado (Livro, Autor, Gênero, Categoria, Pedido)
Em seguida, será feita uma listagem dos registros para esses itens;
Para livros, basta recuperar nesse momento o título e o ISBN e exibir concatenado: 'Dom casmurro - 978-85-359-0277-2';
Para pedidos, basta recuperar nesse momento o número do pedido e o nome do cliente e exibir concatenado: 'Pedido 1 - João da Silva';
Para gêneros e categorias, basta recuperar nesse momento campo nome do gênero ou da categoria e exibir;
Para autores e clientes, basta recuperar nesse momento o nome do usuário associado ao autor e exibir;

*/

$tabela = $_GET['tabela'];

$fields = [
    'livro' => 'id, titulo, ISBN',
    'autor' => 'autor.id, usuario.nome',
    'genero_literario' => 'id, nome',
    'categoria' => 'id, nome',
    'pedido' => 'pedido.numero_pedido, usuario.nome',
    'cliente' => 'cliente.id, usuario.nome',
    'cupom' => 'id, codigo, valor',
];

$columns = $fields[$tabela];

if ($tabela == 'autor' || $tabela == 'cliente' ) {
    $join = "INNER JOIN usuario ON usuario.id = {$tabela}.id_usuario";
} else if ($tabela == 'pedido') {
    $join = "INNER JOIN usuario ON usuario.id = pedido.cliente_id";
} else {
    $join = "";
}

$sql = "SELECT $columns FROM $tabela $join";
$result = $conn->query($sql);

?>
<main class="admin">

<section id="cabecalho">
    <h2 id="manter"><?php echo $tabela ?></h1>

    <?php 
    if (in_array($tabela, ['livro', 'autor', 'genero_literario', 'categoria', 'pedido', 'cliente'])) {
        echo "<a href='adicionar.php?tabela=$tabela'>Adicionar $tabela</a>";
    }
    ?>
</section>

<section style="font-family: 'Poppins'; max-width: 68%; margin-top: 3em;">
    <ul class="listagem">
        <!-- para cada linha de registro na tabela selecionada -->
    
            <!-- Dom Casmurro - 978-85-359-0277-2 -->
        <?php 
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {

                    echo "<li>";
                    echo "<span>";
                    echo implode(' - ', $row);
                    echo "</span>";
                    echo "<ul class='crud2'>";

                    if (in_array($tabela, ['livro', 'pedido', 'cliente'])) {
                        echo "<li>";
                        echo "<a id='ver' href='ver.php?tabela=$tabela&id={$row['id']}'>Ver</a>";
                        echo "</li>";
                    }

                    echo "<li>";
                    if (in_array($tabela, ['livro', 'pedido', 'cliente'])) {
                        echo "<a id='editar' href='manter.php?tabela=$tabela&acao=editar&id={$row['id']}'>Editar</a>";
                    } else {
                        echo "<a id='editar' href='manter.php?tabela=$tabela&acao=editar&id={$row['id']}'>Renomear</a>";
                    }
                    echo "</li>";

                    echo "<li>";
                    echo "<a id='excluir' href='manter.php?tabela=$tabela&acao=excluir&id={$row['id']}'>Excluir</a>";
                    echo "</li>";
                  
                    echo "</ul>";
                    echo "</li>";
                }
            }
        ?>
           
    </ul>
</section>
</main>