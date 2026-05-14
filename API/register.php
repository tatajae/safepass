<?php

include '../config/db.php';

header('Content-Type: application/json');

$data = json_decode(file_get_contents("php://input"), true);

$name = $data['name'];
$email = $data['email'];
$password = $data['password'];
$salt = $data['salt'];

$passwordHash = password_hash($password, PASSWORD_BCRYPT);

$stmt = $conn->prepare(
    "INSERT INTO users(name,email,password_hash,salt)
     VALUES(?,?,?,?)"
);

$stmt->bind_param(
    "ssss",
    $name,
    $email,
    $passwordHash,
    $salt
);

if($stmt->execute()) {
    echo json_encode([
        "success" => true,
        "message" => "Register berhasil"
    ]);
} else {
    echo json_encode([
        "success" => false,
        "message" => "Register gagal"
    ]);
}
