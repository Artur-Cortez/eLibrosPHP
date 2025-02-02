<?php
$servername = "db";
$username = "root";
$password = "mariadb";
$dbname = "mariadb";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (empty($_SESSION['session_id'])) {
    $_SESSION['session_id'] = session_id();
}
?>
