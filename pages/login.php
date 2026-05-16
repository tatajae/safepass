<!DOCTYPE html>
<html lang="en">
<head>

  <meta charset="UTF-8">

  <meta name="viewport"
  content="width=device-width, initial-scale=1.0">

  <title>Login SafePass</title>

  <link rel="stylesheet"
  href="../assets/css/style.css">

  <link rel="preconnect"
  href="https://fonts.googleapis.com">

  <link rel="preconnect"
  href="https://fonts.gstatic.com"
  crossorigin>

  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
  rel="stylesheet">

</head>
<body>

<div class="login-container">

  <div class="login-card">

    <div class="logo">
      🔒
    </div>

    <h1>SafePass</h1>

    <p class="subtitle">
      Login ke akun anda
    </p>

    <input
      type="email"
      id="email"
      placeholder="Masukkan Email"
    >

    <input
      type="password"
      id="password"
      placeholder="Masukkan Password"
    >

    <button onclick="login()">
      Login
    </button>

    <p class="register-text">

      Belum punya akun?

      <a href="register.php">
        Register
      </a>

    </p>

  </div>

</div>

<script src="../assets/js/crypto.js"></script>
<script src="../assets/js/auth.js"></script>

</body>
</html>