<?php

include "../config/db.php";

$data = json_decode(
  file_get_contents("php://input")
);

$id = $data->id;

$query = mysqli_query(
  $conn,
  "DELETE FROM vaults
   WHERE id='$id'"
);

if ($query) {

  echo json_encode([
    "success" => true,
    "message" => "Vault berhasil dihapus"
  ]);

} else {

  echo json_encode([
    "success" => false,
    "message" => "Gagal menghapus vault"
  ]);
}
?>