<?php
session_start();
include '../config/connect.php';

// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Function to log debug messages
function debug_log($message) {
    error_log(date('[Y-m-d H:i:s] ') . $message . "\n", 3, 'debug.log');
}

debug_log("Script started");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    debug_log("POST request received");
    
    // Log received data
    debug_log("Received data: " . print_r($_POST, true));

    $nama = isset($_POST['nama']) ? trim($_POST['nama']) : '';
    $building = isset($_POST['building']) ? trim($_POST['building']) : '';
    $jumlah = isset($_POST['jumlah']) ? trim($_POST['jumlah']) : '';
    $asset_condition = isset($_POST['asset_condition']) ? trim($_POST['asset_condition']) : '';
    

    debug_log("Processed input - nama: $nama, building: $building, jumlah: $jumlah, asset_condition: $asset_condition");

    if (empty($nama) || empty($building) || empty($jumlah) ||empty($asset_condition)) {
        debug_log("Invalid input detected");
        echo "Input tidak valid. Pastikan semua kolom terisi dengan benar.";
        exit;
    }

    // Check database connection
    if ($conn->connect_error) {
        debug_log("Database connection failed: " . $conn->connect_error);
        die("Connection failed: " . $conn->connect_error);
    } else {
        debug_log("Database connection successful");
    }

    // Selalu buat entri baru, tanpa pengecekan aset yang sudah ada
    debug_log("Inserting new asset...");
    $stmt = $conn->prepare("INSERT INTO assets (nama, building, jumlah, asset_condition) VALUES (?, ?, ?, ?)");
    if (!$stmt) {
        debug_log("Insert prepare failed: " . $conn->error);
        die("Insert prepare failed: " . $conn->error);
    }

    $stmt->bind_param("ssis", $nama, $building, $jumlah, $asset_condition);
    if ($stmt->execute()) {
        debug_log("New asset inserted successfully. ID: " . $stmt->insert_id);
        $_SESSION['asset_id'] = $stmt->insert_id;
        header("Location: ../admin/asset_list.php");
        exit;
    } else {
        debug_log("Error adding new asset: " . $stmt->error);
        echo "Error adding new asset: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
debug_log("Script ended");
?>
