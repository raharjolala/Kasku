<?php
include '../database/koneksi.php';

if (!isset($_POST['id'], $_POST['tanggal'], $_POST['jenis'], $_POST['nominal'], $_POST['keterangan'])) {
    echo json_encode(['success' => false, 'message' => 'Data tidak lengkap']);
    exit;
}

$id = (int)$_POST['id'];
$tanggal = $_POST['tanggal'];
$jenis = $_POST['jenis']; // harus Pemasukan atau Pengeluaran
$nominal = (int)$_POST['nominal'];
$keterangan = $_POST['keterangan'];

if (!in_array($jenis, ['Pemasukan', 'Pengeluaran'])) {
    echo json_encode(['success' => false, 'message' => 'Jenis transaksi tidak valid']);
    exit;
}

$stmt = $conn->prepare("UPDATE transaksi SET tanggal = ?, jenis = ?, nominal = ?, keterangan = ? WHERE id = ?");
$stmt->bind_param("ssisi", $tanggal, $jenis, $nominal, $keterangan, $id);
$success = $stmt->execute();
$stmt->close();

echo json_encode(['success' => $success]);
?>
