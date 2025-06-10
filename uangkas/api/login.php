<?php
session_start();
require '../database/koneksi.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST["email"]);
    $password = $_POST["password"];

    // Validasi email dasar
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "Format email salah!";
        exit;
    }

    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $user = $stmt->get_result()->fetch_assoc();

    if ($user && password_verify($password, $user["password"])) {
        // Simpan data ke session
        $_SESSION["user_id"] = $user["id"];
        $_SESSION["name"] = $user["name"];
        $_SESSION["role"] = $user["role"];

        // Redirect ke dashboard
        header("Location:../frontend/dashboard.php");
        exit;
    } else {
        echo "Email atau password salah!";
    }

    if (isset($_GET['msg']) && $_GET['msg'] == 'registrasi_berhasil') {
    echo "<p style='color:green;'>Registrasi berhasil, silakan login.</p>";
}
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Login Kas Kelas</title>
</head>
<body>
  <h2>Login</h2>
  <form action="login.php" method="POST" id="loginForm">
    <label for="email">Email:</label><br />
    <input type="email" id="email" name="email" required /><br /><br />

    <label for="password">Password:</label><br />
    <input type="password" id="password" name="password" required /><br /><br />

    <button type="submit">Login</button>
  </form>

  <p>Belum punya akun? <a href="register.php">Registrasi</a></p>

  <script>
    // Validasi sebelum submit (opsional)
    document.getElementById('loginForm').addEventListener('submit', function(e) {
      const email = document.getElementById('email').value.trim();
      const password = document.getElementById('password').value;

      if (!email.includes('@')) {
        alert('Email harus mengandung @');
        e.preventDefault();
        return;
      }
      if (password.length < 6) {
        alert('Password minimal 6 karakter');
        e.preventDefault();
      }
    });
  </script>
</body>
</html>
