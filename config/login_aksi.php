<?php
include '../config/connect.php'; // Menghubungkan ke database
session_start(); // Memulai sesi untuk menyimpan informasi login

if (isset($_POST['signIn'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Cek apakah email valid
    $sql = mysqli_prepare($conn, "SELECT * FROM users WHERE email = ?");
    mysqli_stmt_bind_param($sql, 's', $email);
    mysqli_stmt_execute($sql);
    $result = mysqli_stmt_get_result($sql);

    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);

        // Verifikasi password yang di-hash
        if (password_verify($password, $row['password'])) {
            // Set session variables
            $_SESSION['email'] = $row['email'];
            $_SESSION['firstName'] = $row['FName'];
            $_SESSION['lastName'] = $row['LName'];
            $_SESSION['level'] = $row['level'];
            $_SESSION['status'] = 'login';

            // Cek level pengguna untuk mengarahkan ke halaman yang sesuai
            if ($row['level'] == 'admin') {
                echo "<script>
                alert('You are logged in as Admin');
                location.href = '../admin/index.php';
                </script>";
            } else {
                echo "<script>
                alert('Login Successfully');
                location.href = '../user/index.php';
                </script>";
            }
        } else {
            // Jika password salah
            echo "<script>
            alert('Incorrect password');
            location.href = '../config/login.php';
            </script>";
        }
    } else {
        // Jika pengguna tidak ditemukan
        echo "<script>
        alert('User not found');
        location.href = '../config/login.php';
        </script>";
    }
}
?>
