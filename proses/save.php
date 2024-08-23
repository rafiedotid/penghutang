<?php
session_start();
include '../koneksi.php'; // Menghubungkan ke database dan token API

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $amount = $_POST['amount'];
    $due_date = $_POST['due_date'];

    // Menyimpan data ke database
    $sql = "INSERT INTO debtors (name, phone, amount, due_date, status) VALUES (?, ?, ?, ?, 'belum_lunas')";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssis", $name, $phone, $amount, $due_date);

    if ($stmt->execute()) {
        $_SESSION['success_message'] = "Data berhasil disimpan!";
        
        // Kirim pesan ke penghutang
        $message = "Halo $name, Anda telah terdaftar sebagai penghutang sebesar Rp" . number_format($amount, 0, ',', '.') . ". Jatuh tempo Anda adalah pada tanggal $due_date. Mohon segera melunasi hutang Anda sebelum jatuh tempo.";
        
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

        header('Location: ../index.php');
        exit();
    } else {
        $_SESSION['error_message'] = "Error: " . $stmt->error;
        header('Location: ../index.php');
        exit();
    }

    $stmt->close();
    $conn->close();
}
?>
