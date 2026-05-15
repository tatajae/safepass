<?php
include '../config/session.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Security Center - SafePass</title>

    <!-- CSS -->

    <link rel="stylesheet"
          href="../assets/css/dashboard.css">

    <!-- BOOTSTRAP -->

    <link rel="stylesheet"
          href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">

    <!-- ICON -->

    <link rel="stylesheet"
          href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

</head>

<body>

<div class="dashboard">

    <!-- =========================
         SIDEBAR
    ========================== -->

    <div class="sidebar">

        <div class="logo">

            <div class="logo-icon">
                🔒
            </div>

            <div>

                <h2>SAFEPASS</h2>

                <p>
                    Password Manager
                </p>

            </div>

        </div>

        <!-- MENU -->

        <ul>

            <li onclick="window.location='dashboard.php'">

                Dashboard

            </li>

            <li onclick="window.location='myvault.php'">

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

        <!-- LOGOUT -->

        <a href="../API/logout.php"
           class="logout">

            Logout

        </a>

    </div>

    <!-- =========================
         MAIN
    ========================== -->

    <div class="main">

        <!-- TOPBAR -->

        <div class="topbar">

            <div>

                <h1>
                    Security Center
                </h1>

                <p>
                    Sistem keamanan SafePass
                </p>

            </div>

        </div>

        <!-- =========================
             SECURITY GRID
        ========================== -->

        <div class="stats-grid">

            <!-- ENCRYPTION -->

            <div class="stats-card">

                <i class="bi bi-shield-lock-fill"></i>

                <h3>
                    AES-256
                </h3>

                <p>

                    Semua vault dienkripsi
                    menggunakan AES-256-GCM
                    sebelum disimpan ke server.

                </p>

            </div>

            <!-- PBKDF2 -->

            <div class="stats-card">

                <i class="bi bi-key-fill"></i>

                <h3>
                    PBKDF2
                </h3>

                <p>

                    Key derivation menggunakan
                    PBKDF2 SHA-256 dengan
                    600000 iterations.

                </p>

            </div>

            <!-- SESSION -->

            <div class="stats-card">

                <i class="bi bi-clock-history"></i>

                <h3>
                    Auto Logout
                </h3>

                <p>

                    Session otomatis logout
                    setelah 5 menit tidak
                    ada aktivitas.

                </p>

            </div>

            <!-- PASSWORD -->

            <div class="stats-card">

                <i class="bi bi-lock-fill"></i>

                <h3>
                    Password Protection
                </h3>

                <p>

                    Password tidak pernah
                    disimpan dalam bentuk
                    plaintext di database.

                </p>

            </div>

            <!-- ZERO KNOWLEDGE -->

            <div class="stats-card">

                <i class="bi bi-eye-slash-fill"></i>

                <h3>
                    Zero Knowledge
                </h3>

                <p>

                    Server tidak dapat
                    membaca password asli
                    pengguna.

                </p>

            </div>

            <!-- SECURE STORAGE -->

            <div class="stats-card">

                <i class="bi bi-database-lock"></i>

                <h3>
                    Secure Storage
                </h3>

                <p>

                    Data vault hanya bisa
                    didekripsi menggunakan
                    master password user.

                </p>

            </div>

        </div>

        <!-- =========================
             SECURITY INFO
        ========================== -->

        <div class="add-card mt-4">

            <h3>

                <i class="bi bi-info-circle-fill"></i>

                Security Information

            </h3>

            <p style="margin-top:15px; line-height:30px; color:#d1d5db;">

                SafePass menggunakan arsitektur
                zero-knowledge encryption,
                di mana seluruh proses
                enkripsi dan dekripsi dilakukan
                di sisi client menggunakan
                JavaScript Web Crypto API.

                <br><br>

                Bahkan jika database server
                diretas, attacker hanya akan
                mendapatkan ciphertext yang
                tidak dapat dibaca tanpa
                master password pengguna.

            </p>

        </div>

    </div>

</div>

<script src="../assets/js/auto_logout.js"></script>

</body>
</html>