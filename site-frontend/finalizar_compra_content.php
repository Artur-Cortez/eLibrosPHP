<?php

// Initialize variables
$subtotal = 0;
$total_items = 0;
$desconto = 0;
$frete = 15.00;
$valor_total = 0;

// Calculate cart totals
foreach ($items as $item) {
    $subtotal += $item['preco'] * $item['quantidade'];
    $total_items += $item['quantidade'];
}

// Apply shipping discount
if ($subtotal > 100) {
    $frete = 0;
}

// Handle cupom discount
if (isset($_POST['codigo_cupom'])) {
    $codigo_cupom = $_POST['codigo_cupom'];
    $stmt = $conn->prepare("SELECT * FROM cupom WHERE codigo = ? AND ativo = 1 AND NOW() BETWEEN data_inicio AND data_fim");
    $stmt->bind_param("s", $codigo_cupom);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $cupom = $result->fetch_assoc();
        if ($cupom['tipo_valor'] == '1') {
            $desconto = ($subtotal * $cupom['valor']) / 100;
        } else {
            $desconto = $cupom['valor'];
        }
    }
}

// Calculate total
$valor_total = $subtotal - $desconto + $frete;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    try {
        $conn->begin_transaction();
        
        // Handle address logic here...
        
        // Generate order number
        $numero_pedido = date('Ymd') . str_pad(mt_rand(1, 9999), 4, '0', STR_PAD_LEFT);

        if ($_POST['endereco_tipo'] == 'outro_endereco') {
            // Prepare address data
            $cep = $_POST['cep'] ?? '';
            $estado = $_POST['estado'] ?? '';
            $cidade = $_POST['cidade'] ?? '';
            $bairro = $_POST['bairro'] ?? 'N/A';
            $rua = $_POST['rua'] ?? '';
            $numero = $_POST['numero'] ?? '';
            $complemento = $_POST['complemento'] ?? '';

            // Insert new address
            $stmt = $conn->prepare("INSERT INTO endereco (cep, uf, cidade, bairro, rua, numero, complemento) VALUES (?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("sssssss", 
                $cep,
                $estado,
                $cidade,
                $bairro,
                $rua,
                $numero,
                $complemento
            );
            $stmt->execute();
            $endereco_id = $conn->insert_id;
        } else {
            // Get existing address
            $stmt = $conn->prepare("SELECT endereco_id FROM cliente WHERE id = ?");
            $stmt->bind_param("i", $_SESSION['cliente_id']);
            $stmt->execute();
            $result = $stmt->get_result();
            $row = $result->fetch_assoc();
            $endereco_id = $row['endereco_id'];
        }
        
        // Prepare values
        $cliente_id = $_SESSION['cliente_id'];
        $cupom_id = isset($cupom) ? $cupom['id'] : null;
        $valor_total_formatted = number_format($valor_total, 2, '.', '');
        $desconto_formatted = number_format($desconto, 2, '.', '');
        
        // Fixed SQL query with proper VALUES clause
        $stmt = $conn->prepare("INSERT INTO pedido (
            numero_pedido, cliente_id, endereco_id, 
            data_de_pedido, entrega_estimada, data_de_entrega,
            valor_total, desconto, quantia_itens, cupom_id
        ) VALUES (?, ?, ?, NOW(), DATE_ADD(NOW(), INTERVAL 7 DAY), 
                 DATE_ADD(NOW(), INTERVAL 7 DAY), ?, ?, ?, ?)");
        
        // Bind parameters in correct order
        $stmt->bind_param("siiddii", 
            $numero_pedido,
            $cliente_id,
            $endereco_id,
            $valor_total_formatted,
            $desconto_formatted,
            $total_items,
            $cupom_id
        );
        
        $stmt->execute();

        // Link items to order
        foreach ($items as $item) {
            // probably not being executed
            $stmt = $conn->prepare("INSERT INTO pedido_item (pedido_id, item_id) VALUES (?, ?)");
            $stmt->bind_param("si", $numero_pedido, $item['id']);
            $stmt->execute();

            // This update is working
            $stmt = $conn->prepare("UPDATE livro SET qtd_vendidos = qtd_vendidos + ? WHERE id = ?");
            $stmt->bind_param("ii", $item['quantidade'], $item['livro_id']);
            $stmt->execute();
        }

        // Clear cart
        $stmt = $conn->prepare("UPDATE item_carrinho SET carrinho_id = NULL WHERE carrinho_id = ?");
        $stmt->bind_param("i", $_SESSION['carrinho_id']);
        $stmt->execute();

        $conn->commit();
        $_SESSION['order_success'] = true;
       
        exit();

    } catch (Exception $e) {
        $conn->rollback();
        die("Error processing order: " . $e->getMessage());
    }
}
?>

<main>
    <form method=post enctype="multipart/form-data">
    <section class="compra">
    <h1>Finalizar compra</h1>

    <div>
        <div class="compra">
            <h2>1</h2>
            <div>
                <h3>Endereço de entrega</h3>
                <div style="display: flex; gap: 3em;">
                    <label class="custom-radio">
                        <input type="radio" name="endereco_tipo" value="meu_endereco" checked>
                        <span class="radio-mark"></span>
                        Meu endereço
                    </label>

                    <label class="custom-radio">
                        <input type="radio" name="endereco_tipo" value="outro_endereco">
                        <span class="radio-mark"></span>
                        Outro
                    </label>

                    <div class="outroendereco" style="margin-top: -1em;">
                        <label>
                            CEP:
                            <input type="text"
                                name="cep"
                                class="sem-borda"
                                placeholder="_____-___"
                                pattern="\d{5}-?\d{3}"
                                maxlength="9"
                                style="width: 7em;">
                        </label>
                        <label>
                            Complemento:
                            <input type="text" class="sem-borda" name="complemento" size="40"
                                placeholder="_____________________________">
                        </label><br>
                        <label>
                            Rua:
                            <input type="text" class="sem-borda" name="rua" size="55"
                                placeholder="_______________________________________">
                        </label>
                        <label>
                            Número:
                            <input type="number" class="sem-borda" name="numero" style="width: 3em;" placeholder="____">
                        </label><br>
                        <label>
                            Estado:
                            <select name="estado">
                                <option value="-1"></option>
                                <option value="RN">RN</option>
                            </select>
                        </label>
                        <label>
                            Cidade:
                            <input type="text" class="sem-borda" name="cidade" size="50"
                                placeholder="____________________________________">
                        </label>
                    </div>


                </div>
            </div>
        </div>

        <div class="compra">
            <h2>2</h2>
            <div>
                <h3>Método de pagamento</h3>
                <div style="display: flex; gap: 5em;" id="pagamento">
                    <button type="button">Crédito<img src="static/images/icons/credito.svg" width="20"></button>
                    <button type="button">Débito<img src="static/images/icons/debito.svg" width="20"></button>
                    <button type="button">Boleto<img src="static/images/icons/boleto.svg" width="20"></button>
                    <button type="button">PIX<img src="static/images/icons/pix.svg" width="20"></button>
                </div>
            </div>
        </div>

        <div class="compra">
            <h2>3</h2>
            <div>
                <h3>Ofertas</h3>
                <div id="cupom-section">
                    <input type="text" name="codigo_cupom" placeholder="Insira o código do cupom">
                    <button type="button" id="aplicar-cupom">Inserir cupom</button>

                    <div id="cupom-aplicado" style="display: none;">
                        <button class="cupom-tag" type="button">
                            <span id="codigo-cupom"></span>
                            <img src="static/images/icons/x.svg" width="20" class="remove-cupom">
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div class="compra">
            <h2>4</h2>
            <div>
                <h3>Itens e envio</h3>
                <div class="itens">
                    <div>
                        <figure>
                            <?php foreach ($items as $item): ?>
                                <img src="<?php echo $item['capa']; ?>" alt="<?php echo $item['titulo']; ?>">
                            <?php endforeach; ?>
                        </figure>

                        <div>
                            <p>
                                <span class="moeda-cart-p">R$</span>
                                <b><span class="preco-maior-cart-p"><?php 
                                    $subtotal = 0;
                                    foreach ($items as $item) {
                                        $subtotal += $item['preco'] * $item['quantidade'];
                                    }
                                    echo number_format($subtotal, 2, ',', '.');
                                ?></span></b>
                            </p>
                            <p><?php echo $total_items; ?> itens no pedido</p>
                        </div>
                    </div>
                    <p>Ao finalizar o pedido a entrega será estimada para sexta-feira</p>
                </div>
            </div>
        </div>

        <div id="final">
            <div id="total">
                <span class="valores">
                    <p>Subtotal</p>
                    <p>R$ <?php echo number_format($subtotal, 2, ',', '.'); ?></p>
                </span>

                <span class="valores">
                    <p>Desconto</p>
                    <?php if (!isset($desconto) || $desconto == 0): ?>
                        <p>---</p>
                    <?php else: ?>
                        <p>- R$ <?php echo number_format($desconto, 2, ',', '.'); ?></p>
                    <?php endif; ?>
                </span>

                <span class="valores">
                    <p>Frete</p>
                    <p>R$ <?php echo number_format($frete ?? 0, 2, ',', '.'); ?></p>
                </span>

                <span class="valores">
                    <p>Valor Total</p>
                    <p>R$ <?php 
                        $valor_total = $subtotal - ($desconto ?? 0) + ($frete ?? 0);
                        echo number_format($valor_total, 2, ',', '.'); 
                    ?></p>
                </span>
            </div>
            <button type="submit" id="finalizar">Finalizar pedido</button>
        </div>

    </div>

    </section>
    </form>
</main>