<?php

include '../config/db.php';

session_start();

if(!isset($_SESSION['user_id'])){

    echo json_encode([
        "success" => false,
        "message" => "Unauthorized"
    ]);

    exit;
}
header('Content-Type: application/json');

$data = json_decode(file_get_contents("php://input"), true);

$userId = $_SESSION['user_id'];

$service = $data['service'];
$encryptedData = $data['encrypted_data'];
$iv = $data['iv'];

$stmt = $conn->prepare(
    "INSERT INTO vaults(user_id,service,encrypted_data,iv)
     VALUES(?,?,?,?)"
);

$stmt->bind_param(
    "isss",
    $userId,
    $service,
    $encryptedData,
    $iv
);

if($stmt->execute()) {

    echo json_encode([
        "success" => true
    ]);

} else {

    echo json_encode([
        "success" => false
    ]);
}
