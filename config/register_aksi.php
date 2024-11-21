<?php
include '../config/connect.php'; // Menghubungkan ke database

// Memproses pendaftaran
if (isset($_POST['signUp'])) {
    $firstName = $_POST['fName']; // Mengambil nama depan 
    $lastName = $_POST['lName'];  // Mengambil nama belakang
    $email = $_POST['email'];     // Mengambil email
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hash password
    $level = $_POST['level'];     // Mengambil level (user/admin)

    // Cek apakah admin sudah ada
    if ($level === 'admin') {
        $check_admin = $conn->query("SELECT * FROM users WHERE level = 'admin'");

        if ($check_admin->num_rows > 0) {
            echo "<script>
            alert('Hanya satu admin yang diizinkan. Silakan daftar sebagai user atau hubungi administrator.');
            location.href='../config/register.php';
            </script>";
        } else {
            // Tambahkan pengguna sebagai admin
            $stmt = $conn->prepare("INSERT INTO users (firstName, lastName, email, password, level) VALUES (?, ?, ?, ?, ?)");
            $stmt->bind_param("sssss", $firstName, $lastName, $email, $password, $level);

            if ($stmt->execute()) {
                echo "<script> alert ('Admin berhasil terdaftar.');
                location.href='../config/login.php';
                </script>";
            } else {
                echo "Gagal mendaftarkan admin: " . $stmt->error;
            }
            $stmt->close();
        }
    } else {
        // Proses pendaftaran sebagai user
        $check_email = $conn->query("SELECT * FROM users WHERE email = '$email'");

        if ($check_email->num_rows > 0) {
            echo "<script>
            alert('Email sudah digunakan. Silakan gunakan email lain.');
            location.href='../config/register.php';
            </script>";
        } else {
            // Siapkan statement untuk menambah user
            $stmt = $conn->prepare("INSERT INTO users (firstName, lastName, email, password, level) VALUES (?, ?, ?, ?, ?)");
            $stmt->bind_param("sssss", $firstName, $lastName, $email, $password, $level);

            // Eksekusi statement
            if ($stmt->execute()) {
                echo "<script>
                alert('Akun berhasil didaftarkan');
                location.href='../config/login.php';
                </script>";
            } else {
                echo "<script>
                alert('Gagal mendaftarkan akun');
                location.href='../config/register.php';
                </script>";
            }
            $stmt->close();
        }
    }

    // Tutup koneksi
    $conn->close();
}
?>
