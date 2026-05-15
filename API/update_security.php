<?php

include '../config/session.php';
include '../config/db.php';

header('Content-Type: application/json');

$data = json_decode(file_get_contents("php://input"), true);

if(!$data){
    echo json_encode([
        "success" => false,
        "message" => "No data received"
    ]);
    exit;
}

$user_id = $_SESSION['user_id'];

$old = trim($data['old_password'] ?? '');
$new = trim($data['new_password'] ?? '');

/* =========================
   VALIDASI INPUT KOSONG
========================= */

if(empty($old) || empty($new)){
    echo json_encode([
        "success" => false,
        "message" => "Semua field harus diisi"
    ]);
    exit;
}

/* ambil user */
$stmt = $conn->prepare("
    SELECT password_hash
    FROM users
    WHERE id=?
");

$stmt->bind_param("i", $user_id);
$stmt->execute();

$user = $stmt->get_result()->fetch_assoc();

/* cek password lama */
if(!password_verify($old, $user['password_hash'])){

    echo json_encode([
        "success" => false,
        "message" => "Password lama salah"
    ]);
    exit;
}

/* update password */
$newHash = password_hash($new, PASSWORD_BCRYPT);

$stmt = $conn->prepare("
    UPDATE users
    SET password_hash=?
    WHERE id=?
");

$stmt->bind_param("si", $newHash, $user_id);
$stmt->execute();

echo json_encode([
    "success" => true,
    "message" => "Password berhasil diubah"
]);