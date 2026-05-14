<?php

include "../config/db.php";

$data = json_decode(
  file_get_contents("php://input")
);

$id =
  $data->id;

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
  "UPDATE vaults SET

    website='$website',
    username='$username',
    ciphertext='$ciphertext',
    iv='$iv',
    salt='$salt'

   WHERE id='$id'"
);

if ($query) {

  echo json_encode([
    "success" => true,
    "message" => "Vault berhasil diupdate"
  ]);

} else {

  echo json_encode([
    "success" => false,
    "message" => "Gagal update vault"
  ]);
}
?>