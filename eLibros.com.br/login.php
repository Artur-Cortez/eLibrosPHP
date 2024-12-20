<?php
session_start();
include('config.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $senha = $_POST['senha'];

    // Verificar se o usuário existe
    $sql = "SELECT * FROM usuario WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if ($user && password_verify($senha, $user['senha'])) {
        // Armazenar informações básicas do usuário na sessão
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_name'] = $user['nome'];
        $_SESSION['user_email'] = $user['email'];

        // Verificar se o usuário é um cliente
        $sql_cliente = "SELECT * FROM cliente WHERE id_usuario = ?";
        $stmt_cliente = $conn->prepare($sql_cliente);
        $stmt_cliente->bind_param("i", $user['id']);
        $stmt_cliente->execute();
        $result_cliente = $stmt_cliente->get_result();
        $cliente = $result_cliente->fetch_assoc();

        if ($cliente) {
            $_SESSION['cliente_id'] = $cliente['id'];
            $_SESSION['endereco_id'] = $cliente['endereco_id'];
            header('Location: index.php');
            exit();
        }

        // Verificar se o usuário é um autor
        $sql_autor = "SELECT * FROM autor WHERE id_usuario = ?";
        $stmt_autor = $conn->prepare($sql_autor);
        $stmt_autor->bind_param("i", $user['id']);
        $stmt_autor->execute();
        $result_autor = $stmt_autor->get_result();
        $autor = $result_autor->fetch_assoc();

        if ($autor) {
            $_SESSION['autor_id'] = $autor['id'];
            header('Location: index.php');
            exit();
        }

        // Verificar se o usuário é um administrador
        $sql_admin = "SELECT * FROM administrador WHERE id_usuario = ?";
        $stmt_admin = $conn->prepare($sql_admin);
        $stmt_admin->bind_param("i", $user['id']);
        $stmt_admin->execute();
        $result_admin = $stmt_admin->get_result();
        $admin = $result_admin->fetch_assoc();

        if ($admin) {
            $_SESSION['admin_id'] = $admin['id'];
            header('Location: /admin/index.php');
            exit();
        }

        // Se não for cliente, autor ou administrador, redirecionar para a página de login
        header('Location: login.php');
        exit();
    } else {
        echo 'Usuário ou senha inválidos';
    }
}
?>