<?php

session_start();

include '../config/db.php';

header('Content-Type: application/json');

$data = json_decode(
    file_get_contents("php://input"),
    true
);

$user_id =
  $_SESSION['user_id'];

$encrypted_data =
  $data['encrypted_data'];

$iv =
  $data['iv'];

$salt =
  $data['salt'];

$stmt = $conn->prepare("
    INSERT INTO vaults(
        user_id,
        encrypted_data,
        iv,
        salt
    )
    VALUES(?,?,?,?)
");

$stmt->bind_param(
    "isss",
    $user_id,
    $encrypted_data,
    $iv,
    $salt
);
if(empty($encrypted_data)){
    echo json_encode([
        "success"=>false,
        "message"=>"Data kosong"
    ]);
    exit;
}elseif($stmt->execute()){

    echo json_encode([
        "success"=>true,
        "message"=>"Vault tersimpan"
    ]);

}else{

    echo json_encode([
        "success"=>false,
        "message"=>"Gagal menyimpan"
    ]);
}