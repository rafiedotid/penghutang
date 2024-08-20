Setup Database

Buat database baru dan jalankan skrip SQL berikut untuk membuat tabel:

sql
Copy code
CREATE DATABASE nama_database;

USE nama_database;

CREATE TABLE debtors (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    phone VARCHAR(20) NOT NULL,
    amount DECIMAL(15, 2) NOT NULL,
    due_date DATE NOT NULL,
    status ENUM('belum_lunas', 'lunas') DEFAULT 'belum_lunas'
);
