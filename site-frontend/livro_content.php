<?php
    
    // Calculando preço com desconto
    $preco_com_desconto = null;
    if ($livro['desconto'] > 0) {
        $preco_com_desconto = $livro['preco'] - ($livro['preco'] * $livro['desconto'] / 100);
    }


    // Obtendo informações do cliente
    $cliente = null;
    if (isset($_SESSION['cliente_id'])) {
        $cliente_id = (int)$_SESSION['cliente_id'];
        $sql_cliente = "
            SELECT e.* 
            FROM cliente c
            JOIN endereco e ON c.endereco_id = e.id
            WHERE c.id = ?";
        $stmt = $conn->prepare($sql_cliente);
        $stmt->bind_param("i", $cliente_id);
        $stmt->execute();
        $result_cliente = $stmt->get_result();
        $cliente = $result_cliente->fetch_assoc();
    }

    $sql_autores = " 
            SELECT u.nome 
            FROM livro_autor la
            JOIN autor a ON la.autor_id = a.id
            JOIN usuario u ON a.id_usuario = u.id
            WHERE la.livro_id = ?";
    $stmt = $conn->prepare($sql_autores);
    $stmt->bind_param("i", $livro_id);
    $stmt->execute();
    $result_autores = $stmt->get_result();
    $autores = [];
    while ($autor = $result_autores->fetch_assoc()) {
        $autores[] = $autor['nome'];
    }
?>

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

            <p>
                <img src="static/images/local.png">
                <?php if ($cliente == null) { ?>
                    <a href="#">Adicionar local</a>
                <?php } else { ?>
                    <a href="#">Entregar em <?php echo $cliente['rua'] . ', ' . $cliente['numero'] . ' - ' . $cliente['cidade'] . ', ' . $cliente['estado']; ?></a>
                <?php } ?>
            </p>
            <p>Em estoque <span><?php echo $livro['quantidade']; ?> restante(s)</span></p>
            <div class="quantity-input">
                <button class="quantity-btn minus">-</button>
                <input type="number" id="quantity" value="1" min="1" max="99">
                <button class="quantity-btn plus">+</button>
            </div>
            <div class="botoes">
                <button data-id="<?php echo $livro['id']; ?>" data-action="adicionarAoCarrinho" class="botaoAdicionarAoCarrinho">
                    <img src="static/images/carrinho.png">
                    <p>Adicionar</p>
                </button>
                <button data-id="<?php echo $livro['id']; ?>" data-action="comprarAgora" class="botaoComprarAgora">Comprar Agora</button>

                <button><img src="static/images/caminhao.png">
                    <p>Calcular Frete</p>
                </button>
                </div>
            </div>
        </div>
    </section>
</main>