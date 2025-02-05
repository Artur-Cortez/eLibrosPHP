<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT * FROM usuario WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if ($user && password_verify($password, $user['senha'])) {
        $_SESSION['cliente_id'] = $user['id'];
        $_SESSION['user_foto_de_perfil'] = $user['foto_de_perfil'];

        // Atualizar o cliente_id do carrinho
        $stmt = $conn->prepare("UPDATE carrinho SET cliente_id = ? WHERE session_id = ?");
        $stmt->bind_param("is", $user['id'], $_SESSION['session_id']);
        $stmt->execute();

        // Redirecionar para a página de finalizar compra ou outra página
        $redirect_to = isset($_SESSION['redirect_to']) ? $_SESSION['redirect_to'] : 'index.php';
        unset($_SESSION['redirect_to']);
        header("Location: $redirect_to");
        exit();
    } else {
        echo 'Usuário ou senha inválidos';
    }
}

?>