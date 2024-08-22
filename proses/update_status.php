<?php
session_start();
include '../koneksi.php'; // Menghubungkan ke database dan token API

// Cek apakah ID dan status diset
if (!isset($_GET['id']) || !isset($_GET['status'])) {
    echo "ID atau status tidak diset.";
    exit();
}

$id = $_GET['id'];
$status = $_GET['status'];

// Validasi status
if ($status !== 'belum_lunas' && $status !== 'lunas') {
    echo "Status tidak valid.";
    exit();
}

// Ambil data penghutang sebelum di-update
$sql = "SELECT * FROM debtors WHERE id=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$debtor = $result->fetch_assoc();

if (!$debtor) {
    echo "Penghutang tidak ditemukan.";
    exit();
}

// Cek jika status yang sama sudah diterapkan
if ($debtor['status'] === $status) {
    echo "Status penghutang sudah sesuai.";
    exit();
}

// Update status hutang
$sql = "UPDATE debtors SET status=? WHERE id=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("si", $status, $id);

if ($stmt->execute()) {
    // Kirim pesan pengingat jika statusnya adalah lunas
    if ($status === 'lunas') {
        $phone = $debtor['phone'];
        $name = $debtor['name'];
        $amount = number_format($debtor['amount'], 0, ',', '.');
        $message = "Halo $name, terima kasih telah melunasi hutang sebesar Rp$amount. Hutang Anda sudah dinyatakan lunas.";

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

        $response = curl_exec($curl);
        curl_close($curl);
    }

    echo "Status hutang telah diperbarui.";
} else {
    echo "Error: " . $conn->error;
}

$stmt->close();
$conn->close();

header('Location: data.php'); // Kembali ke halaman data.php setelah proses selesai
exit();
?>
