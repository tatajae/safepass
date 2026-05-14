<!-- pages/generator.php -->

<?php
session_start();
include '../config/session.php';
if (!isset($_SESSION['user_id'])) {

  header("Location: login.php");

  exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>

<meta charset="UTF-8">

<meta name="viewport"
content="width=device-width, initial-scale=1.0">

<title>SafePass Generator</title>

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

      <li class="active">
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

        <h1>Password Generator</h1>

        <p>
          Buat password random yang aman
        </p>

      </div>

    </div>

    <!-- GENERATOR CARD -->

    <div class="add-card">

      <h3>Generate Secure Password</h3>

      <!-- LENGTH -->

      <label>Panjang Password</label>

      <input
        type="number"
        id="length"
        value="16"
        min="6"
        max="50"
      >

      <!-- OPTIONS -->

      <div class="generator-options">

        <label>

          <input
            type="checkbox"
            id="uppercase"
            checked
          >

          Huruf Besar

        </label>

        <label>

          <input
            type="checkbox"
            id="lowercase"
            checked
          >

          Huruf Kecil

        </label>

        <label>

          <input
            type="checkbox"
            id="number"
            checked
          >

          Angka

        </label>

        <label>

          <input
            type="checkbox"
            id="symbol"
            checked
          >

          Simbol

        </label>

      </div>

      <!-- RESULT -->

      <input
        type="text"
        id="resultPassword"
        placeholder="Password hasil generate"
        oninput="checkStrength(this.value)"
      >

      <!-- BUTTON -->

      <div class="button-group">

        <button
          class="save-btn"
          onclick="generatePassword()"
        >
          Generate
        </button>

        <button
          class="cancel-btn"
          onclick="copyPassword()"
        >
          Copy
        </button>

      </div>

      <!-- STRENGTH TEXT -->

      <div
        id="strength"
        style="
        margin-top:20px;
        font-weight:600;
        font-size:18px;
        "
      >
      </div>

      <!-- STRENGTH BAR -->

      <div class="strength-bar">

        <div id="strengthFill"></div>

      </div>

    </div>

  </div>

</div>
<script src="../assets/js/generator.js"></script>
</body>
</html>