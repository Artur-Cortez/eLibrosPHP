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

        $stmt = $conn->prepare("INSERT INTO usuario (nome, email, senha, CPF, telefone, data_de_nascimento, username) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssssss", $name, $email, $hashed_password, $cpf, $telefone, $data_nasc, $username);
        $stmt->execute();

        $user_id = $conn->insert_id;

        $stmt = $conn->prepare("INSERT INTO cliente (id_usuario) VALUES (?)");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();

        $conn->commit();

        echo "Account created successfully.";
        header('Location: login.html');
        exit();
    } catch (Exception $e) {
        $conn->rollback();
        echo "Failed to create account: " . $e->getMessage();
    }

    $conn->close();
}