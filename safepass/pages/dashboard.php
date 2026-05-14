<?php
include '../config/session.php';

if (!isset($_SESSION['user_id'])) {

  header("Location: login.php");

  exit;
}

include "../config/db.php";

$user_id = $_SESSION['user_id'];

$query = mysqli_query(
  $conn,
  "SELECT * FROM vaults
   WHERE user_id='$user_id'
   ORDER BY id DESC"
);

?>

<!DOCTYPE html>
<html lang="en">
<head>

  <meta charset="UTF-8">

  <meta name="viewport"
  content="width=device-width, initial-scale=1.0">

  <title>SafePass Dashboard</title>

  <link rel="stylesheet"
  href="../assets/css/style.css">

  <link rel="preconnect"
  href="https://fonts.googleapis.com">

  <link rel="preconnect"
  href="https://fonts.gstatic.com"
  crossorigin>

  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
  rel="stylesheet">

</head>
<body>

<div class="dashboard">

  <!-- SIDEBAR -->

  <div class="sidebar">

    <div class="logo">

      <div class="logo-icon">
        🔒
      </div>

      <div>

        <h2>SAFEPASS</h2>

        <p>Password Manager</p>

      </div>

    </div>

    <ul>

      <li class="active">
        Dashboard
      </li>

      <li onclick="window.location='dashboard.php'">
        My Vault
      </li>

      <li onclick="window.location='generator.php'">
        Generator
      </li>

      <li onclick="window.location='security.php'">
        Security
      </li>

      <li onclick="window.location='settings.php'">
        Settings
      </li>

    </ul>

    <a
      href="../api/logout.php"
      class="logout"
    >
      Logout
    </a>

  </div>

  <!-- MAIN -->

  <div class="main">

    <div class="topbar">

      <div>

        <h1>My Vault</h1>

        <p>
          Simpan password terenkripsi dengan aman
        </p>

      </div>

      <button
        class="add-password-btn"
        onclick="generatePassword()"
      >
        + Generate Password
      </button>

    </div>

    <input
      type="text"
      id="search"
      placeholder="Cari website atau username..."
      class="search-input"
      onkeyup="searchVault()"
    >

    <!-- TABLE -->

    <div class="vault-table">

      <div class="table-header">

        <span>Website / App</span>

        <span>Username</span>

        <span>Password</span>

        <span>Aksi</span>

      </div>

      <?php while($row = mysqli_fetch_assoc($query)) { ?>

      <div class="table-row">

        <span>
          <?= $row['website']; ?>
        </span>

        <span>
          <?= $row['username']; ?>
        </span>

        <span>
          ••••••••
        </span>

        <span class="actions">

        <button
          class="view-btn"

          onclick="viewPassword(
          '<?= $row['ciphertext']; ?>',
          '<?= $row['iv']; ?>',
          '<?= $row['salt']; ?>'
          )"
        >
          👁
        </button>

        <button
          class="copy-btn"

          onclick="copyPassword(
          '<?= $row['ciphertext']; ?>',
          '<?= $row['iv']; ?>',
          '<?= $row['salt']; ?>'
          )"
          >
            📋
          </button>

          <button
            class="edit-btn"

            onclick="editVault(

              <?= $row['id']; ?>,

              '<?= $row['website']; ?>',

              '<?= $row['username']; ?>'

            )"
          >
            ✏
          </button>

          <button
            class="delete-btn"

            onclick="deleteVault(
              <?= $row['id']; ?>
            )"
          >
            🗑
          </button>

        </span>

      </div>

      <?php } ?>

    </div>

    <!-- FORM -->

    <div class="add-card">

      <h3>Tambah Password</h3>

      <input
        type="text"
        id="website"
        placeholder="Website / App"
      >

      <input
        type="text"
        id="username"
        placeholder="Username / Email"
      >

      <input
        type="password"
        id="password"
        placeholder="Password"
      >

      <div class="button-group">

        <button
          class="save-btn"
          onclick="saveVault()"
        >
          Simpan
        </button>

        <button
          class="cancel-btn"
          onclick="clearForm()"
        >
          Batal
        </button>

      </div>

      <div id="result"></div>

    </div>

  </div>

</div>

<script src="../assets/js/crypto.js"></script>
<script src="../assets/js/dashboard.js"></script>
<script src="../assets/js/auto_logout.js"></script>

</body>
</html>