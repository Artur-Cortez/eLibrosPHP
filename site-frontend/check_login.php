<?php
if (!isset($_SESSION['cliente_id']) && basename($_SERVER['PHP_SELF']) === 'finalizar_compra.php') {
    $_SESSION['redirect_to'] = 'finalizar_compra.php';
    header('Location: login.html');
    exit();
}

if (isset($_SESSION['cliente_id'])) {
    $stmt = $conn->prepare("SELECT e.* FROM endereco e 
                           INNER JOIN cliente c ON c.endereco_id = e.id 
                           WHERE c.id = ?");
    $stmt->bind_param("i", $_SESSION['cliente_id']);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $_SESSION['endereco'] = $result->fetch_assoc();
    }
}

if (isset($_SESSION['order_success']) && $_SESSION['order_success'] === true) {
    unset($_SESSION['order_success']);
    header('Location: pedidos.php');
    exit();
}
?>