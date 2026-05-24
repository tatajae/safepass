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

$oldAuthVerifier =
$data['oldAuthVerifier'];

$newAuthVerifier =
$data['newAuthVerifier'];


/* GET USER */

$stmt = $conn->prepare("
SELECT auth_verifier
FROM users
WHERE id=?
");

$stmt->bind_param(
"i",
$user_id
);

$stmt->execute();

$user =
$stmt->get_result()->fetch_assoc();


/* VERIFY */

if(

!hash_equals(

$user['auth_verifier'],
$oldAuthVerifier

)

){

echo json_encode([

"success"=>false,
"message"=>"Password lama salah"

]);

exit;
}


/* UPDATE */

$update = $conn->prepare("
UPDATE users
SET auth_verifier=?
WHERE id=?
");

$update->bind_param(

"si",

$newAuthVerifier,
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
"message"=>"Gagal update password"

]);

}
?>