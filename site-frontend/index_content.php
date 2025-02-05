<?php
include('config.php');
?>

<section class="banner">
    <p>“Há sonhos que devem permanecer nas gavetas, nos cofres, trancados até o nosso fim. E por isso passíveis de serem sonhados a vida inteira.” - Hilda Hilst</p>
</section>
<section class="sobre">
    <figure>
        <img src="static/images/marca.svg">
    </figure>
    <div class="wrap">
        <h2>Conheça o eLibros</h2>
        <p>Livraria digital brasileira onde você pode encontrar os seus escritores nacionais favoritos, ou até ir atrás de descobrir novos!</p>
        <div>
            <img src="static/images/icons/missao.svg">
            <h3>Missão</h3>
            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit.</p>
        </div>
        <div>
            <img src="static/images/icons/visao.svg">
            <h3>Visão</h3>
            <p>Placeat omnis modi expedita, quis optio harum ullam sint fuga.</p>
        </div>
    </div>
</section>
<section class="info">
    <div>
        <h3>+5Mi acessos</h3>
        <p>Desde 2023, conseguimos juntar mais de 5,000,000 acessos em nossa loja</p>
    </div>
    <div>
        <h3>26 estados</h3>
        <p>Atualmente, somos capazes de entregar suas compras em qualquer estado do país</p>
    </div>
    <div>
        <h3>+10mil livros</h3>
        <p>Nossa coleção conta com mais de 10,000 livros de inúmeros autores diferentes</p>
    </div>
</section>
<section class="contato">
    <h2>Contate-nos</h2>
    <div id="divisor"></div>
    <div>
        <div>
            <figure><img src="static/images/icons/email.svg"></figure>
            <p>elibros@entregadores.com</p>
        </div>
        <div>
            <figure><img src="static/images/icons/fone.svg"></figure>
            <p>Disque (84) 4005-9832</p>
        </div>
    </div>
</section>
<section class="livros">
    <h2>Indicações eLibros</h2>
    <div class="swiper Indicacoes-Elibros">
        <div class="swiper-wrapper">
            <?php
            include('config.php');
            $sql = "
                SELECT l.*, GROUP_CONCAT(u.nome SEPARATOR ', ') AS autores
                FROM livro l
                JOIN livro_autor la ON l.id = la.livro_id
                JOIN autor a ON la.autor_id = a.id
                JOIN usuario u ON a.id_usuario = u.id
                GROUP BY l.id";
            $result = $conn->query($sql);
            while($row = $result->fetch_assoc()) {
                echo '<div class="swiper-slide">';
                echo '<a href="livro.php?id=' . $row['id'] . '">';
                echo '<div>';
                echo '<figure>';
                if ($row['capa']) {
                    echo '<img src="' . $row['capa'] . '">';
                } else {
                    echo '<img src="static/images/placeholder.png" width="100px">';
                }
                echo '</figure>';
                echo '<div>';
                echo '<h3>' . $row['titulo'] . '</h3>';
                echo '<p>' . $row['autores'] . '</p>';
                echo '<p>' . $row['preco'] . '</p>';
                echo '<a href="livro.php?id=' . $row['id'] . '" class="livro_botao_comprar">Comprar</a>';
                echo '</div>';
                echo '</div>';
                echo '</a>';
                echo '</div>';
            }
            ?>
        </div>
        <div class="swiper-pagination"></div>
        <div class="swiper-button-prev"></div>
        <div class="swiper-button-next"></div>
    </div>
    <p><a href="acervo.php">Ver mais</a></p>
</section>