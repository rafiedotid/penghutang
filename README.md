<h1>PENGHOETANK</h1>

<p><strong>PENGHOETANK</strong> adalah aplikasi manajemen penghutang berbasis web yang memungkinkan pengguna untuk mencatat dan mengelola hutang, mengirim pengingat melalui WhatsApp, serta menandai hutang sebagai lunas. Aplikasi ini dirancang dengan antarmuka yang responsif dan mendukung penggunaan di berbagai perangkat.</p>

<h2>Fitur Utama</h2>
<ul>
    <li>Mengelola daftar penghutang dengan informasi nama, nomor HP, jumlah hutang, dan tanggal jatuh tempo.</li>
    <li>Mengirim pengingat otomatis melalui API WhatsApp.</li>
    <li>Fitur pencarian dan filter berdasarkan status hutang (lunas/belum lunas).</li>
    <li>Mengedit tanggal jatuh tempo dan jumlah hutang langsung dari tabel data.</li>
    <li>Responsive design yang cocok untuk tampilan desktop dan mobile.</li>
</ul>

<h2>Instalasi</h2>
<p>Untuk menginstal aplikasi ini, ikuti langkah-langkah berikut:</p>
<ol>
    <li>Clone repository ini.</li>
    <li>Koneksikan aplikasi ke database MySQL dengan mengedit file <code>koneksi.php</code>.</li>
    <li>Import database dengan skema yang telah disediakan.</li>
    <li>Sesuaikan konfigurasi API WhatsApp jika diperlukan.</li>
    <li>Akses aplikasi melalui browser dengan membuka <code>index.php</code>.</li>
</ol>

<h2>Struktur Proyek</h2>
<ul>
    <li><code>/lib</code> - Berisi file header dan navbar.</li>
    <li><code>/proses</code> - Berisi skrip untuk memproses update data seperti tanggal jatuh tempo dan jumlah hutang.</li>
    <li><code>koneksi.php</code> - File konfigurasi untuk koneksi database.</li>
    <li><code>index.php</code> - Halaman utama untuk menambahkan penghutang baru.</li>
    <li><code>data.php</code> - Halaman untuk melihat daftar penghutang dan mengelola status hutang.</li>
</ul>

<h2>Lisensi</h2>
<p>Aplikasi ini bersifat open-source dan dilisensikan di bawah lisensi MIT.</p>

</body>
</html>
