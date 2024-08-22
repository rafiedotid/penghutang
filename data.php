<?php
include 'koneksi.php';
include 'lib/header.php'; // Menghubungkan file header
include 'lib/navbar.php'; // Menghubungkan file navbar

// Mengambil data dari proses
include 'proses/get_data.php';
?>

<body>
    <div id="app">
        <div id="main" class="layout-horizontal">
            <div class="container">
                <div class="page-heading">
                    <h3>Daftar Penghutang</h3>
                </div>
                <div class="row">
                    <!-- Card untuk Total Belum Lunas -->
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <h5>Total Hutang Belum Lunas</h5>
                                <h3>Rp<?php echo number_format($totalBelumLunas, 0, ',', '.'); ?></h3>
                            </div>
                        </div>
                    </div>
                    <!-- Card untuk Total Lunas -->
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <h5>Total Hutang Lunas</h5>
                                <h3>Rp<?php echo number_format($totalLunas, 0, ',', '.'); ?></h3>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">
                        <!-- Formulir Pencarian dan Filter -->
                        <form method="GET" class="mb-3">
                            <div class="input-group">
                                <input type="text" class="form-control" name="search" placeholder="Cari berdasarkan nama atau nomor HP" value="<?php echo htmlspecialchars($_GET['search'] ?? ''); ?>">
                                <select name="status" class="form-select">
                                    <option value="">Semua Status</option>
                                    <option value="belum_lunas" <?php echo (isset($_GET['status']) && $_GET['status'] == 'belum_lunas') ? 'selected' : ''; ?>>Belum Lunas</option>
                                    <option value="lunas" <?php echo (isset($_GET['status']) && $_GET['status'] == 'lunas') ? 'selected' : ''; ?>>Lunas</option>
                                </select>
                                <button class="btn btn-primary" type="submit">Cari</button>
                            </div>
                        </form>

                        <div class="table-responsive">
                            <table class="table table-striped">
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
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $statusClass = ($row['status'] == 'lunas') ? 'badge-success' : 'badge-danger';
            $statusText = ($row['status'] == 'lunas') ? 'Lunas' : 'Belum Lunas';
            
            echo "<tr>";
            echo "<td data-label='Nama'>" . htmlspecialchars($row['name']) . "</td>";
            echo "<td data-label='No. HP'>" . htmlspecialchars($row['phone']) . "</td>";
            echo "<td data-label='Jumlah Hutang'> Rp" . htmlspecialchars(number_format($row['amount'], 0, ',', '.')) . "</td>";
            echo "<td data-label='Tanggal Jatuh Tempo'>" . htmlspecialchars($row['due_date']) . "</td>";
            echo "<td data-label='Status'>
                <span class='badge $statusClass'>$statusText</span>
            </td>";
            echo "<td data-label='Aksi'>";

            // Disable or hide actions if status is "lunas"
            if ($row['status'] == 'belum_lunas') {
                echo "<a href='#' class='btn btn-primary btn-edit' data-id='" . $row['id'] . "' data-due-date='" . $row['due_date'] . "'>Edit Tanggal</a> ";
                echo "<a href='#' class='btn btn-warning btn-edit-amount' data-id='" . $row['id'] . "' data-amount='" . $row['amount'] . "'>Edit Jumlah</a> ";
                echo "<a href='proses/update_status.php?id=" . $row['id'] . "&status=lunas' class='btn btn-success'>Tandai Lunas</a>";
            } else {
                echo "<button class='btn btn-secondary' disabled>Sudah Lunas</button>";
            }

            echo "</td>";
            echo "</tr>";
        }
    } else {
        echo "<tr><td colspan='6'>Tidak ada data.</td></tr>";
    }
    ?>
</tbody>

                            </table>
                        </div>

                        <!-- Pagination -->
                        <nav aria-label="Page navigation">
                            <ul class="pagination">
                                <?php if ($page > 1): ?>
                                    <li class="page-item"><a class="page-link" href="?search=<?php echo urlencode($search); ?>&status=<?php echo urlencode($statusFilter); ?>&page=<?php echo $page - 1; ?>">Previous</a></li>
                                <?php endif; ?>
                                <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                                    <li class="page-item <?php echo $i == $page ? 'active' : ''; ?>"><a class="page-link" href="?search=<?php echo urlencode($search); ?>&status=<?php echo urlencode($statusFilter); ?>&page=<?php echo $i; ?>"><?php echo $i; ?></a></li>
                                <?php endfor; ?>
                                <?php if ($page < $totalPages): ?>
                                    <li class="page-item"><a class="page-link" href="?search=<?php echo urlencode($search); ?>&status=<?php echo urlencode($statusFilter); ?>&page=<?php echo $page + 1; ?>">Next</a></li>
                                <?php endif; ?>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Edit Tanggal Jatuh Tempo -->
    <div class="modal fade" id="editDateModal" tabindex="-1" aria-labelledby="editDateModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editDateModalLabel">Edit Tanggal Jatuh Tempo</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editDateForm">
                        <input type="hidden" id="debtorId" name="id">
                        <div class="mb-3">
                            <label for="dueDate" class="form-label">Tanggal Jatuh Tempo</label>
                            <input type="date" class="form-control" id="dueDate" name="due_date" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Edit Jumlah Hutang -->
    <div class="modal fade" id="editAmountModal" tabindex="-1" aria-labelledby="editAmountModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editAmountModalLabel">Edit Jumlah Hutang</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editAmountForm">
                        <input type="hidden" id="debtorIdAmount" name="id">
                        <div class="mb-3">
                            <label for="amount" class="form-label">Jumlah Hutang</label>
                            <input type="number" class="form-control" id="amount" name="amount" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const editButtons = document.querySelectorAll('.btn-edit');
            const editDateModal = new bootstrap.Modal(document.getElementById('editDateModal'));
            const editDateForm = document.getElementById('editDateForm');
            const debtorIdInput = document.getElementById('debtorId');
            const dueDateInput = document.getElementById('dueDate');

            const editButtonsAmount = document.querySelectorAll('.btn-edit-amount');
            const editAmountModal = new bootstrap.Modal(document.getElementById('editAmountModal'));
            const editAmountForm = document.getElementById('editAmountForm');
            const debtorIdAmountInput = document.getElementById('debtorIdAmount');
            const amountInput = document.getElementById('amount');

            // Handle Edit Tanggal Jatuh Tempo
            editButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const id = this.getAttribute('data-id');
                    const dueDate = this.getAttribute('data-due-date');
                    debtorIdInput.value = id;
                    dueDateInput.value = dueDate;
                    editDateModal.show();
                });
            });

            editDateForm.addEventListener('submit', function(event) {
                event.preventDefault();

                const formData = new FormData(editDateForm);

                fetch('proses/update_due_date.php', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        location.reload(); // Reload page to show updated data
                    } else {
                        alert('Terjadi kesalahan saat mengupdate tanggal jatuh tempo.');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                });
            });

            // Handle Edit Jumlah Hutang
            editButtonsAmount.forEach(button => {
                button.addEventListener('click', function() {
                    const id = this.getAttribute('data-id');
                    const amount = this.getAttribute('data-amount');
                    debtorIdAmountInput.value = id;
                    amountInput.value = amount;
                    editAmountModal.show();
                });
            });

            editAmountForm.addEventListener('submit', function(event) {
                event.preventDefault();

                const formData = new FormData(editAmountForm);

                fetch('proses/update_amount.php', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        location.reload(); // Reload page to show updated data
                    } else {
                        alert('Terjadi kesalahan saat mengupdate jumlah hutang.');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                });
            });
        });
    </script>
</body>
</html>
