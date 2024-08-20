<?php
include 'koneksi.php'; // Menghubungkan ke database dan token API

$id = $_GET['id'];

// Ambil data penghutang sebelum di-update
$sql = "SELECT * FROM debtors WHERE id='$id'";
$result = $conn->query($sql);
$debtor = $result->fetch_assoc();

if ($debtor['status'] == 'lunas') {
    // Jika hutang sudah lunas, tidak perlu mengirim pengingat lagi
    echo "Hutang sudah ditandai sebagai lunas sebelumnya.";
    exit();
}

// Update status hutang menjadi lunas
$sql = "UPDATE debtors SET status='lunas' WHERE id='$id'";

if ($conn->query($sql) === TRUE) {
    // Kirim pesan pengingat bahwa hutang telah lunas via WhatsApp API
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

    echo "Hutang telah ditandai sebagai lunas dan pengingat telah dikirim.";
} else {
    echo "Error: " . $conn->error;
}

$conn->close();

header('Location: data.php'); // Kembali ke halaman data.php setelah proses selesai
exit();
?>
