<?php
include('config.php');
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT * FROM usuario WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if ($user && password_verify($password, $user['senha'])) {
        // Get or create cliente record
        $stmt = $conn->prepare("SELECT id FROM cliente WHERE id_usuario = ?");
        $stmt->bind_param("i", $user['id']);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows === 0) {
            // Create new cliente record
            $stmt = $conn->prepare("INSERT INTO cliente (id_usuario) VALUES (?)");
            $stmt->bind_param("i", $user['id']);
            $stmt->execute();
            $cliente_id = $conn->insert_id;
        } else {
            $cliente = $result->fetch_assoc();
            $cliente_id = $cliente['id'];
        }

        $_SESSION['cliente_id'] = $cliente_id;
        $_SESSION['user_foto_de_perfil'] = $user['foto_de_perfil'];

        // Update carrinho with correct cliente_id
        $stmt = $conn->prepare("UPDATE carrinho SET cliente_id = ? WHERE session_id = ?");
        $stmt->bind_param("is", $cliente_id, $_SESSION['session_id']);
        $stmt->execute();

        $redirect_to = isset($_SESSION['redirect_to']) ? $_SESSION['redirect_to'] : 'index.php';
        unset($_SESSION['redirect_to']);
        header("Location: $redirect_to");
        exit();
    } else {
        echo 'Usuário ou senha inválidos';
    }
}
?>