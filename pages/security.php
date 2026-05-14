<?php
include '../config/session.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="UTF-8">

  <meta name="viewport"
        content="width=device-width, initial-scale=1.0">

  <title>Security Center</title>

  <link rel="stylesheet"
        href="../assets/css/style.css">

  <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">

  <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

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

    <a href="../api/logout.php"
       class="logout">

      Logout

    </a>

  </div>

  <!-- MAIN -->

  <div class="main">

    <div class="topbar">

      <div>

        <h1>Security Center</h1>

        <p>
          Sistem keamanan SafePass
        </p>

      </div>

    </div>

    <!-- SECURITY CARDS -->

    <div class="row g-4 mt-2">

      <!-- ENCRYPTION -->

      <div class="col-md-4">

        <div class="card shadow-lg border-0 rounded-4 p-3 h-100">

          <div class="card-body">

            <div class="fs-1 mb-3">
              🔐
            </div>

            <h3>
              Encryption
            </h3>

            <p class="text-muted">

              AES-256-GCM digunakan untuk
              mengenkripsi password dengan
              keamanan modern.

            </p>

          </div>

        </div>

      </div>

      <!-- PBKDF2 -->

      <div class="col-md-4">

        <div class="card shadow-lg border-0 rounded-4 p-3 h-100">

          <div class="card-body">

            <div class="fs-1 mb-3">
              🛡
            </div>

            <h3>
              PBKDF2
            </h3>

            <p class="text-muted">

              Derivasi key menggunakan
              PBKDF2 SHA-256 dengan
              600000 iterations.

            </p>

          </div>

        </div>

      </div>

      <!-- SESSION -->

      <div class="col-md-4">

        <div class="card shadow-lg border-0 rounded-4 p-3 h-100">

          <div class="card-body">

            <div class="fs-1 mb-3">
              ⏳
            </div>

            <h3>
              Session Security
            </h3>

            <p class="text-muted">

              Auto logout aktif setelah
              5 menit tidak ada aktivitas.

            </p>

          </div>

        </div>

      </div>

      <!-- PASSWORD -->

      <div class="col-md-6">

        <div class="card shadow-lg border-0 rounded-4 p-3 h-100">

          <div class="card-body">

            <div class="fs-1 mb-3">
              🔑
            </div>

            <h3>
              Password Protection
            </h3>

            <p class="text-muted">

              Semua password dienkripsi
              sebelum disimpan ke database.

            </p>

          </div>

        </div>

      </div>

      <!-- ZERO KNOWLEDGE -->

      <div class="col-md-6">

        <div class="card shadow-lg border-0 rounded-4 p-3 h-100">

          <div class="card-body">

            <div class="fs-1 mb-3">
              👁‍🗨
            </div>

            <h3>
              Zero Knowledge
            </h3>

            <p class="text-muted">

              Server tidak mengetahui
              password asli pengguna.

            </p>

          </div>

        </div>

      </div>

    </div>

  </div>

</div>

</body>
</html>