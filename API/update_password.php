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

$new_auth_verifier =
$data['new_auth_verifier'];

$update = $conn->prepare("
UPDATE users
SET auth_verifier=?
WHERE id=?
");

$update->bind_param(
"si",
$new_auth_verifier,
$user_id
);

if($update->execute()){

echo json_encode([

"success"=>true,
"message"=>"Password berhasil diubah"

]);

}else{

echo json_encode([

"success"=>false,
"message"=>"Gagal update"

]);

}
?>