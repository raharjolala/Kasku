<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

require_once __DIR__ . '/../database/koneksi.php'; // assuming koneksi.php returns $conn

// Get query parameters
$filter = isset($_GET['filter']) ? $_GET['filter'] : 'harian';
$jenis = isset($_GET['jenis']) ? $_GET['jenis'] : 'semua';
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$rowsPerPage = isset($_GET['rows']) ? intval($_GET['rows']) : 5;

// Calculate offset for pagination
$offset = ($page - 1) * $rowsPerPage;

// Build the SQL query based on filters
$whereClauses = [];
if ($jenis !== 'semua') {
    $whereClauses[] = "jenis = '$jenis'";
}

// Date filtering
$dateCondition = '';
if ($filter === 'harian') {
    $dateCondition = "DATE(tanggal) = CURDATE()"; // Today's transactions
} elseif ($filter === 'mingguan') {
    $dateCondition = "YEARWEEK(tanggal, 1) = YEARWEEK(CURDATE(), 1)"; // Current week transactions
} elseif ($filter === 'bulanan') {
    $dateCondition = "MONTH(tanggal) = MONTH(CURDATE()) AND YEAR(tanggal) = YEAR(CURDATE())"; // Current month transactions
}

if ($dateCondition) {
    $whereClauses[] = $dateCondition;
}

$whereSQL = count($whereClauses) > 0 ? 'WHERE ' . implode(' AND ', $whereClauses) : '';

// Count total records for pagination
$totalQuery = "SELECT COUNT(*) as total FROM transaksi $whereSQL";
$totalResult = $conn->query($totalQuery);
$totalCount = $totalResult->fetch_assoc()['total'];
$totalPages = ceil($totalCount / $rowsPerPage);

// Fetch the transactions
$query = "SELECT * FROM transaksi $whereSQL LIMIT $offset, $rowsPerPage";
$result = $conn->query($query);

$transactions = [];
if ($result) {
    while ($row = $result->fetch_assoc()) {
        $transactions[] = $row;
    }
}

// Return the response
$response = [
    'data' => $transactions,
    'totalPages' => $totalPages
];

echo json_encode($response);
?>
