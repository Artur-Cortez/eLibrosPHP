<?php
include 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $cpf = $_POST['cpf'];
    $telefone = $_POST['telefone'];
    $data_nasc = $_POST['data_nasc'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    if ($password !== $confirm_password) {
        die("Passwords do not match.");
    }

    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    try {
        $conn->begin_transaction();

        // 1. Create usuario record
        $stmt = $conn->prepare("INSERT INTO usuario (nome, email, senha, CPF, telefone, data_de_nascimento, username) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssssss", $name, $email, $hashed_password, $cpf, $telefone, $data_nasc, $username);
        $stmt->execute();
        $user_id = $conn->insert_id;

        // 2. Create cliente record
        $stmt = $conn->prepare("INSERT INTO cliente (id_usuario) VALUES (?)");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $cliente_id = $conn->insert_id;

        // 3. Update carrinho with cliente_id
        if (isset($_SESSION['session_id'])) {
            $stmt = $conn->prepare("UPDATE carrinho SET cliente_id = ? WHERE session_id = ?");
            $stmt->bind_param("is", $cliente_id, $_SESSION['session_id']);
            $stmt->execute();
        }

        $_SESSION['cliente_id'] = $cliente_id;

        $conn->commit();

        // 4. Handle redirection
        $redirect_to = isset($_SESSION['redirect_to']) ? $_SESSION['redirect_to'] : 'index.php';
        unset($_SESSION['redirect_to']);
        header("Location: $redirect_to");
        exit();

    } catch (Exception $e) {
        $conn->rollback();
        die("Failed to create account: " . $e->getMessage());
    }

    $conn->close();
}
?>