
<?php
session_start();
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>SafePass</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
          rel="stylesheet">

    <style>

        body{
            background:#0f172a;
            color:white;
            min-height:100vh;
            overflow-x:hidden;
        }

        .navbar{
            background:rgba(255,255,255,0.05);
            backdrop-filter:blur(10px);
        }

        .hero{
            padding:120px 0 80px;
        }

        .logo{
            font-size:48px;
            font-weight:bold;
        }

        .highlight{
            color:#38bdf8;
        }

        .card-box{
            background:rgba(255,255,255,0.08);
            border-radius:20px;
            padding:30px;
            height:100%;
            border:1px solid rgba(255,255,255,0.08);
        }

        .feature{
            background:rgba(255,255,255,0.05);
            border-radius:15px;
            padding:20px;
            height:100%;
        }

        footer{
            padding:40px 0;
            text-align:center;
            color:#cbd5e1;
        }

    </style>

</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark fixed-top">
    <div class="container">

        <a class="navbar-brand fw-bold" href="#">
            Safe<span class="highlight">Pass</span>
        </a>

        <div class="d-flex gap-2">

            <?php if(isset($_SESSION['user_id'])): ?>

                <a href="pages/dashboard.php"
                   class="btn btn-success">

                    Dashboard

                </a>

            <?php else: ?>

                <a href="pages/login.php"
                   class="btn btn-info">

                    Login

                </a>

                <a href="pages/register.php"
                   class="btn btn-outline-light">

                    Register

                </a>

            <?php endif; ?>

        </div>

    </div>
</nav>

<div class="container hero">

    <div class="row align-items-center">

        <div class="col-lg-6 mb-5">

            <div class="logo mb-3">
                Safe<span class="highlight">Pass</span>
            </div>

            <h1 class="fw-bold display-5 mb-4">
                Secure Password Manager
                dengan Modern Cryptography
            </h1>

            <p class="lead text-light mb-4">
                SafePass menggunakan AES-256-GCM,
                PBKDF2, dan bcrypt untuk melindungi
                password vault dengan konsep
                Zero-Knowledge Architecture.
            </p>

            <div class="d-flex gap-3 flex-wrap">

                <?php if(isset($_SESSION['user_id'])): ?>

                    <a href="pages/dashboard.php"
                       class="btn btn-success btn-lg">

                        Go To Dashboard

                    </a>

                <?php else: ?>

                    <a href="pages/login.php"
                       class="btn btn-info btn-lg">

                        Login

                    </a>

                    <a href="pages/register.php"
                       class="btn btn-outline-light btn-lg">

                        Register

                    </a>

                <?php endif; ?>

            </div>

        </div>

        <div class="col-lg-6">

            <div class="card-box">

                <h3 class="mb-4">
                    Security Features
                </h3>

                <div class="row g-4">

                    <div class="col-md-6">
                        <div class="feature">
                            <h5>AES-256-GCM</h5>
                            <p>
                                Authenticated encryption
                                untuk menjaga kerahasiaan
                                dan integritas data.
                            </p>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="feature">
                            <h5>PBKDF2</h5>
                            <p>
                                Key derivation dengan
                                iterasi tinggi untuk
                                mencegah brute force.
                            </p>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="feature">
                            <h5>bcrypt</h5>
                            <p>
                                Password login di-hash
                                menggunakan bcrypt.
                            </p>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="feature">
                            <h5>Zero-Knowledge</h5>
                            <p>
                                Server tidak dapat
                                membaca isi vault user.
                            </p>
                        </div>
                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

<div class="container mb-5">

    <div class="row g-4">

        <div class="col-md-4">
            <div class="card-box text-center">
                <h4>Password Generator</h4>
                <p>
                    Generate password kuat
                    secara otomatis.
                </p>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card-box text-center">
                <h4>Encrypted Vault</h4>
                <p>
                    Semua password disimpan
                    dalam bentuk ciphertext.
                </p>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card-box text-center">
                <h4>Auto Logout</h4>
                <p>
                    Session otomatis berakhir
                    saat idle.
                </p>
            </div>
        </div>

    </div>

</div>

<footer>
    <div class="container">
        SafePass © 2026 - Modern Cryptography Project
    </div>
</footer>

</body>
</html>
