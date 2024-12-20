<?php
    include('config.php');
    $livro_id = $_GET['id'];
    $sql = "SELECT * FROM livro WHERE id = $livro_id";
    $result = $conn->query($sql);
    $livro = $result->fetch_assoc();

    $preco_com_desconto = null;
    if ($livro['desconto'] > 0) {
        $preco_com_desconto = $livro['preco'] - ($livro['preco'] * $livro['desconto'] / 100);
    }
?>

<!-- falta passar para cá a variável $preco_com_desconto -->
<main>
    <section class="livro">
        <figure>
            <?php if ($livro['capa']) { ?>
                <img src="<?php echo $livro['capa']; ?>" width="100px">
            <?php } else { ?>
                <img src="static/images/placeholder.png" width="100px">
            <?php } ?>
        </figure>
        <div class="livro_info">
            <div class="livro_header">
                <h2><?php echo $livro['titulo']; ?> <span><?php echo $livro['editora']; ?> - <?php echo $livro['ano_de_publicacao']; ?></span></h2>
                <p>Escrito por 
                <?php
                    $sql_autores = "
                        SELECT u.nome 
                        FROM livro_autor la
                        JOIN autor a ON la.autor_id = a.id
                        JOIN usuario u ON a.id_usuario = u.id
                        WHERE la.livro_id = $livro_id";
                    $result_autores = $conn->query($sql_autores);
                    $autores = [];
                    while ($autor = $result_autores->fetch_assoc()) {
                        $autores[] = $autor['nome'];
                    }
                    echo implode(', ', $autores);
                ?>
                </p>
            </div>
            <div class="livro_descricao">
                <p><?php echo $livro['sinopse']; ?></p>
            </div>
        </div>
        <div class="compra">
            <div>
            <p>
                <span class="moeda">R$</span>
                <?php if ($preco_com_desconto != null) { 
                    $preco_parts = explode('.', number_format($preco_com_desconto, 2)); ?>
                    <b><span class="preco-maior"><?php echo $preco_parts[0]; ?></span><span class="preco-menor"><?php echo $preco_parts[1]; ?></span></b>
                <?php } else { 
                    $preco_parts = explode('.', number_format($livro['preco'], 2)); ?>
                    <b><span class="preco-maior"><?php echo $preco_parts[0]; ?></span><span class="preco-menor"><?php echo $preco_parts[1]; ?></span></b>
                <?php } ?>
            </p>
            <?php if ($preco_com_desconto != null) { ?>
                <p>De:<s><?php echo $livro['preco']; ?></s></p>
            <?php } ?>

            <p><span>Entrega GRÁTIS:</span> Chega entre XX - XX de Mês</p>

            <?php
                
                $cliente_id = $_SESSION['cliente_id']; // Supondo que o ID do cliente esteja armazenado na sessão
                $sql_cliente = "
                    SELECT e.* 
                    FROM cliente c
                    JOIN endereco e ON c.endereco_id = e.id
                    WHERE c.id = $cliente_id";
                $result_cliente = $conn->query($sql_cliente);
                $cliente = $result_cliente->fetch_assoc();
            ?>
            <p>
                <img src="static/images/local.png">
                <?php if ($cliente == null) { ?>
                    <a href="#">Adicionar local</a>
                <?php } else { ?>
                    <a href="#">Entregar em <?php echo $cliente['rua'] . ', ' . $cliente['numero'] . ' - ' . $cliente['cidade'] . ', ' . $cliente['estado']; ?></a>
                <?php } ?>
            </p>
            </div>
        </div>