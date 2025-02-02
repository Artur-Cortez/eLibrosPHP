<?php
include('config.php');
?>

<main>
 
    <section class="meucarrinho">
        <?php if (empty($items)) { ?>
            <p id="carrinhovazio">Seu carrinho está vazio.</p>
        <?php } else { ?>
        <h2>Meu Carrinho</h2>
        <input type="checkbox" id="selectAll" class="custom-checkbox">
        <label for="myCheckbox">
            <input type="checkbox" id="myCheckbox" class="custom-checkbox">
            <span class="checkbox-dot"></span>
            Selecionar tudo
        </label>
        <ul>
            <?php foreach ($items as $item) { ?>
            <li>
                <label for="myCheckbox1">
                    <input type="checkbox" id="myCheckbox1" class="custom-checkbox">
                    <span class="checkbox-dot"></span>
                </label>
                <figure>
                    <img src="<?php echo $item['capa']; ?>" alt="<?php echo $item['titulo']; ?>">
                </figure>
                <div>
                    <h3><a href="livro.php?id=<?php echo $item['livro_id']; ?>"><?php echo $item['titulo']; ?></a></h3>
                    <p>
                        <span class="moeda-cart">R$</span>
                        <b><span class="preco-maior-cart"><?php echo number_format($item['preco'], 2, ',', '.'); ?></span></b>
                    </p>
                    <div>
                        <p>Qnt:</p>
                        <div class="quantity-input">
                            <button type="button" class="quantity-btn minus" data-action="remover">-</button>
                            <input type="number" class="input_quantia_produtos" name="quantity" id="quantity<?php echo $item['id']; ?>" data-id="<?php echo $item['id']; ?>" value="<?php echo $item['quantidade']; ?>" min="1" max="99">
                            <button type="button" class="quantity-btn plus" data-action="adicionar">+</button>
                        </div>
                    </div>
                </div>
                <button data-id="<?php echo $item['id']; ?>" data-action="deletar" class="botaoRemoverDoCarrinho">
                    <figure class="lixeira_produto">
                        <img src="static/images/icons/lixeira.svg" alt="Remover item">
                    </figure>
                </button>
            </li>
            <?php } ?>
        </ul>
        <div class="botoes">
            <button><a href="acervo.php">Continuar comprando</a></button>
            <button><a href="finalizar_compra.php">Finalizar compra</a></button>
        </div>
        <?php } ?>
    </section>
</main>
<script>
    const cartUpdateUrl = "adicionar_carrinho.php";
</script>