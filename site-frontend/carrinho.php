<?php
$title = "eLibros - Carrinho";
$content = "carrinho_content.php";
include('_base.php');
?>

<!-- filepath: /path/to/project/carrinho_content.php -->
<?php
include('config.php');
session_start();

$items = [];

if (isset($_SESSION['user_id'])) {
    // Usuário autenticado
    $user_id = $_SESSION['user_id'];
    $sql_cliente = "SELECT id FROM cliente WHERE user_id = $user_id";
    $result_cliente = $conn->query($sql_cliente);
    $cliente = $result_cliente->fetch_assoc();
    
    if ($cliente) {
        $cliente_id = $cliente['id'];
        $sql_carrinho = "SELECT * FROM carrinho WHERE cliente_id = $cliente_id";
        $result_carrinho = $conn->query($sql_carrinho);
        $carrinho = $result_carrinho->fetch_assoc();
    }
} else {
    // Usuário não autenticado
    $session_id = session_id();
    $sql_carrinho = "SELECT * FROM carrinho WHERE session_id = '$session_id'";
    $result_carrinho = $conn->query($sql_carrinho);
    $carrinho = $result_carrinho->fetch_assoc();
}

if (isset($carrinho)) {
    $carrinho_id = $carrinho['id'];
    $sql_items = "
        SELECT ic.*, l.titulo, l.capa, l.preco
        FROM item_carrinho ic
        JOIN livro l ON ic.livro_id = l.id
        WHERE ic.carrinho_id = $carrinho_id";
    $result_items = $conn->query($sql_items);
    
    while ($row = $result_items->fetch_assoc()) {
        $items[] = $row;
    }
}
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
    const cartUpdateUrl = "atualizar_carrinho.php";
</script>