<?php
include '../koneksi.php';

$response = ['success' => false];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Mengambil ID dan tanggal jatuh tempo dari POST request
    $id = isset($_POST['id']) ? intval($_POST['id']) : 0;
    $dueDate = isset($_POST['due_date']) ? $_POST['due_date'] : '';

    if ($id > 0 && !empty($dueDate)) {
        // Mengupdate tanggal jatuh tempo di database
        $stmt = $conn->prepare("UPDATE debtors SET due_date = ? WHERE id = ?");
        $stmt->bind_param('si', $dueDate, $id);

        if ($stmt->execute()) {
            $response['success'] = true;
        }

        $stmt->close();
    }
}

$conn->close();

// Mengirimkan response JSON
header('Content-Type: application/json');
echo json_encode($response);
?>
