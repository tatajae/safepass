<?php

include '../config/session.php';
include '../config/db.php';

$user_id = $_SESSION['user_id'];

/* GET USER */
$stmt = $conn->prepare("
    SELECT *
    FROM users
    WHERE id=?
");

$stmt->bind_param("i", $user_id);
$stmt->execute();

$user = $stmt->get_result()->fetch_assoc();


/* GET LAST LOGIN FROM LOGS */
$log_stmt = $conn->prepare("
    SELECT created_at
    FROM logs
    WHERE user_id=?
    AND activity='login'
    ORDER BY created_at DESC
    LIMIT 1
");

$log_stmt->bind_param("i", $user_id);
$log_stmt->execute();

$log = $log_stmt->get_result()->fetch_assoc();

$last_login = $log['created_at'] ?? 'Belum ada login';

?>

<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Settings - SafePass</title>

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
        <li onclick="window.location='myvault.php'">My Vault</li>
        <li onclick="window.location='generator.php'">Generator</li>
        <li onclick="window.location='security.php'">Security</li>
        <li class="active">Settings</li>
    </ul>

    <a href="../API/logout.php" class="logout">Logout</a>

</div>

<!-- MAIN -->
<div class="main">

<div class="topbar">
    <div>
        <h1>Settings</h1>
        <p>Kelola akun dan keamanan SafePass</p>
    </div>
</div>

<div class="settings-grid">

<!-- ACCOUNT -->
<div class="settings-card">

<h3><i class="bi bi-person-circle"></i> Account</h3>

<div class="app-info">

<strong>User ID</strong><br>
<?= htmlspecialchars($user['id']); ?>

<br><br>

<strong>Last Login</strong><br>
<?= htmlspecialchars($last_login); ?>

<br><br>

<strong>System</strong><br>
AES-256-GCM Encryption<br>
PBKDF2 SHA-256<br>
Zero Knowledge Security

</div>

<br>

<button class="save-btn full-btn" onclick="toggleDarkMode()">
    <i class="bi bi-moon-fill"></i> Toggle Dark Mode
</button>

<br><br>

<a href="../API/export_csv.php" class="save-btn full-btn export-btn">
    <i class="bi bi-download"></i> Export Vault CSV
</a>

</div>

<!-- SECURITY -->
<div class="settings-card">

<h3><i class="bi bi-shield-lock-fill"></i> Security</h3>

<p class="settings-subtitle">
Ganti password dan pengaturan keamanan
</p>

<!-- PASSWORD -->
<input type="password" id="old_password" placeholder="Password Lama">

<input type="password" id="new_password" placeholder="Password Baru">

<input type="password" id="confirm_password" placeholder="Konfirmasi Password Baru">

<!-- SETTINGS -->
<div class="generator-options">

<label>
<input type="checkbox" id="session_timeout" checked>
Aktifkan Session Timeout
</label>

<label>
<input type="checkbox" id="encrypt_vault" checked>
Encrypt Semua Vault
</label>

<label>
<input type="checkbox" id="zero_knowledge" checked>
Zero Knowledge Protection
</label>

</div>

<!-- BUTTON -->
<div class="button-group">

<button class="save-btn" onclick="saveSettings()">
<i class="bi bi-floppy-fill"></i> Simpan
</button>

<button class="cancel-btn" onclick="resetSettings()">
<i class="bi bi-arrow-counterclockwise"></i> Reset
</button>

</div>

</div>

</div>

</div>

</div>

<!-- JS -->
<script src="../assets/js/auto_logout.js"></script>
</body>
</html>