<?php
session_start();
require '../database/koneksi.php'; // Sesuaikan path sesuai struktur folder

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST["nama"]);
    $email = trim($_POST["email"]);
    $password = $_POST["password"];

    // Validasi server side yang sama seperti JS
   if (!preg_match("/^[a-zA-Z]+(?:\s[a-zA-Z]+)*$/", $name)) {
        die("Nama hanya boleh berisi huruf dan spasi, dan tidak boleh diakhiri spasi.");
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        die("Email tidak valid.");
    }

    if (strlen($password) < 6 || strlen($password) > 20 ||
        !preg_match("/[A-Z]/", $password) ||
        !preg_match("/[a-z]/", $password) ||
        !preg_match("/[0-9]/", $password) ||
        !preg_match("/[@!#$%&*]/", $password)) {
        die("Password tidak memenuhi syarat.");
    }

    // Cek username sudah ada?
    $stmt = $conn->prepare("SELECT id FROM users WHERE name = ?");
    $stmt->bind_param("s", $name);
    $stmt->execute();
    $stmt->store_result();
    if ($stmt->num_rows > 0) {
        die("Username sudah digunakan, silakan pilih nama lain.");
    }
    $stmt->close();

    // Cek email sudah ada?
    $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();
    if ($stmt->num_rows > 0) {
        die("Akun dengan email ini sudah ada, silakan login.");
    }
    $stmt->close();

    // Hash password
    $hashed = password_hash($password, PASSWORD_DEFAULT);

    $insert = $conn->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
    $insert->bind_param("sss", $name, $email, $hashed);
    if ($insert->execute()) {
        $insert->close();
        // Redirect ke login.php dengan pesan sukses
        header("Location:../frontend/login.php?msg=registrasi_berhasil");
        exit;
    } else {
        die("Gagal registrasi: " . $conn->error);
    }
}
?>
<!-- register.php -->
