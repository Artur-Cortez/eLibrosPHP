<?php
session_start();
include('config.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $senha = $_POST['password'];

    // Verificar se o usuário existe
    $sql = "SELECT * FROM usuario WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if ($user && password_verify($senha, $user['senha'])) {
        // Verificar se o usuário é um administrador
        $sql_admin = "SELECT * FROM administrador WHERE id_usuario = ?";
        $stmt_admin = $conn->prepare($sql_admin);
        $stmt_admin->bind_param("i", $user['id']);
        $stmt_admin->execute();
        $result_admin = $stmt_admin->get_result();
        $admin = $result_admin->fetch_assoc();

        if ($admin) {
            // Armazenar informações básicas do administrador na sessão
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['nome'];
            $_SESSION['user_email'] = $user['email'];
            $_SESSION['admin_id'] = $admin['id'];
            header('Location: index.php');
            exit();
        } else {
            echo 'Acesso negado. Somente administradores podem acessar esta página.';
        }
    } else {
        echo 'Usuário ou senha inválidos';
    }
}
?>