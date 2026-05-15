<?php

include '../config/session.php';
include '../config/db.php';

$user_id = $_SESSION['user_id'];

/* =========================
   GET VAULT
========================= */

$stmt = $conn->prepare(
    "SELECT *
     FROM vaults
     WHERE user_id=?
     ORDER BY id DESC"
);

$stmt->bind_param("i", $user_id);

$stmt->execute();

$query = $stmt->get_result();

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>My Vault - SafePass</title>

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

            <li class="active">
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
                    My Vault
                </h1>

                <p>
                    Simpan password terenkripsi dengan aman
                </p>

            </div>

            <button
                onclick="window.location='generator.php'"
                class="add-password-btn">

                <i class="bi bi-key-fill"></i>

                Generate Password

            </button>

        </div>

        <!-- SEARCH -->

        <input
            type="text"
            id="search"
            placeholder="Cari website atau username..."
            class="search-input"
            onkeyup="searchVault()"
        >

        <!-- =========================
             TABLE
        ========================== -->

        <div class="vault-table">

            <!-- HEADER -->

            <div class="table-header">

                <span>Website / App</span>

                <span>Username</span>

                <span>Password</span>

                <span>Action</span>

            </div>

            <!-- DATA -->

            <?php if(mysqli_num_rows($query) > 0): ?>

                <?php while($row = mysqli_fetch_assoc($query)): ?>

                    <div class="table-row">

                        <!-- WEBSITE -->

                        <span>

                            <?= htmlspecialchars($row['website']); ?>

                        </span>

                        <!-- USERNAME -->

                        <span>

                            <?= htmlspecialchars($row['username']); ?>

                        </span>

                        <!-- PASSWORD -->

                        <span>

                            ••••••••••

                        </span>

                        <!-- ACTION -->

                        <span class="actions">

                            <!-- VIEW -->

                            <button
                                class="view-btn"
                                title="View Password"

                                onclick='viewPassword(
                                    <?= json_encode($row["ciphertext"]); ?>,
                                    <?= json_encode($row["iv"]); ?>,
                                    <?= json_encode($row["salt"]); ?>,
                                    <?= json_encode($row["tag"]); ?>
                                )'
                            >

                                <i class="bi bi-eye-fill"></i>

                            </button>

                            <!-- COPY -->

                            <button
                                class="copy-btn"
                                title="Copy Password"

                                onclick='copyPassword(
                                    <?= json_encode($row["ciphertext"]); ?>,
                                    <?= json_encode($row["iv"]); ?>,
                                    <?= json_encode($row["salt"]); ?>,
                                    <?= json_encode($row["tag"]); ?>
                                )'
                            >

                                <i class="bi bi-clipboard-fill"></i>

                            </button>

                            <!-- EDIT -->

                            <button
                                class="edit-btn"
                                title="Edit Vault"

                                onclick='editVault(
                                    <?= json_encode($row["id"]); ?>,
                                    <?= json_encode($row["website"]); ?>,
                                    <?= json_encode($row["username"]); ?>,
                                    <?= json_encode($row["ciphertext"]); ?>,
                                    <?= json_encode($row["iv"]); ?>,
                                    <?= json_encode($row["salt"]); ?>,
                                    <?= json_encode($row["tag"]); ?>
                                )'
                            >

                                <i class="bi bi-pencil-square"></i>

                            </button>

                            <!-- DELETE -->

                            <button
                                class="delete-btn"
                                title="Delete Vault"

                                onclick='deleteVault(
                                    <?= json_encode($row["id"]); ?>
                                )'
                            >

                                <i class="bi bi-trash-fill"></i>

                            </button>

                        </span>

                    </div>

                <?php endwhile; ?>

            <?php else: ?>

                <!-- EMPTY -->

                <div class="table-row empty-row">

                    <span>Tidak ada data vault</span>

                    <span>-</span>

                    <span>-</span>

                    <span>-</span>

                </div>

            <?php endif; ?>

        </div>

        <!-- =========================
             ADD / EDIT VAULT
        ========================== -->

        <div class="add-card">

            <!-- TITLE -->

            <h3 id="formTitle">

                <i class="bi bi-plus-circle-fill"></i>

                Tambah Password

            </h3>

            <!-- WEBSITE -->

            <input
                type="text"
                id="website"
                placeholder="Website / App"
            >

            <!-- USERNAME -->

            <input
                type="text"
                id="username"
                placeholder="Username / Email"
            >

            <!-- PASSWORD -->

            <input
                type="password"
                id="password"
                placeholder="Password"
                onkeyup="checkStrength(this.value)"
            >

            <!-- PASSWORD STRENGTH -->

            <div class="strength-container">

                <div id="strengthText">

                    Strength : -

                </div>

                <div class="strength-bar">

                    <div id="strengthFill"></div>

                </div>

            </div>

            <!-- BUTTON -->

            <div class="button-group">

                <!-- SAVE -->

                <button
                    class="save-btn"
                    onclick="saveVault()"
                >

                    <i class="bi bi-floppy-fill"></i>

                    Simpan

                </button>

                <!-- CANCEL -->

                <button
                    class="cancel-btn"
                    onclick="clearForm()"
                >

                    <i class="bi bi-x-circle-fill"></i>

                    Batal

                </button>

            </div>

        </div>

    </div>

</div>

<!-- =========================
     SCRIPT
========================= -->

<script src="../assets/js/vault.js"></script>

<script src="../assets/js/crypto.js"></script>

<script src="../assets/js/dashboard.js"></script>

<script src="../assets/js/auto_logout.js"></script>

</body>
</html>