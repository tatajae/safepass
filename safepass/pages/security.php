<?php

session_start();

if (!isset($_SESSION['user_id'])) {

  header("Location: login.php");

  exit;
}

include "../config/db.php";

$user_id = $_SESSION['user_id'];

$logs = mysqli_query(
  $conn,
  "SELECT * FROM logs
   WHERE user_id='$user_id'
   ORDER BY id DESC
   LIMIT 5"
);

?>

<!DOCTYPE html>
<html>
<head>

<title>Security</title>

<link rel="stylesheet"
href="../assets/css/style.css">

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

      <li class="active">
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

        <h1>Security Center</h1>

        <p>
          Monitoring keamanan akun
        </p>

      </div>

    </div>

    <!-- GRID -->

    <div class="security-grid">

      <!-- SCORE -->

      <div class="security-card">

        <h3>Security Score</h3>

        <div
        style="
        font-size:50px;
        font-weight:700;
        color:#374151;
        ">

          92%

        </div>

        <p>
          Password vault aman dan terenkripsi
        </p>

      </div>

      <!-- ACTIVITY -->

      <div class="security-card">

        <h3>Recent Activity</h3>

        <?php while($log = mysqli_fetch_assoc($logs)){ ?>

        <p>

          ✔ <?= $log['activity']; ?>

        </p>

        <?php } ?>

      </div>

    </div>

  </div>

</div>

</body>
</html>