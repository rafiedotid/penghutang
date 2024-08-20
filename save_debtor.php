<?php
include 'koneksi.php'; // Menghubungkan ke database dan token API

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $amount = $_POST['amount'];
    $due_date = $_POST['due_date'];

    // Menyimpan data ke database
    $sql = "INSERT INTO debtors (name, phone, amount, due_date, status) VALUES ('$name', '$phone', '$amount', '$due_date', 'belum_lunas')";
    
    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Data berhasil disimpan!'); window.location.href='index.php';</script>";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}
?>
