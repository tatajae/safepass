<?php

include '../config/session.php';
include '../config/db.php';

header('Content-Type: application/json');

$data = json_decode(file_get_contents("php://input"), true);

$user_id = $_SESSION['user_id'];

$old = $data['old_password'];
$new = $data['new_password'];

/* ambil user */
$stmt = $conn->prepare("SELECT password_hash FROM users WHERE id=?");
$stmt->bind_param("i", $user_id);
$stmt->execute();

$user = $stmt->get_result()->fetch_assoc();

/* verifikasi password lama */
if(!password_verify($old, $user['password_hash'])){

    echo json_encode([
        "success" => false,
        "message" => "Password lama salah"
    ]);
    exit;
}

/* hash password baru */
$newHash = password_hash($new, PASSWORD_BCRYPT);

$stmt = $conn->prepare(
    "UPDATE users SET password_hash=? WHERE id=?"
);

$stmt->bind_param("si", $newHash, $user_id);

$stmt->execute();

echo json_encode([
    "success" => true,
    "message" => "Password berhasil diubah"
]);