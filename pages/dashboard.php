<?php

include '../config/session.php';
include '../config/db.php';

$user_id = $_SESSION['user_id'];

/* =========================
   TOTAL VAULT
========================= */

$stmtVault = $conn->prepare(
    "SELECT COUNT(*) as total
     FROM vaults
     WHERE user_id=?"
);

$stmtVault->bind_param("i", $user_id);

$stmtVault->execute();

$totalVault = $stmtVault
    ->get_result()
    ->fetch_assoc()['total'];

/* =========================
   WEAK PASSWORD
========================= */

$stmtWeak = $conn->prepare(
    "SELECT COUNT(*) as weak
     FROM vaults
     WHERE user_id=?
     AND password_strength='Weak'"
);

$stmtWeak->bind_param("i", $user_id);

$stmtWeak->execute();

$weakPassword = $stmtWeak
    ->get_result()
    ->fetch_assoc()['weak'];

/* =========================
   SECURITY SCORE
========================= */

if($totalVault > 0){

    $securityScore =
        100 - (
            ($weakPassword / $totalVault) * 100
        );

}else{

    $securityScore = 100;
}

$securityScore = round($securityScore);

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>SafePass Dashboard</title>

    <link rel="stylesheet"
          href="../assets/css/dashboard.css">

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

                <p>
                    Password Manager
                </p>

            </div>

        </div>

        <ul>

            <li class="active">
                Dashboard
            </li>

            <li onclick="window.location='myvault.php'">
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

        <a href="../API/logout.php"
           class="logout">

            Logout

        </a>

    </div>

    <!-- MAIN -->

    <div class="main">

        <!-- TOPBAR -->

        <div class="topbar">

            <div>

                <h1>
                    Dashboard
                </h1>

                <p>
                    Welcome back 👋
                </p>

            </div>

        </div>

        <!-- STATS -->

        <div class="stats-grid">

            <!-- TOTAL VAULT -->

            <div class="stats-card">

                <i class="bi bi-shield-lock"></i>

                <h3>
                    <?= $totalVault; ?>
                </h3>

                <p>
                    Total Vault
                </p>

            </div>

            <!-- WEAK PASSWORD -->

            <div class="stats-card">

                <i class="bi bi-exclamation-triangle"></i>

                <h3>
                    <?= $weakPassword; ?>
                </h3>

                <p>
                    Weak Password
                </p>

            </div>

            <!-- SECURITY SCORE -->

            <div class="stats-card">

                <i class="bi bi-graph-up"></i>

                <h3>
                    <?= $securityScore; ?>%
                </h3>

                <p>
                    Security Score
                </p>

            </div>

        </div>

        <!-- QUICK ACTION -->

        <div class="quick-actions">

            <button
                onclick="window.location='myvault.php'"
                class="action-btn">

                Open My Vault

            </button>

            <button
                onclick="window.location='generator.php'"
                class="action-btn">

                Generate Password

            </button>

        </div>

    </div>

</div>

<script src="../assets/js/auto_logout.js"></script>

</body>
</html>