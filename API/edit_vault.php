<?php

include '../config/session.php';
include '../config/db.php';

header('Content-Type: application/json');

$data = json_decode(file_get_contents("php://input"), true);

$id = $data['id'];
$website = $data['website'];
$username = $data['username'];
$password = $data['password'];

if(!$id || !$website || !$username || !$password){
    echo json_encode([
        "success" => false,
        "message" => "Data tidak lengkap"
    ]);
    exit;
}

/* UPDATE DATA */
$stmt = $conn->prepare("
    UPDATE vaults
    SET website=?, username=?, ciphertext=?
    WHERE id=?
");

$stmt->bind_param(
    "sssi",
    $website,
    $username,
    $password,
    $id
);

if($stmt->execute()){

    echo json_encode([
        "success" => true,
        "message" => "Vault berhasil diupdate"
    ]);

} else {

    echo json_encode([
        "success" => false,
        "message" => "Gagal update vault"
    ]);
}