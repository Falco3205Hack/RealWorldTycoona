<?php
// backend.php

require 'db_connection.php';

// Ricevi i dati JSON inviati dal client
$input = json_decode(file_get_contents('php://input'), true);
$action = isset($input['action']) ? $input['action'] : '';

switch ($action) {
    case 'login':
        loginUser($input['email'], $input['password'], $conn);
        break;
    case 'register':
        registerUser($input['email'], $input['password'], $conn);
        break;
    case 'save_data':
        saveData($input, $conn);
        break;
    case 'fetch_data':
        fetchData($input, $conn);
        break;
    default:
        echo json_encode(["success" => false, "message" => "Invalid action"]);
}

function loginUser($email, $password, $conn) {
    $sql = "SELECT * FROM users WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['password_hash'])) {
            session_start();
            $_SESSION['user_id'] = $user['uid'];
            echo json_encode(["success" => true, "user_id" => $user['uid']]);
        } else {
            echo json_encode(["success" => false, "message" => "Invalid password"]);
        }
    } else {
        echo json_encode(["success" => false, "message" => "No user found with this email"]);
    }
}

function registerUser($email, $password, $conn) {
    $password_hash = password_hash($password, PASSWORD_BCRYPT);

    $sql = "INSERT INTO users (email, password_hash) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $email, $password_hash);

    if ($stmt->execute()) {
        echo json_encode(["success" => true]);
    } else {
        echo json_encode(["success" => false, "message" => "Registration failed"]);
    }
}

function saveData($data, $conn) {
    // Logica per salvare i dati nel database
    // Dipende dal tipo di dati che stai salvando
}

function fetchData($data, $conn) {
    // Logica per recuperare i dati dal database
    // Dipende dal tipo di dati che stai cercando
}

$conn->close();
?>
