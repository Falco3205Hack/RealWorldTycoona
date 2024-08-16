<?php
session_start();
require 'db_connection.php';

if (!isset($_SESSION['user_id'])) {
    echo json_encode(["success" => false, "message" => "User not authenticated."]);
    exit();
}

// Riceve i dati JSON inviati dal client
$input = json_decode(file_get_contents('php://input'), true);

$business_name = $input['businessName'];
$category = $input['category'];
$city = $input['city'];
$user_id = $_SESSION['user_id'];

// Salva i dati nel database
$sql = "UPDATE users SET business_name = ?, category = ?, city = ?, tutorial_completed = 1 WHERE uid = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ssss", $business_name, $category, $city, $user_id);
if ($stmt->execute()) {
    echo json_encode(["success" => true]);
} else {
    echo json_encode(["success" => false, "message" => "Failed to save tutorial data."]);
}

// Chiudi la connessione
$stmt->close();
$conn->close();
?>
