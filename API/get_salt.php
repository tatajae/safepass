<?php

include '../config/db.php';

header('Content-Type: application/json');

$email = $_GET['email'] ?? '';

$stmt = $conn->prepare("
    SELECT salt
    FROM users
    WHERE email = ?
");

$stmt->bind_param("s", $email);

$stmt->execute();

$result = $stmt->get_result();

$user = $result->fetch_assoc();

if($user){

    echo json_encode([
        "success" => true,
        "salt" => $user['salt']
    ]);

} else {

    echo json_encode([
        "success" => false
    ]);
}
?>