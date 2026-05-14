<?php

session_start();

include "../config/db.php";

$data = json_decode(
  file_get_contents("php://input")
);

$user_id = $_SESSION['user_id'];

$website =
  $data->website;

$username =
  $data->username;

$ciphertext =
  $data->ciphertext;

$iv =
  $data->iv;

$salt =
  $data->salt;

$query = mysqli_query(
  $conn,
  "INSERT INTO vaults(

    user_id,
    website,
    username,
    ciphertext,
    iv,
    salt

  )

  VALUES(

    '$user_id',
    '$website',
    '$username',
    '$ciphertext',
    '$iv',
    '$salt'

  )"
);

if ($query) {

  echo json_encode([
    "success" => true,
    "message" => "Vault berhasil disimpan"
  ]);

} else {

  echo json_encode([
    "success" => false,
    "message" => "Gagal menyimpan vault"
  ]);
}
?>