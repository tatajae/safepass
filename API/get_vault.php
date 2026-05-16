<?php

session_start();

include '../config/db.php';

header('Content-Type: application/json');

$user_id = $_SESSION['user_id'];

$stmt = $conn->prepare("
    SELECT
        id,
        encrypted_data,
        iv,
        salt
    FROM vaults
    WHERE user_id = ?
    ORDER BY id DESC
");

$stmt->bind_param("i", $user_id);

$stmt->execute();

$result = $stmt->get_result();

$vaults = [];

while($row = $result->fetch_assoc()){

    $vaults[] = $row;
}

echo json_encode([
    "success" => true,
    "vaults" => $vaults
]);