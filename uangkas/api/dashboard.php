<?php
include '../database/koneksi.php'; // atau sesuaikan path folder kamu

if (!$conn) {
  die("Koneksi gagal: " . mysqli_connect_error());
}

// Fungsi format rupiah
function formatRupiah($angka) {
  return "Rp " . number_format($angka, 0, ',', '.');
}

// Total pemasukan
$queryPemasukan = mysqli_query($conn, "SELECT SUM(nominal) AS total FROM transaksi WHERE jenis = 'Pemasukan'");
$totalPemasukan = mysqli_fetch_assoc($queryPemasukan)['total'] ?? 0;

// Total pengeluaran
$queryPengeluaran = mysqli_query($conn, "SELECT SUM(nominal) AS total FROM transaksi WHERE jenis = 'Pengeluaran'");
$totalPengeluaran = mysqli_fetch_assoc($queryPengeluaran)['total'] ?? 0;

// Saldo
$saldo = $totalPemasukan - $totalPengeluaran;

// Transaksi terbaru (5 terakhir)
$queryTransaksi = mysqli_query($conn, "SELECT * FROM transaksi ORDER BY tanggal DESC LIMIT 5");
?>
