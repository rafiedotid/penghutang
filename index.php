<?php
include 'koneksi.php'; // Menghubungkan ke database
include 'lib/header.php'; // Menghubungkan file header
include 'lib/navbar.php'; // Menghubungkan file navbar

// Jika formulir disubmit, proses data
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
        $success_message = "Data berhasil disimpan!";
        // Setelah menyimpan data, reset form
        $_POST = array();
    } else {
        $error_message = "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>

<body>
    <div id="app">
        <div id="main" class="layout-horizontal">
            <div class="container">
                <div class="page-heading">
                    <h3>Formulir Penghutang Baru</h3>
                </div>
                <div class="card">
                    <div class="card-body">
                        <?php if (isset($success_message)): ?>
                            <div class="alert alert-success" role="alert">
                                <?php echo $success_message; ?>
                            </div>
                        <?php elseif (isset($error_message)): ?>
                            <div class="alert alert-danger" role="alert">
                                <?php echo $error_message; ?>
                            </div>
                        <?php endif; ?>
                        <form id="debtForm" action="index.php" method="POST">
                            <div class="form-group">
                                <label for="name">Nama</label>
                                <input type="text" class="form-control" id="name" name="name" value="<?php echo isset($_POST['name']) ? htmlspecialchars($_POST['name']) : ''; ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="phone">No. HP</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" id="phone" name="phone" value="<?php echo isset($_POST['phone']) ? htmlspecialchars($_POST['phone']) : ''; ?>" required>
                                    <button type="button" class="btn btn-outline-secondary" id="pickContact">Pilih dari Kontak</button>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="amount">Jumlah Hutang</label>
                                <input type="number" class="form-control" id="amount" name="amount" value="<?php echo isset($_POST['amount']) ? htmlspecialchars($_POST['amount']) : ''; ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="due_date">Tanggal Jatuh Tempo</label>
                                <input type="date" class="form-control" id="due_date" name="due_date" value="<?php echo isset($_POST['due_date']) ? htmlspecialchars($_POST['due_date']) : ''; ?>" required>
                            </div>
                            <div class="form-group">
                                <input type="submit" class="btn btn-primary" value="Simpan">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/gh/zuramai/mazer@docs/demo/assets/compiled/js/app.js"></script>
    <script>
        document.getElementById("pickContact").addEventListener("click", function() {
            if ('contacts' in navigator && 'ContactsManager' in window) {
                const props = ['name', 'tel'];
                const opts = { multiple: false };

                navigator.contacts.select(props, opts).then(contacts => {
                    const contact = contacts[0];
                    if (contact.tel && contact.tel.length > 0) {
                        document.getElementById("phone").value = contact.tel[0];
                    }
                }).catch(error => {
                    console.error('Error:', error);
                });
            } else {
                alert("Fitur kontak tidak didukung di browser Anda.");
            }
        });
    </script>
</body>
</html>
