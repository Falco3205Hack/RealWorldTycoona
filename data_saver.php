<?php
// data_saver.php

require 'db_connection.php';
require 'session_manager.php';

$input = json_decode(file_get_contents('php://input'), true);
$type = isset($input['type']) ? $input['type'] : '';

switch ($type) {
    case 'vehicle_purchase':
        saveVehiclePurchase($input, $conn);
        break;
    case 'contract_creation':
        saveContractCreation($input, $conn);
        break;
    default:
        echo json_encode(["success" => false, "message" => "Invalid data type"]);
}

function saveVehiclePurchase($data, $conn) {
    $sql = "INSERT INTO vehicles (user_id, vehicle_type, vehicle_name, purchase_date) VALUES (?, ?, ?, NOW())";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $_SESSION['user_id'], $data['vehicle_type'], $data['vehicle_name']);

    if ($stmt->execute()) {
        echo json_encode(["success" => true]);
    } else {
        echo json_encode(["success" => false, "message" => "Failed to save vehicle purchase"]);
    }
}

function saveContractCreation($data, $conn) {
    $sql = "INSERT INTO contracts (user_id, contract_type, contract_details, creation_date) VALUES (?, ?, ?, NOW())";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $_SESSION['user_id'], $data['contract_type'], $data['contract_details']);

    if ($stmt->execute()) {
        echo json_encode(["success" => true]);
    } else {
        echo json_encode(["success" => false, "message" => "Failed to save contract"]);
    }
}

$conn->close();
?>
