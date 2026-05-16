<?php
include '../config/session.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>My Vault - SafePass</title>

    <link rel="stylesheet" href="../assets/css/dashboard.css">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

</head>

<body>

<div class="dashboard">

    <!-- SIDEBAR -->
    <div class="sidebar">

        <div class="logo">
            <div class="logo-icon">🔒</div>
            <div>
                <h2>SAFEPASS</h2>
                <p>Password Manager</p>
            </div>
        </div>

        <ul>
            <li onclick="window.location='dashboard.php'">Dashboard</li>
            <li class="active">My Vault</li>
            <li onclick="window.location='generator.php'">Generator</li>
            <li onclick="window.location='security.php'">Security</li>
            <li onclick="window.location='settings.php'">Settings</li>
        </ul>

        <a href="../API/logout.php" class="logout">
            Logout
        </a>

    </div>

    <!-- MAIN -->
    <div class="main">

        <!-- TOPBAR -->
        <div class="topbar">

            <div>
                <h1>My Vault</h1>
                <p>Simpan password terenkripsi dengan aman</p>
            </div>

        </div>

        <!-- FORM -->
        <div class="add-card">

            <h3 id="formTitle">
                <i class="bi bi-plus-circle-fill"></i>
                Tambah Password
            </h3>

            <input type="text" id="website" placeholder="Website / App">
            <input type="text" id="username" placeholder="Username / Email">
            <input type="password" id="password" placeholder="Password" onkeyup="checkStrength(this.value)">
            <textarea id="notes" placeholder="Catatan tambahan"></textarea>

            <!-- STRENGTH -->
            <div class="strength-container">
                <div id="strengthText">Strength : -</div>
                <div class="strength-bar">
                    <div id="strengthFill"></div>
                </div>
            </div>

            <!-- BUTTON -->
            <div class="button-group">

                <button class="save-btn" onclick="savePassword()">
                    <i class="bi bi-floppy-fill"></i>
                    Simpan
                </button>

                <button class="cancel-btn" onclick="clearForm()">
                    <i class="bi bi-x-circle-fill"></i>
                    Batal
                </button>

            </div>

        </div>

        <!-- TABLE VAULT -->
        <div class="vault-section">

            <h2>My Vault</h2>

            <div class="vault-table">

                <div class="table-header">
                    <span>Website</span>
                    <span>Username</span>
                    <span>Password</span>
                    <span>Action</span>
                </div>

                <!-- DATA DARI JS -->
                <div id="vaultContainer"></div>

            </div>

        </div>

    </div>

</div>

<!-- SCRIPTS -->
<script src="../assets/js/crypto.js"></script>
<script src="../assets/js/vault.js"></script>
<script src="../assets/js/auto_logout.js"></script>

</body>
</html>