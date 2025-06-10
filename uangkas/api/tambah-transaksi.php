<?php
include '../database/koneksi.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $tanggal = $_POST['tanggal'];
  $jenis = $_POST['jenis'];
  $nominal = $_POST['nominal'];
  $keterangan = $_POST['keterangan'];

  $stmt = $conn->prepare("INSERT INTO catatan_keuangan (tanggal, jenis, nominal, keterangan) VALUES (?, ?, ?, ?)");
  $stmt->bind_param("ssis", $tanggal, $jenis, $nominal, $keterangan);
  
  if ($stmt->execute()) {
    header("Location: ../frontend/catatan.php?success=1");
  } else {
    echo "Gagal menambahkan data: " . $stmt->error;
  }

  $stmt->close();
  $conn->close();
} else {
  echo "Metode tidak valid.";
}
?>
