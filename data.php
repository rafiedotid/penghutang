<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Hutang</title>
    <style>
        /* CSS */
    </style>
</head>
<body>
    <nav>
        <ul>
            <li><a href="index.php">Catat Penghutang Baru</a></li>
            <li><a href="data.php">Kelola Penghutang</a></li>
        </ul>
    </nav>

    <div class="container">
        <h2>Daftar Penhutang</h2>
        <table>
            <thead>
                <tr>
                    <th>Nama</th>
                    <th>No. HP</th>
                    <th>Jumlah Hutang</th>
                    <th>Tanggal Jatuh Tempo</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                include 'koneksi.php'; // Menghubungkan ke database dan token API

                $sql = "SELECT * FROM debtors";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td data-label='Nama'>" . $row['name'] . "</td>";
                        echo "<td data-label='No. HP'>" . $row['phone'] . "</td>";
                        echo "<td data-label='Jumlah Hutang'>" . "Rp " . number_format($row['amount'], 0, ',', '.') . "</td>";
                        echo "<td data-label='Tanggal Jatuh Tempo'>" . date("d-m-Y", strtotime($row['due_date'])) . "</td>";
                        echo "<td data-label='Status'>" . ucfirst($row['status']) . "</td>";
                        echo "<td data-label='Aksi'><a href='update_status.php?id=" . $row['id'] . "&status=lunas'>Tandai Lunas</a></td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='6'>Tidak ada data.</td></tr>";
                }

                $conn->close();
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>
