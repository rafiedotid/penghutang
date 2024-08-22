<?php
// Menghubungkan ke database
include __DIR__ . '/../koneksi.php';

// Query untuk menghitung total hutang belum lunas dan lunas
$sqlTotalBelumLunas = "SELECT SUM(amount) AS total_belum_lunas FROM debtors WHERE status = 'belum_lunas'";
$resultTotalBelumLunas = $conn->query($sqlTotalBelumLunas);
$totalBelumLunas = $resultTotalBelumLunas->fetch_assoc()['total_belum_lunas'];

$sqlTotalLunas = "SELECT SUM(amount) AS total_lunas FROM debtors WHERE status = 'lunas'";
$resultTotalLunas = $conn->query($sqlTotalLunas);
$totalLunas = $resultTotalLunas->fetch_assoc()['total_lunas'];

// Batas jumlah data per halaman
$limit = 10;
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$start = ($page - 1) * $limit;

$search = isset($_GET['search']) ? $_GET['search'] : '';
$statusFilter = isset($_GET['status']) ? $_GET['status'] : '';
$search = $conn->real_escape_string($search); // Sanitasi pencarian
$statusFilter = $conn->real_escape_string($statusFilter);

// Query total data
$sqlTotal = "SELECT COUNT(*) AS total FROM debtors 
             WHERE (name LIKE '%$search%' OR phone LIKE '%$search%') 
             AND ('$statusFilter' = '' OR status = '$statusFilter')";
$resultTotal = $conn->query($sqlTotal);

if (!$resultTotal) {
    die('Error: ' . $conn->error);
}

$total = $resultTotal->fetch_assoc()['total'];
$totalPages = ceil($total / $limit);

// Query data dengan pagination, pencarian, dan urutan ascending
$sql = "SELECT * FROM debtors 
        WHERE (name LIKE '%$search%' OR phone LIKE '%$search%') 
        AND ('$statusFilter' = '' OR status = '$statusFilter') 
        ORDER BY name ASC 
        LIMIT $start, $limit";
$result = $conn->query($sql);

if (!$result) {
    die('Error: ' . $conn->error);
}
?>
