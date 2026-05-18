<?php

include '../config/session.php';
include '../config/db.php';

header('Content-Type: application/json');

/* =========================
   VALIDASI LOGIN
========================= */

if(!isset($_SESSION['user_id'])){

    echo json_encode([
        "success" => false,
        "message" => "Unauthorized"
    ]);

    exit;
}

$user_id = $_SESSION['user_id'];

/* =========================
   GET JSON
========================= */

$data = json_decode(
    file_get_contents("php://input"),
    true
);

/* =========================
   AMBIL DATA
========================= */

$id =
  $data['id'] ?? '';

$encrypted_data =
  $data['encrypted_data'] ?? '';

$iv =
  $data['iv'] ?? '';

$salt =
  $data['salt'] ?? '';

/* =========================
   VALIDASI
========================= */

if(
    empty($id) ||
    empty($encrypted_data) ||
    empty($iv) ||
    empty($salt)
){

    echo json_encode([
        "success" => false,
        "message" => "Data tidak lengkap"
    ]);

    exit;
}

/* =========================
   UPDATE VAULT
========================= */

$stmt = $conn->prepare("
    UPDATE vaults
    SET
        encrypted_data=?,
        iv=?,
        salt=?
    WHERE id=? AND user_id=?
");

$stmt->bind_param(
    "sssii",
    $encrypted_data,
    $iv,
    $salt,
    $id,
    $user_id
);

if($stmt->execute()){

    if($stmt->affected_rows > 0){

        echo json_encode([
            "success" => true,
            "message" => "Vault berhasil diupdate"
        ]);

    } else {

        echo json_encode([
            "success" => false,
            "message" => "Vault tidak ditemukan"
        ]);
    }

} else {

    echo json_encode([
        "success" => false,
        "message" => "Gagal update vault"
    ]);
}