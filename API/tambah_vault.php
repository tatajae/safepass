<?php

session_start();

header('Content-Type: application/json');

include '../config/session.php';
include '../config/db.php';

/* =========================
   GET JSON
========================= */
$data = json_decode(file_get_contents("php://input"), true);

if(!$data){
    echo json_encode([
        "success" => false,
        "message" => "JSON tidak valid"
    ]);
    exit;
}

/* =========================
   VALIDASI SESSION
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
   VALIDASI INPUT
========================= */
$website = trim($data['website'] ?? '');
$username = trim($data['username'] ?? '');
$password = trim($data['password'] ?? '');

if($website === '' || $username === '' || $password === ''){
    echo json_encode([
        "success" => false,
        "message" => "Semua field wajib diisi"
    ]);
    exit;
}

/* =========================
   ENCRYPTION (PBKDF2 + AES-GCM)
========================= */
$master_key = "SAFEPASS_SECRET_KEY_2026";

$salt = random_bytes(16);

$key = hash_pbkdf2(
    "sha256",
    $master_key,
    $salt,
    100000,
    32,
    true
);

$iv = random_bytes(12);

$tag = "";

/* ENCRYPT */
$ciphertext = openssl_encrypt(
    $password,
    "aes-256-gcm",
    $key,
    OPENSSL_RAW_DATA,
    $iv,
    $tag
);

/* =========================
   CEK ENCRYPT FAILED
========================= */
if($ciphertext === false){
    echo json_encode([
        "success" => false,
        "message" => "Encrypt gagal"
    ]);
    exit;
}

/* =========================
   BASE64 ENCODE
========================= */
$ciphertext = base64_encode($ciphertext);
$iv = base64_encode($iv);
$salt = base64_encode($salt);
$tag = base64_encode($tag);

/* =========================
   INSERT DB
========================= */
$stmt = $conn->prepare("
    INSERT INTO vaults
    (user_id, website, username, ciphertext, iv, salt, tag)
    VALUES (?, ?, ?, ?, ?, ?, ?)
");

$stmt->bind_param(
    "issssss",
    $user_id,
    $website,
    $username,
    $ciphertext,
    $iv,
    $salt,
    $tag
);

if($stmt->execute()){

    echo json_encode([
        "success" => true,
        "message" => "Vault berhasil disimpan"
    ]);

} else {

    echo json_encode([
        "success" => false,
        "message" => "Database error"
    ]);
}