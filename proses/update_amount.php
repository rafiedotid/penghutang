<?php
include '../koneksi.php'; // Menghubungkan ke database dan token API

header('Content-Type: application/json');

// Ambil data dari form
$id = $_POST['id'];
$amount = $_POST['amount'];

// Ambil data penghutang sebelum di-update
$sql = "SELECT * FROM debtors WHERE id=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$debtor = $result->fetch_assoc();

if (!$debtor) {
    echo json_encode(['success' => false, 'error' => 'Penghutang tidak ditemukan.']);
    exit();
}

// Update jumlah hutang di database
$sql = "UPDATE debtors SET amount = ? WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $amount, $id);

$response = [];
if ($stmt->execute()) {
    $response['success'] = true;

    // Kirim pesan pengingat dengan jumlah hutang baru
    $phone = $debtor['phone'];
    $name = $debtor['name'];
    $newAmount = number_format($amount, 0, ',', '.');
    $message = "Halo $name, jumlah hutang Anda telah diperbarui menjadi Rp$newAmount.";

    // Kirim pesan menggunakan API WhatsApp
    $curl = curl_init();

    curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://api.fonnte.com/send',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS => array(
            'target' => $phone,
            'message' => $message,
            'schedule' => 0,
            'delay' => '2',
            'countryCode' => '62',
        ),
        CURLOPT_HTTPHEADER => array(
            "Authorization: $apiToken"
        ),
    ));

    $curlResponse = curl_exec($curl);
    curl_close($curl);

    // Optional: you can log the response from the WhatsApp API if needed
} else {
    $response['success'] = false;
    $response['error'] = $stmt->error;
}

$stmt->close();
$conn->close();

echo json_encode($response);
?>
