<?php
$title = "eLibros - Pedidos";
$content = "pedidos_content.php";
include('_base.php');
?>

<!-- filepath: /path/to/project/pedidos_content.php -->
<?php
include('config.php');
session_start();
$user_id = $_SESSION['user_id'];; // Replace with actual user ID from session
$sql = "SELECT * FROM pedido WHERE cliente_id = $user_id";
$result = $conn->query($sql);
$pedidos = $result->fetch_all(MYSQLI_ASSOC);
?>
<main>
    <section class="pedidos">
        <h2>Meus pedidos</h2>
        <h3>Em andamento</h3>
        <ul>
            <?php
            $pedidos_andamento = array_filter($pedidos, function($pedido) {
                return $pedido['status'] == 'AND';
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
                    echo '<p>Pedido realizado dia ' . $pedido['data_de_pedido'] . '</p>';
                    echo '</div>';
                    echo '<div>';
                    echo '<p>Entrega estimada para dia ' . $pedido['entrega_estimada'] . '</p>';
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
                return $pedido['status'] == 'ENV';
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
                return $pedido['status'] == 'FIN';
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