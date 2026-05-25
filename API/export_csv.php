<?php

session_start();
include '../config/db.php';

$user_id = $_SESSION['user_id'];

$query = mysqli_query($conn,
    "SELECT website, username, encrypted_data, iv, salt 
     FROM vaults 
     WHERE user_id='$user_id'"
);

$data = [];

while($row = mysqli_fetch_assoc($query)){

    $data[] = $row;

}

header('Content-Type: application/json');
header('Content-Disposition: attachment; filename="vault_backup.json"');

echo json_encode($data, JSON_PRETTY_PRINT);

exit;

?>