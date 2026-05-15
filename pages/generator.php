<?php

include '../config/session.php';

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Password Generator - SafePass</title>

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
                    Password Generator
                </h1>

                <p>
                    Buat password random yang aman
                </p>

            </div>

        </div>

        <!-- =========================
             GENERATOR CARD
        ========================== -->

        <div class="add-card">

            <h3>

                <i class="bi bi-key-fill"></i>

                Generate Secure Password

            </h3>

            <!-- LENGTH -->

            <label class="mb-2 mt-3">

                Panjang Password

            </label>

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
                readonly
            >

            <!-- BUTTON -->

            <div class="button-group">

                <button
                    class="save-btn"
                    onclick="generatePassword()"
                >

                    <i class="bi bi-stars"></i>

                    Generate

                </button>

                <button
                    class="cancel-btn"
                    onclick="copyPassword()"
                >

                    <i class="bi bi-clipboard-fill"></i>

                    Copy

                </button>

            </div>

            <!-- =========================
                 PASSWORD STRENGTH
            ========================== -->

            <div class="strength-container">

                <div id="strengthText">

                    Strength : -

                </div>

                <div class="strength-bar">

                    <div id="strengthFill"></div>

                </div>

            </div>

            <!-- INFO -->

            <div class="app-info mt-4">

                <strong>
                    Tips Password Aman
                </strong>

                <br><br>

                • Gunakan minimal 12 karakter

                <br>

                • Kombinasikan huruf, angka, dan simbol

                <br>

                • Jangan gunakan tanggal lahir

                <br>

                • Jangan gunakan password yang sama

                <br>

                • Simpan password di vault terenkripsi

            </div>

        </div>

    </div>

</div>

<!-- =========================
     SCRIPT
========================= -->

<script src="../assets/js/generator.js"></script>

<script src="../assets/js/auto_logout.js"></script>

</body>
</html>