<?php
// Konfigurasi koneksi database
$servername = "localhost"; // Nama server database Anda
$username = "root"; // Username MySQL Anda
$password = ""; // Password MySQL Anda
$dbname = "inventory_db"; // Nama database yang Anda gunakan

// Membuat koneksi ke database
$conn = new mysqli($servername, $username, $password, $dbname);

// Cek koneksi
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Cek koneksi
if ($conn->connect_error) {
    die("Koneksi ke database gagal: " . $conn->connect_error);
}

