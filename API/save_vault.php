<?php

include '../config/db.php';
session_start();

header('Content-Type: application/json');

/* AUTH */
if(!isset($_SESSION['user_id'])){
    echo json_encode([
        "success" => false,
        "message" => "Unauthorized"
    ]);
    exit;
}

/* INPUT */
$data = json_decode(file_get_contents("php://input"), true);

if(!$data){
    echo json_encode([
        "success" => false,
        "message" => "Invalid JSON"
    ]);
    exit;
}

/* VALIDATION */
if(
    empty($data['website']) ||
    empty($data['username']) ||
    empty($data['ciphertext']) ||
    empty($data['iv']) ||
    empty($data['salt']) ||
    empty($data['tag'])
){
    echo json_encode([
        "success" => false,
        "message" => "Data tidak lengkap"
    ]);
    exit;
}

$userId = $_SESSION['user_id'];

$website = $data['website'];
$username = $data['username'];
$ciphertext = $data['ciphertext'];
$iv = $data['iv'];
$salt = $data['salt'];
$tag = $data['tag'];

/* INSERT */
$stmt = $conn->prepare("
    INSERT INTO vaults
    (user_id, website, username, ciphertext, iv, salt, tag)
    VALUES (?, ?, ?, ?, ?, ?, ?)
");

$stmt->bind_param(
    "issssss",
    $userId,
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