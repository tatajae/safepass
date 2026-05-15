<?php

include '../config/db.php';

header('Content-Type: application/json');

$data = json_decode(file_get_contents("php://input"), true);

if(!$data){
    echo json_encode([
        "success" => false,
        "message" => "Invalid JSON"
    ]);
    exit;
}

$name = trim($data['name'] ?? '');
$email = trim($data['email'] ?? '');
$password = $data['password'] ?? '';

if($name == '' || $email == '' || $password == ''){
    echo json_encode([
        "success" => false,
        "message" => "Semua field wajib diisi"
    ]);
    exit;
}

/* HASH PASSWORD */
$passwordHash = password_hash($password, PASSWORD_BCRYPT);

/* INSERT */
$stmt = $conn->prepare("
    INSERT INTO users(name,email,password_hash)
    VALUES(?,?,?)
");

$stmt->bind_param(
    "sss",
    $name,
    $email,
    $passwordHash
);

if($stmt->execute()){

    echo json_encode([
        "success" => true,
        "message" => "Register berhasil"
    ]);

} else {

    echo json_encode([
        "success" => false,
        "message" => "Email mungkin sudah terdaftar"
    ]);
}