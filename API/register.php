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

$authVerifier = $data['authVerifier'] ?? '';
$salt = $data['salt'] ?? '';

if(
    $name == '' ||
    $email == '' ||
    $authVerifier == '' ||
    $salt == ''
){

    echo json_encode([
        "success" => false,
        "message" => "Semua field wajib diisi"
    ]);

    exit;
}

/* INSERT */
$stmt = $conn->prepare("
    INSERT INTO users(
        name,
        email,
        auth_verifier,
        salt
    )
    VALUES(?,?,?,?)
");

$stmt->bind_param(
    "ssss",
    $name,
    $email,
    $authVerifier,
    $salt
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