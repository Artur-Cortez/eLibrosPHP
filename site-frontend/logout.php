<?php
include('config.php');

// Store the session_id for cart
$old_session_id = $_SESSION['session_id'];

// Clear all session data
session_unset();
session_destroy();

// Start new session
session_start();

// Generate new session_id for anonymous cart
$_SESSION['session_id'] = session_id();

// Update cart session_id
$stmt = $conn->prepare("UPDATE carrinho SET session_id = ?, cliente_id = NULL WHERE session_id = ?");
$stmt->bind_param("ss", $_SESSION['session_id'], $old_session_id);
$stmt->execute();

// Redirect to index page
header("Location: index.php");
exit();
?>