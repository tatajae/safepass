<?php

session_start();

include "../config/db.php";

$user_id = $_SESSION['user_id'];

header('Content-Type: text/csv');

header(
'Content-Disposition: attachment;
filename="vault.csv"'
);

$output = fopen("php://output", "w");

fputcsv(
  $output,
  ['Website','Username']
);

$query = mysqli_query(
  $conn,
  "SELECT * FROM vaults
   WHERE user_id='$user_id'"
);

while($row = mysqli_fetch_assoc($query)){

  fputcsv($output,[

    $row['website'],

    $row['username']

  ]);
}

fclose($output);