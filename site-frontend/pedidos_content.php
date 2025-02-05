<?php
include('config.php');

// Get all pedidos
$stmt = $conn->prepare("
    SELECT p.*, e.*,
           DATE_FORMAT(p.data_de_pedido, '%d/%m/%Y') as data_formatada,
           DATE_FORMAT(p.entrega_estimada, '%d/%m/%Y') as entrega_formatada
    FROM pedido p 
    LEFT JOIN endereco e ON p.endereco_id = e.id
    WHERE p.cliente_id = ? 
    ORDER BY p.data_de_pedido DESC
");
$stmt->bind_param("i", $_SESSION['cliente_id']);
$stmt->execute();
$result = $stmt->get_result();
$pedidos = $result->fetch_all(MYSQLI_ASSOC);

// Filter pedidos by status
$pedidos_andamento = array_filter($pedidos, function($pedido) {
    return in_array($pedido['status_pedido'], ['PRO', 'CON']);
});

$pedidos_enviados = array_filter($pedidos, function($pedido) {
    return $pedido['status_pedido'] === 'ENV';
});

$pedidos_finalizados = array_filter($pedidos, function($pedido) {
    return $pedido['status_pedido'] === 'ENT';
});

$pedidos_cancelados = array_filter($pedidos, function($pedido) {
    return $pedido['status_pedido'] === 'CAN';
});
?>

<main>
    <section class="pedidos">
        <h2>Meus pedidos</h2>
        
        <!-- Em andamento -->
        <h3>Em andamento</h3>
        <ul>
            <?php if ($pedidos_andamento): ?>
                <?php foreach ($pedidos_andamento as $pedido): ?>
                    <li>
                        <figure class="item">
                            <?php
                            $stmt = $conn->prepare("
                                SELECT l.capa 
                                FROM pedido_item pi 
                                INNER JOIN item_carrinho ic ON ic.id = pi.item_id
                                INNER JOIN livro l ON l.id = ic.livro_id 
                                WHERE pi.pedido_id = ?
                                LIMIT 1
                            ");
                            $stmt->bind_param("s", $pedido['numero_pedido']);
                            $stmt->execute();
                            $capa = $stmt->get_result()->fetch_assoc();
                            ?>
                            <img src="<?php echo $capa['capa']; ?>" alt="Capa do livro">
                        </figure>
                        
                        <div class="numero-pedido">
                            <p>PEDIDO N°<?php echo $pedido['numero_pedido']; ?></p>
                            <p>
                                <span class="moeda-cart">R$</span>
                                <b><span class="preco-maior-cart"><?php echo number_format($pedido['valor_total'], 2, ',', '.'); ?></span></b>
                            </p>
                            <p>Pedido realizado dia <?php echo $pedido['data_formatada']; ?></p>
                            <button class="botao-ver-detalhes" data-pedido-id="<?php echo $pedido['numero_pedido']; ?>">Ver detalhes</button>
                            
                            <div class="detalhes-pedido" id="detalhes-pedido-<?php echo $pedido['numero_pedido']; ?>" style="display: none;">
                                <div>
                                    <p>Itens:</p>
                                    <ul>
                                        <?php
                                        $stmt = $conn->prepare("
                                            SELECT l.titulo, ic.quantidade, ic.preco
                                            FROM pedido_item pi 
                                            INNER JOIN item_carrinho ic ON ic.id = pi.item_id
                                            INNER JOIN livro l ON l.id = ic.livro_id 
                                            WHERE pi.pedido_id = ?
                                        ");
                                        $stmt->bind_param("s", $pedido['numero_pedido']);
                                        $stmt->execute();
                                        $items = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
                                        foreach ($items as $item): ?>
                                            <p><?php echo $item['titulo'] . ' (x' . $item['quantidade'] . ')'; ?></p>
                                        <?php endforeach; ?>
                                    </ul>
                                    <p>Endereço de entrega:</p>
                                    <p><?php echo $pedido['rua'] . ', ' . $pedido['numero']; ?></p>
                                    <p><?php echo $pedido['complemento']; ?></p>
                                    <p><?php echo $pedido['cep'] . ', ' . $pedido['cidade']; ?></p>
                                    <button class="botao-ocultar-detalhes" data-pedido-id="<?php echo $pedido['numero_pedido']; ?>">Ocultar detalhes</button>
                                </div>
                            </div>
                        </div>
                        
                        <div class="status-pedido">
                            <p>Entrega estimada para dia <?php echo $pedido['entrega_formatada']; ?></p>
                            <?php if ($pedido['status_pedido'] === 'CON'): ?>
                                <p>Pedido pronto para sair da distribuidora</p>
                            <?php else: ?>
                                <p>Pedido em processamento</p>
                            <?php endif; ?>
                            
                            <button id="confirmar" class="botao-confirmar-recebimento confirmar" type="button">Cancelar pedido</button>
                            <div id="modal-confirmar-recebimento" class="modal_confirmar">
                                <div class="modal_content">
                                    <h4>Deseja o cancelamento do pedido?</h4>
                                    <div style="display: flex; justify-content: space-between; margin: 0;">
                                        <span class="close">&times;</span>
                                        <form action="cancelar_pedido.php" method="post">
                                            <input type="hidden" name="numero_pedido" value="<?php echo $pedido['numero_pedido']; ?>">
                                            <button id="confirmar_recebimento">Confirmar</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>
                <?php endforeach; ?>
            <?php else: ?>
                <div>
                    <p>Nenhum pedido em andamento</p>
                </div>
            <?php endif; ?>
        </ul>
        <h3>Enviados</h3>
        <ul>
            <?php if ($pedidos_enviados): ?>
                <?php foreach ($pedidos_enviados as $pedido): ?>
                    <li>
                        <figure class="item">
                            <?php
                            $stmt = $conn->prepare("
                                SELECT l.capa 
                                FROM pedido_item pi 
                                INNER JOIN item_carrinho ic ON ic.id = pi.item_id
                                INNER JOIN livro l ON l.id = ic.livro_id 
                                WHERE pi.pedido_id = ?
                                LIMIT 1
                            ");
                            $stmt->bind_param("s", $pedido['numero_pedido']);
                            $stmt->execute();
                            $capa = $stmt->get_result()->fetch_assoc();
                            ?>
                            <img src="<?php echo $capa['capa']; ?>" alt="Capa do livro">
                        </figure>
                        
                        <div class="numero-pedido">
                            <p>PEDIDO N°<?php echo $pedido['numero_pedido']; ?></p>
                            <p>
                                <span class="moeda-cart">R$</span>
                                <b><span class="preco-maior-cart"><?php echo number_format($pedido['valor_total'], 2, ',', '.'); ?></span></b>
                            </p>
                            <p>Pedido realizado dia <?php echo $pedido['data_formatada']; ?></p>
                            <button class="botao-ver-detalhes" data-pedido-id="<?php echo $pedido['numero_pedido']; ?>">Ver detalhes</button>
                            
                            <div class="detalhes-pedido" id="detalhes-pedido-<?php echo $pedido['numero_pedido']; ?>" style="display: none;">
                                <div>
                                    <p>Itens:</p>
                                    <ul>
                                        <?php
                                        $stmt = $conn->prepare("
                                            SELECT l.titulo, ic.quantidade, ic.preco
                                            FROM pedido_item pi 
                                            INNER JOIN item_carrinho ic ON ic.id = pi.item_id
                                            INNER JOIN livro l ON l.id = ic.livro_id 
                                            WHERE pi.pedido_id = ?
                                        ");
                                        $stmt->bind_param("s", $pedido['numero_pedido']);
                                        $stmt->execute();
                                        $items = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
                                        foreach ($items as $item): ?>
                                            <p><?php echo $item['titulo'] . ' (x' . $item['quantidade'] . ')'; ?></p>
                                        <?php endforeach; ?>
                                    </ul>
                                    <p>Endereço de entrega:</p>
                                    <p><?php echo $pedido['rua'] . ', ' . $pedido['numero']; ?></p>
                                    <p><?php echo $pedido['complemento']; ?></p>
                                    <p><?php echo $pedido['cep'] . ', ' . $pedido['cidade']; ?></p>
                                    <button class="botao-ocultar-detalhes" data-pedido-id="<?php echo $pedido['numero_pedido']; ?>">Ocultar detalhes</button>
                                </div>
                            </div>
                        </div>
                        
                        <div class="status-pedido">
                            <p>Entrega estimada para dia <?php echo $pedido['entrega_formatada']; ?></p>
                            <p>Pedido a caminho</p>
                            <button id="confirmar" style="background-color: #FFDB70;" class="botao-confirmar-recebimento confirmar" type="button">Confirmar recebimento</button>
                            <div id="modal-confirmar-recebimento" class="modal_confirmar">
                                <div class="modal_content">
                                    <h4>Deseja confirmar que recebeu o pedido?</h4>
                                    <div style="display: flex; justify-content: space-between; margin: 0;">
                                        <span class="close">&times;</span>
                                        <form action="confirmar_recebimento.php" method="post">
                                            <input type="hidden" name="numero_pedido" value="<?php echo $pedido['numero_pedido']; ?>">
                                            <button id="confirmar_recebimento">Confirmar</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <button>Rastrear pacote</button>
                        </div>
                    </li>
                <?php endforeach; ?>
            <?php else: ?>
                <div>
                    <p>Nenhum pedido enviado</p>
                </div>
            <?php endif; ?>
        </ul>

        <!-- Finalizados -->
        <h3>Finalizados</h3>
        <ul>
            <?php if ($pedidos_finalizados): ?>
                <?php foreach ($pedidos_finalizados as $pedido): ?>
                    <li>
                        <figure class="item">
                            <?php
                            $stmt = $conn->prepare("
                                SELECT l.capa 
                                FROM pedido_item pi 
                                INNER JOIN item_carrinho ic ON ic.id = pi.item_id
                                INNER JOIN livro l ON l.id = ic.livro_id 
                                WHERE pi.pedido_id = ?
                                LIMIT 1
                            ");
                            $stmt->bind_param("s", $pedido['numero_pedido']);
                            $stmt->execute();
                            $capa = $stmt->get_result()->fetch_assoc();
                            ?>
                            <img src="<?php echo $capa['capa']; ?>" alt="Capa do livro">
                        </figure>
                        
                        <div class="numero-pedido">
                            <p>PEDIDO N°<?php echo $pedido['numero_pedido']; ?></p>
                            <p>
                                <span class="moeda-cart">R$</span>
                                <b><span class="preco-maior-cart"><?php echo number_format($pedido['valor_total'], 2, ',', '.'); ?></span></b>
                            </p>
                            <p>Pedido realizado dia <?php echo $pedido['data_formatada']; ?></p>
                            <button class="botao-ver-detalhes" data-pedido-id="<?php echo $pedido['numero_pedido']; ?>">Ver detalhes</button>
                            
                            <div class="detalhes-pedido" id="detalhes-pedido-<?php echo $pedido['numero_pedido']; ?>" style="display: none;">
                                <div>
                                    <p>Itens:</p>
                                    <ul>
                                        <?php
                                        $stmt = $conn->prepare("
                                            SELECT l.titulo, ic.quantidade, ic.preco
                                            FROM pedido_item pi 
                                            INNER JOIN item_carrinho ic ON ic.id = pi.item_id
                                            INNER JOIN livro l ON l.id = ic.livro_id 
                                            WHERE pi.pedido_id = ?
                                        ");
                                        $stmt->bind_param("s", $pedido['numero_pedido']);
                                        $stmt->execute();
                                        $items = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
                                        foreach ($items as $item): ?>
                                            <p><?php echo $item['titulo'] . ' (x' . $item['quantidade'] . ')'; ?></p>
                                        <?php endforeach; ?>
                                    </ul>
                                    <p>Endereço de entrega:</p>
                                    <p><?php echo $pedido['rua'] . ', ' . $pedido['numero']; ?></p>
                                    <p><?php echo $pedido['complemento']; ?></p>
                                    <p><?php echo $pedido['cep'] . ', ' . $pedido['cidade']; ?></p>
                                    <button class="botao-ocultar-detalhes" data-pedido-id="<?php echo $pedido['numero_pedido']; ?>">Ocultar detalhes</button>
                                </div>
                            </div>
                        </div>
                        
                        <div class="status-pedido">
                            <p>Entrega confirmada pelo cliente</p>
                            <p>Pedido entregue</p>
                        </div>
                    </li>
                <?php endforeach; ?>
            <?php else: ?>
                <div>
                    <p>Nenhum pedido finalizado</p>
                </div>
            <?php endif; ?>
        </ul>

        <!-- Similar sections for Enviados, Finalizados, and Cancelados -->
        </section>
</main>