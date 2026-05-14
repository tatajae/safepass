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

$data = json_decode(
    file_get_contents("php://input"),
    true
);

$id = $data['id'];

$service = $data['service'];

$encryptedData = $data['encrypted_data'];

$iv = $data['iv'];

$userId = $_SESSION['user_id'];

/* UPDATE ONLY OWN VAULT */

$stmt = $conn->prepare(
    "UPDATE vaults
     SET service = ?,
         encrypted_data = ?,
         iv = ?
     WHERE id = ?
     AND user_id = ?"
);

$stmt->bind_param(
    "sssii",
    $service,
    $encryptedData,
    $iv,
    $id,
    $userId
);

if($stmt->execute()){

    echo json_encode([
        "success" => true,
        "message" => "Vault berhasil diupdate"
    ]);

}else{

    echo json_encode([
        "success" => false,
        "message" => "Gagal update vault"
    ]);
}