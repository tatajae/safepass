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

$userId = $_SESSION['user_id'];

/* DELETE ONLY OWN VAULT */

$stmt = $conn->prepare(
    "DELETE FROM vaults
     WHERE id = ?
     AND user_id = ?"
);

$stmt->bind_param(
    "ii",
    $id,
    $userId
);

if($stmt->execute()){

    echo json_encode([
        "success" => true,
        "message" => "Vault berhasil dihapus"
    ]);

}else{

    echo json_encode([
        "success" => false,
        "message" => "Gagal menghapus vault"
    ]);
}