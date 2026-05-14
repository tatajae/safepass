<?php

include "../config/db.php";

$data = json_decode(
  file_get_contents("php://input")
);

$name = $data->name;
$email = $data->email;
$password = $data->password;

$check = mysqli_query(
  $conn,
  "SELECT * FROM users
   WHERE email='$email'"
);

if (mysqli_num_rows($check) > 0) {

  echo json_encode([
    "success" => false,
    "message" => "Email sudah digunakan"
  ]);

  exit;
}

$hash = password_hash(
  $password,
  PASSWORD_BCRYPT
);

$query = mysqli_query(
  $conn,
  "INSERT INTO users(
    name,
    email,
    password_hash
  )
  VALUES(
    '$name',
    '$email',
    '$hash'
  )"
);

if ($query) {

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
?>