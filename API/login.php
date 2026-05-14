<?php

include '../config/db.php';

header('Content-Type: application/json');

$data = json_decode(file_get_contents("php://input"), true);

$email = $data['email'];
$password = $data['password'];

$stmt = $conn->prepare(
    "SELECT * FROM users WHERE email = ?"
);

$stmt->bind_param("s", $email);
$stmt->execute();

$result = $stmt->get_result();
$user = $result->fetch_assoc();

if($user && password_verify($password, $user['password_hash'])) {

    session_start();

    $_SESSION['user_id'] = $user['id'];

    echo json_encode([
        "success" => true,
        "salt" => $user['salt'],
        "user_id" => $user['id']
    ]);

} else {

    echo json_encode([
        "success" => false,
        "message" => "Email atau password salah"
    ]);
}
