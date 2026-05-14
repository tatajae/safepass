<?php

include '../config/db.php';

session_start();

header('Content-Type: application/json');

/* SESSION VALIDATION */

if(!isset($_SESSION['user_id'])){

    echo json_encode([
        "success" => false,
        "message" => "Unauthorized"
    ]);

    exit;
}

$userId = $_SESSION['user_id'];

/* GET ONLY USER VAULT */

$stmt = $conn->prepare(
    "SELECT * FROM vaults
     WHERE user_id = ?
     ORDER BY created_at DESC"
);

$stmt->bind_param("i", $userId);

$stmt->execute();

$result = $stmt->get_result();

$vaults = [];

while($row = $result->fetch_assoc()){

    $vaults[] = $row;
}

echo json_encode($vaults);