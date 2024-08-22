<?php
include 'koneksi.php'; // Menghubungkan ke database dan token API

$sql = "SELECT * FROM debtors WHERE status='belum_lunas' AND due_date <= CURDATE()";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        // Kirim pengingat via WhatsApp API
        $phone = $row['phone'];
        $name = $row['name'];
        $amount = number_format($row['amount'], 0, ',', '.');
        $due_date = date("d-m-Y", strtotime($row['due_date']));
        
        $message = "Halo $name, ini pengingat bahwa hutang Anda sebesar Rp$amount yang jatuh tempo pada $due_date masih belum dilunasi. Mohon segera melakukan pembayaran.";

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
        if (curl_errno($curl)) {
            echo 'Curl error: ' . curl_error($curl);
        }
        curl_close($curl);
    }
}

$conn->close();
?>
