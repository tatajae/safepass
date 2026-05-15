<?php

include '../config/session.php';
include '../config/db.php';

header('Content-Type: application/json');

/* =========================
   VALIDASI LOGIN
========================= */

if(!isset($_SESSION['user_id'])){

    echo json_encode([
        "success" => false,
        "message" => "Unauthorized"
    ]);

    exit;
}

$user_id = $_SESSION['user_id'];

/* =========================
   GET JSON
========================= */

$data = json_decode(
    file_get_contents("php://input"),
    true
);

/* =========================
   VALIDASI ID
========================= */

if(!isset($data['id'])){

    echo json_encode([
        "success" => false,
        "message" => "ID vault tidak ditemukan"
    ]);

    exit;
}

$id = intval($data['id']);

/* =========================
   DELETE VAULT
========================= */

$stmt = $conn->prepare(
    "DELETE FROM vaults
     WHERE id=? AND user_id=?"
);

$stmt->bind_param(
    "ii",
    $id,
    $user_id
);

if($stmt->execute()){

    if($stmt->affected_rows > 0){

        echo json_encode([
            "success" => true,
            "message" => "Vault berhasil dihapus"
        ]);

    }else{

        echo json_encode([
            "success" => false,
            "message" => "Vault tidak ditemukan"
        ]);
    }

}else{

    echo json_encode([
        "success" => false,
        "message" => "Gagal menghapus vault"
    ]);
}