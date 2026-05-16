<?php

include '../config/session.php';
include '../config/db.php';

header('Content-Type: application/json');

$data = json_decode(
    file_get_contents("php://input"),
    true
);

$id =
  $data['id'] ?? '';

$encrypted_data =
  $data['encrypted_data'] ?? '';

$iv =
  $data['iv'] ?? '';

$salt =
  $data['salt'] ?? '';

if(
    !$id ||
    !$encrypted_data ||
    !$iv ||
    !$salt
){

    echo json_encode([
        "success" => false,
        "message" => "Data tidak lengkap"
    ]);

    exit;
}

/* UPDATE ENCRYPTED VAULT */
$stmt = $conn->prepare("
    UPDATE vaults
    SET
        encrypted_data=?,
        iv=?,
        salt=?
    WHERE id=?
");

$stmt->bind_param(
    "sssi",
    $encrypted_data,
    $iv,
    $salt,
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