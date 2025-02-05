<?php
include('config.php');
$stmt = $conn->prepare("
    SELECT p.*, 
           DATE_FORMAT(p.data_de_pedido, '%d/%m/%Y') as data_formatada,
           DATE_FORMAT(p.entrega_estimada, '%d/%m/%Y') as entrega_formatada
    FROM pedido p 
    WHERE p.cliente_id = ? 
    ORDER BY p.data_de_pedido DESC
");
$stmt->bind_param("i", $_SESSION['cliente_id']);
$stmt->execute();
$result = $stmt->get_result();
$pedidos = $result->fetch_all(MYSQLI_ASSOC);

// Group pedidos by status
$pedidos_andamento = array_filter($pedidos, function($pedido) {
    return in_array($pedido['status_pedido'], ['PRO', 'CON']);
});

$pedidos_enviados = array_filter($pedidos, function($pedido) {
    return $pedido['status_pedido'] === 'ENV';
});

$pedidos_finalizados = array_filter($pedidos, function($pedido) {
    return $pedido['status_pedido'] === 'ENT';
});
?>
<main>
    <section class="pedidos">
        <h2>Meus pedidos</h2>
        <h3>Em andamento</h3>
        <ul>
            <?php
            $pedidos_andamento = array_filter($pedidos, function($pedido) {
                return $pedido['status_pedido'] == 'AND';
            });
            if ($pedidos_andamento) {
                foreach ($pedidos_andamento as $pedido) {
                    echo '<li>';
                    echo '<div>';
                    $sql = "SELECT * FROM pedido_item WHERE pedido_id = " . $pedido['id'];
                    $result = $conn->query($sql);
                    $items = $result->fetch_all(MYSQLI_ASSOC);
                    foreach ($items as $item) {
                        $sql = "SELECT * FROM livro WHERE id = " . $item['livro_id'];
                        $result = $conn->query($sql);
                        $livro = $result->fetch_assoc();
                        echo '<div class="item">';
                        echo '<img src="' . $livro['capa'] . '" alt="Capa do livro">';
                        echo '</div>';
                    }
                    echo '<p>PEDIDO N°' . $pedido['numero_pedido'] . '</p>';
                    echo '<p><span class="moeda-cart">R$</span><b><span class="preco-maior-cart">' . $pedido['valor_total'] . '</b></p>';
                    echo '<p>Pedido realizado dia ' . $pedido['data_formatada'] . '</p>';
                    echo '</div>';
                    echo '<div>';
                    echo '<p>Entrega estimada para dia ' . $pedido['entrega_formatada'] . '</p>';
                    if ($pedido['confirmado']) {
                        echo '<p>Pedido pronto para sair da distribuidora</p>';
                    }
                    echo '<form action="cancelar_pedido.php" method="post">';
                    echo '<input type="hidden" name="numero_pedido" value="' . $pedido['numero_pedido'] . '">';
                    echo '<button type="submit">Cancelar pedido</button>';
                    echo '</form>';
                    echo '<button>Ver detalhes</button>';
                    echo '</div>';
                    echo '</li>';
                }
            } else {
                echo '<div><p>Nenhum pedido em andamento</p></div>';
            }
            ?>
        </ul>
        <h3>Enviados</h3>
        <ul>
            <?php
            $pedidos_enviados = array_filter($pedidos, function($pedido) {
                return $pedido['status_pedido'] == 'ENV';
            });
            if ($pedidos_enviados) {
                foreach ($pedidos_enviados as $pedido) {
                    echo '<li>';
                    echo '<div>';
                    echo '<div class="item">';
                    echo '<img src="static/images/placeholder.png" alt="Capa do livro">';
                    echo '</div>';
                    echo '<p>PEDIDO N°' . $pedido['numero_pedido'] . '</p>';
                    echo '<p><span class="moeda-cart">R$</span><b><span class="preco-maior-cart">' . $pedido['valor_total'] . '</b></p>';
                    echo '<p>Pedido realizado dia ' . $pedido['data_de_pedido'] . '</p>';
                    echo '</div>';
                    echo '<div>';
                    echo '<p>Entrega estimada para dia ' . $pedido['entrega_estimada'] . '</p>';
                    echo '<p>Pedido a caminho</p>';
                    echo '<form action="confirmar_recebimento.php" method="post">';
                    echo '<input type="hidden" name="numero_pedido" value="' . $pedido['numero_pedido'] . '">';
                    echo '<button type="submit">Confirmar recebimento</button>';
                    echo '</form>';
                    echo '<button>Rastrear pacote</button>';
                    echo '<button>Ver detalhes</button>';
                    echo '</div>';
                    echo '</li>';
                }
            } else {
                echo '<div><p>Nenhum pedido enviado</p></div>';
            }
            ?>
        </ul>
        <h3>Finalizados</h3>
        <ul>
            <?php
            $pedidos_finalizados = array_filter($pedidos, function($pedido) {
                return $pedido['status_pedido'] == 'FIN';
            });
            if ($pedidos_finalizados) {
                foreach ($pedidos_finalizados as $pedido) {
                    echo '<li>';
                    echo '<div>';
                    echo '<div class="item">';
                    echo '<img src="static/images/placeholder.png" alt="Capa do livro">';
                    echo '</div>';
                    echo '<p>PEDIDO N°' . $pedido['numero_pedido'] . '</p>';
                    echo '<p><span class="moeda-cart">R$</span><b><span class="preco-maior-cart">' . $pedido['valor_total'] . '</b></p>';
                    echo '<p>Pedido realizado dia ' . $pedido['data_de_pedido'] . '</p>';
                    echo '</div>';
                    echo '<div>';
                    echo '<p>Pedido entregue</p>';
                    echo '<button>Ver detalhes</button>';
                    echo '</div>';
                    echo '</li>';
                }
            } else {
                echo '<div><p>Nenhum pedido finalizado</p></div>';
            }
            ?>
        </ul>
    </section>
</main>