<?php

session_start();

include "../config/db.php";

$data = json_decode(
  file_get_contents("php://input")
);

$email = $data->email;

$password = $data->password;

$query = mysqli_query(
  $conn,
  "SELECT * FROM users
   WHERE email='$email'"
);

$user = mysqli_fetch_assoc($query);

if ($user) {

  if (

    password_verify(
      $password,
      $user['password_hash']
    )

  ) {

    $_SESSION['user_id'] =
      $user['id'];

    $_SESSION['name'] =
      $user['name'];

    /* UPDATE LAST LOGIN */

    mysqli_query(

      $conn,

      "UPDATE users SET

      last_login = NOW()

      WHERE id='".$user['id']."'"
    );

    /* INSERT LOG */

    mysqli_query(

      $conn,

      "INSERT INTO logs(

        user_id,
        activity

      ) VALUES (

        '".$user['id']."',

        'Login berhasil'

      )"
    );

    echo json_encode([

      "success" => true,

      "message" => "Login berhasil"

    ]);

  } else {

    echo json_encode([

      "success" => false,

      "message" => "Password salah"

    ]);
  }

} else {

  echo json_encode([

    "success" => false,

    "message" => "Email tidak ditemukan"

  ]);
}
?>