<!-- dashboard.php -->

<?php

include '../config/session.php';

header("Cache-Control: no-cache, no-store, must-revalidate");
header("Pragma: no-cache");
header("Expires: 0");

include "../config/db.php";

$user_id = $_SESSION['user_id'];

$stmt = $conn->prepare(
    "SELECT * FROM vaults
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

    <title>SafePass Dashboard</title>

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

            <li class="active">
                Dashboard
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

        <a href="../api/logout.php"
           class="logout">

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

            <button class="add-password-btn"
                    onclick="generatePassword()">

                + Generate Password

            </button>

        </div>

        <!-- SEARCH -->

        <input type="text"
               id="search"
               placeholder="Cari website atau username..."
               class="search-input"
               onkeyup="searchVault()">

        <!-- TABLE -->

        <div class="vault-table">

            <div class="table-header">

                <span>Website / App</span>

                <span>Username</span>

                <span>Password</span>

                <span>Aksi</span>

            </div>

            <?php if(mysqli_num_rows($query) > 0): ?>

                <?php while($row = mysqli_fetch_assoc($query)): ?>

                    <div class="table-row">

                        <span>
                            <?= htmlspecialchars($row['website']); ?>
                        </span>

                        <span>
                            <?= htmlspecialchars($row['username']); ?>
                        </span>

                        <span>
                            ••••••••
                        </span>

                        <span class="actions">

                            <!-- VIEW -->

                            <button
                                class="view-btn"

                                data-cipher="<?= htmlspecialchars($row['ciphertext']); ?>"

                                data-iv="<?= htmlspecialchars($row['iv']); ?>"

                                data-salt="<?= htmlspecialchars($row['salt']); ?>"

                                onclick="openDecryptModal(this)"
                            >

                                <i class="bi bi-eye"></i>

                            </button>

                            <!-- COPY -->

                            <button
                                class="copy-btn"

                                data-cipher="<?= htmlspecialchars($row['ciphertext']); ?>"

                                data-iv="<?= htmlspecialchars($row['iv']); ?>"

                                data-salt="<?= htmlspecialchars($row['salt']); ?>"

                                onclick="copyPassword(this)"
                            >

                                <i class="bi bi-clipboard"></i>

                            </button>

                            <!-- EDIT -->

                            <button
                                class="edit-btn"

                                onclick="editVault(
                                    <?= $row['id']; ?>,
                                    '<?= htmlspecialchars($row['website']); ?>',
                                    '<?= htmlspecialchars($row['username']); ?>'
                                )"
                            >

                                <i class="bi bi-pencil-square"></i>

                            </button>

                            <!-- DELETE -->

                            <button
                                class="delete-btn"

                                onclick="deleteVault(
                                    <?= $row['id']; ?>
                                )"
                            >

                                <i class="bi bi-trash"></i>

                            </button>

                        </span>

                    </div>

                <?php endwhile; ?>

            <?php else: ?>

                <div class="empty-state text-center mt-5">

                    <h3>
                        Belum ada password tersimpan
                    </h3>

                    <p>
                        Tambahkan vault pertama kamu
                    </p>

                </div>

            <?php endif; ?>

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

            <div class="password-wrapper">

                <input
                    type="password"
                    id="password"
                    placeholder="Password"
                    onkeyup="checkStrength()"
                >

                <button
                    type="button"
                    onclick="togglePassword()"
                >

                    <i class="bi bi-eye"></i>

                </button>

            </div>

            <div id="strength"
                 class="mt-2">
            </div>

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

        </div>

    </div>

</div>

<!-- MODAL -->

<div class="modal fade"
     id="decryptModal"
     tabindex="-1">

    <div class="modal-dialog">

        <div class="modal-content bg-dark text-white">

            <div class="modal-header">

                <h5 class="modal-title">
                    Master Password
                </h5>

                <button type="button"
                        class="btn-close btn-close-white"
                        data-bs-dismiss="modal">
                </button>

            </div>

            <div class="modal-body">

                <input type="password"
                       id="masterPassword"
                       class="form-control"
                       placeholder="Masukkan Master Password">

                <div id="decryptResult"
                     class="mt-3">
                </div>

            </div>

            <div class="modal-footer">

                <button class="btn btn-success"
                        onclick="decryptVault()">

                    Decrypt

                </button>

            </div>

        </div>

    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script src="../assets/js/crypto.js"></script>

<script src="../assets/js/dashboard.js"></script>

<script src="../assets/js/auto_logout.js"></script>

</body>
</html>