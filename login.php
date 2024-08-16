<?php
session_start();
require 'db_connection.php';

$email = $_POST['email'];
$password = $_POST['password'];

// Verifica se l'utente esiste e la password è corretta
$sql = "SELECT * FROM users WHERE email = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 1) {
    $user = $result->fetch_assoc();
    if (password_verify($password, $user['password_hash'])) {
        // Login riuscito
        $_SESSION['user_id'] = $user['user_id'];
        echo json_encode(['success' => true]);
    } else {
        // Password errata
        echo json_encode(['success' => false, 'error' => 'Invalid password.']);
    }
} else {
    // Utente non trovato
    echo json_encode(['success' => false, 'error' => 'User not found.']);
}

$stmt->close();
$conn->close();
?>
