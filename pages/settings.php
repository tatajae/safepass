<!-- pages/settings.php -->

<?php

session_start();
include '../config/session.php';
if (!isset($_SESSION['user_id'])) {

  header("Location: login.php");

  exit;
}

include "../config/db.php";

$user_id = $_SESSION['user_id'];

$user = mysqli_fetch_assoc(

  mysqli_query(

    $conn,

    "SELECT * FROM users
     WHERE id='$user_id'"
  )
);

?>

<!DOCTYPE html>
<html lang="en">
<head>

<meta charset="UTF-8">

<meta name="viewport"
content="width=device-width, initial-scale=1.0">

<title>SafePass Settings</title>

<link rel="stylesheet"
href="../assets/css/style.css">

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

      <li onclick="window.location='dashboard.php'">
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

      <li class="active">
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

    <!-- TOPBAR -->

    <div class="topbar">

      <div>

        <h1>Settings</h1>

        <p>
          Kelola akun dan keamanan SafePass
        </p>

      </div>

    </div>

    <!-- SETTINGS GRID -->

    <div class="settings-grid">

      <!-- ACCOUNT SETTINGS -->

      <div class="settings-card">

        <h3>Account Settings</h3>

        <p class="settings-subtitle">
          Kelola akun dan backup data vault
        </p>

        <!-- DARK MODE -->

        <button
          class="save-btn full-btn"
          onclick="toggleDarkMode()"
        >
          Toggle Dark Mode
        </button>

        <!-- EXPORT CSV -->

        <a
          href="../api/export_csv.php"
          class="save-btn full-btn export-btn"
        >
          Export CSV
        </a>

        <!-- LAST LOGIN -->

        <div class="app-info">

          <strong>
            Last Login
          </strong>

          <br><br>

          <?= $user['last_login']; ?>

          <br><br>

          SafePass v1.0 <br>

          UAS Keamanan Data <br>

          AES-GCM Encryption Enabled

        </div>

      </div>

      <!-- SECURITY SETTINGS -->

      <div class="settings-card">

        <h3>Security Settings</h3>

        <p class="settings-subtitle">
          Ganti password dan keamanan akun
        </p>

        <!-- INPUT -->

        <input
          type="password"
          placeholder="Password Lama"
        >

        <input
          type="password"
          placeholder="Password Baru"
        >

        <input
          type="password"
          placeholder="Konfirmasi Password Baru"
        >

        <!-- OPTIONS -->

        <div class="generator-options">

          <label>

            <input
              type="checkbox"
              checked
            >

            Aktifkan Session Timeout

          </label>

          <label>

            <input
              type="checkbox"
              checked
            >

            Encrypt Semua Vault

          </label>

          <label>

            <input
              type="checkbox"
            >

            Dark Mode

          </label>

        </div>

        <!-- BUTTON -->

        <div class="button-group">

          <button
            class="save-btn"
            onclick="saveSettings()"
          >
            Simpan
          </button>

          <button
            class="cancel-btn"
            onclick="resetSettings()"
          >
            Reset
          </button>

        </div>

      </div>

    </div>

  </div>

</div>

<script>

function saveSettings(){

  alert(
    "Pengaturan berhasil disimpan"
  );
}

function resetSettings(){

  location.reload();
}

function toggleDarkMode(){

  document.body.classList.toggle(
    'dark-mode'
  );
}

</script>

</body>
</html>