<?php

session_start();

include '../config/db.php';

header('Content-Type: application/json');

$data = json_decode(
    file_get_contents("php://input"),
    true
);

/* =========================
   USER
========================= */

$user_id =
    $_SESSION['user_id'];

/* =========================
   PLAINTEXT
========================= */

$website =
    $data['website'] ?? '';

$username =
    $data['username'] ?? '';

$password_strength =
    $data['password_strength'] ?? '';

/* =========================
   ENCRYPTED
========================= */

$encrypted_data =
    $data['encrypted_data'] ?? '';

$iv =
    $data['iv'] ?? '';

$salt =
    $data['salt'] ?? '';

/* =========================
   VALIDATION
========================= */

if(
    empty($website) ||
    empty($username) ||
    empty($encrypted_data)
){

    echo json_encode([

        "success" => false,

        "message" =>
        "Data kosong"

    ]);

    exit;
}

/* =========================
   INSERT
========================= */

$stmt = $conn->prepare("

    INSERT INTO vaults(

        user_id,
        website,
        username,
        password_strength,
        encrypted_data,
        iv,
        salt

    )

    VALUES(?,?,?,?,?,?,?)

");

$stmt->bind_param(

    "issssss",

    $user_id,
    $website,
    $username,
    $password_strength,
    $encrypted_data,
    $iv,
    $salt
);

$execute = $stmt->execute();

/* =========================
   RESPONSE
========================= */

if($execute){

    echo json_encode([

        "success" => true,

        "message" =>
        "Vault tersimpan"

    ]);

}else{

    echo json_encode([

        "success" => false,

        "message" =>
        $stmt->error

    ]);
}

exit;
?>