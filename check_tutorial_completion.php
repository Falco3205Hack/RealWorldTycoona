<?php
session_start();
require 'db_connection.php';

$tutorial_completed = false;

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];

    $sql = "SELECT tutorial_completed FROM users WHERE uid = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $user_id);
    $stmt->execute();
    $stmt->bind_result($tutorial_completed);
    $stmt->fetch();
    $stmt->close();
}

$conn->close();
?>
