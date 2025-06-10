<?php
include '../database/koneksi.php';

$periode = isset($_GET['periode']) ? $_GET['periode'] : 'harian'; // harian, mingguan, bulanan
$jenis = isset($_GET['jenis']) ? $_GET['jenis'] : 'semua';
$tanggal_start = isset($_GET['tanggal_start']) ? $_GET['tanggal_start'] : null;
$tanggal_end = isset($_GET['tanggal_end']) ? $_GET['tanggal_end'] : null;

$whereClauses = [];
$params = [];

if ($jenis === 'pemasukan') {
    $whereClauses[] = "jenis = 'Pemasukan'";
} elseif ($jenis === 'pengeluaran') {
    $whereClauses[] = "jenis = 'Pengeluaran'";
}

if ($tanggal_start && $tanggal_end) {
    $whereClauses[] = "tanggal BETWEEN ? AND ?";
    $params[] = $tanggal_start;
    $params[] = $tanggal_end;
} elseif ($tanggal_start) {
    $whereClauses[] = "tanggal >= ?";
    $params[] = $tanggal_start;
} elseif ($tanggal_end) {
    $whereClauses[] = "tanggal <= ?";
    $params[] = $tanggal_end;
}

$whereSql = count($whereClauses) ? "WHERE " . implode(" AND ", $whereClauses) : "";

if ($periode === 'harian') {
    // Tampilkan semua transaksi harian
    $sql = "SELECT * FROM transaksi $whereSql ORDER BY tanggal ASC";
    $stmt = $conn->prepare($sql);
    if ($params) {
        $types = str_repeat('s', count($params));
        $stmt->bind_param($types, ...$params);
    }
    $stmt->execute();
    $result = $stmt->get_result();
    $data = [];
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
    $stmt->close();
} else if ($periode === 'mingguan') {
    // Gabungkan transaksi per minggu, pisahkan pemasukan dan pengeluaran
    // Kita hitung minggu ke berapa dalam bulan: minggu 1 = tgl 1-7, minggu 2 = 8-14, dst
    $sql = "
        SELECT 
            YEAR(tanggal) AS tahun,
            MONTH(tanggal) AS bulan,
            CEIL(DAY(tanggal) / 7) AS minggu_ke,
            jenis,
            SUM(nominal) AS total_nominal
        FROM transaksi
        $whereSql
        GROUP BY tahun, bulan, minggu_ke, jenis
        ORDER BY tahun, bulan, minggu_ke, jenis
    ";
    $stmt = $conn->prepare($sql);
    if ($params) {
        $types = str_repeat('s', count($params));
        $stmt->bind_param($types, ...$params);
    }
    $stmt->execute();
    $result = $stmt->get_result();
    $data = [];
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
    $stmt->close();
} else if ($periode === 'bulanan') {
    // Gabungkan transaksi per bulan
    $sql = "
        SELECT 
            YEAR(tanggal) AS tahun,
            MONTH(tanggal) AS bulan,
            jenis,
            SUM(nominal) AS total_nominal
        FROM transaksi
        $whereSql
        GROUP BY tahun, bulan, jenis
        ORDER BY tahun, bulan, jenis
    ";
    $stmt = $conn->prepare($sql);
    if ($params) {
        $types = str_repeat('s', count($params));
        $stmt->bind_param($types, ...$params);
    }
    $stmt->execute();
    $result = $stmt->get_result();
    $data = [];
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
    $stmt->close();
} else {
    $data = [];
}

echo json_encode(['data' => $data]);
?>
