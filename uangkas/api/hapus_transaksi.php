<?php
include '../database/koneksi.php';

if (!isset($_POST['id'])) {
    echo json_encode(['success' => false, 'message' => 'ID transaksi tidak ada']);
    exit;
}

$id = (int)$_POST['id'];

$stmt = $conn->prepare("DELETE FROM transaksi WHERE id = ?");
$stmt->bind_param("i", $id);
$success = $stmt->execute();
$stmt->close();

echo json_encode(['success' => $success]);
?>
