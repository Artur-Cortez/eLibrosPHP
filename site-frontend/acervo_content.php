<!-- filepath: /path/to/project/acervo_content.php -->
<?php
include('config.php');
include('utils.php');
// Função para remover caracteres especiais

// Obtendo todos os livros
$sql_livros = "SELECT * FROM livro";
$result_livros = $conn->query($sql_livros);
$livros = [];
while ($row = $result_livros->fetch_assoc()) {
    $livros[] = $row;
}

// Obtendo todos os gêneros literários
$sql_generos = "SELECT * FROM genero_literario";
$result_generos = $conn->query($sql_generos);
$generos = [];
while ($row = $result_generos->fetch_assoc()) {
    $generos[] = $row;
}
if (empty($generos)) {
    die("Nenhum gênero literário encontrado.");
}

// Escolhendo um gênero aleatório que tenha livros associados
$livros_genero = [];
do {
    $genero = $generos[array_rand($generos)];
    $sql_livros_genero = "
        SELECT l.*, GROUP_CONCAT(u.nome SEPARATOR ', ') AS autores
        FROM livro l
        JOIN livro_genero lg ON l.id = lg.livro_id
        JOIN livro_autor la ON l.id = la.livro_id
        JOIN autor a ON la.autor_id = a.id
        JOIN usuario u ON a.id_usuario = u.id
        WHERE lg.genero_id = " . $genero['id'] . "
        GROUP BY l.id";
    $result_livros_genero = $conn->query($sql_livros_genero);
} while ($result_livros_genero->num_rows == 0);

while ($row = $result_livros_genero->fetch_assoc()) {
    $livros_genero[] = $row;
}

$categoria_clean = remove_special_characters($genero['nome']);
$categoria = 'Livros de ' . $genero['nome'];
?>

<main>
    <section id="search">
        <form id="search" action="explorar.html">
            <div id="search">
                <img src="static/images/icons/lupa.svg">
                <input type="search" name="pesquisa" placeholder="Pesquise por nome..." size="52">
            </div>
            <div id="filter">
                <div id="select">
                    <img src="static/images/icons/filter.svg">                          
                    <select>
                        <option value="-1">A-Z</option>
                        <option value="a">A</option>
                        <option value="b">B</option>
                        <option value="c">C</option>
                    </select>
                </div>
                <div id="genero">
                    <label><img src="static/images/icons/Bplus.svg"> Gênero</label>
                </div>
                <div id="data">
                    <label><img src="static/images/icons/Bplus.svg"> Data de inclusão</label>
                </div>
            </div>
        </form>
    </section>

    <section class="livros">
        <h2><?php echo $categoria; ?></h2>

        <div class="swiper <?php echo $categoria_clean; ?>">
            <div class="swiper-wrapper">
                <?php foreach ($livros_genero as $livro) { ?>
                <div class="swiper-slide">              
                    <a href="livro.php?id=<?php echo $livro['id']; ?>">
                    <div>
                        <figure>
                            <?php if ($livro['capa']) { ?>
                            <img src="<?php echo $livro['capa']; ?>">
                            <?php } else { ?>
                            <img src="static/images/placeholder.png" width="100px">
                            <?php } ?>
                        </figure>
                        <div>
                            <h3>
                                <?php echo $livro['titulo']; ?>
                                <?php if ($livro['subtitulo']) { ?>
                                <br>
                                <span><?php echo $livro['subtitulo']; ?></span>
                                <br>
                                <?php } ?>
                            </h3>
                            <p><?php echo $livro['autores']; ?></p>
                            <p><?php echo $livro['preco']; ?></p>
                            <a href="livro.php?id=<?php echo $livro['id']; ?>" class="livro_botao_comprar">Comprar</a>
                        </div>
                    </div>
                    </a>
                </div>
                <?php } ?>   
            </div>
            
            <div class="swiper-pagination" id="swiper-pagination-<?php echo $categoria_clean; ?>"></div>
            <div class="swiper-button-prev" id="swiper-button-prev-<?php echo $categoria_clean; ?>"></div>
            <div class="swiper-button-next" id="swiper-button-next-<?php echo $categoria_clean; ?>"></div>
        </div>
        <p><a href="acervo.php">Ver mais</a></p>
    </section>
</main>