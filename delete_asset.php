<?php
include '../config/connect.php';

// Cek apakah ID diberikan
if (isset($_GET['id'])) {
    $id = intval($_GET['id']); // Ambil ID dari parameter

    // Hapus aset
    $deleteQuery = "DELETE FROM assets WHERE id = $id";
    $deleteResult = mysqli_query($conn, $deleteQuery);

    if ($deleteResult) {
        // Update ID untuk aset yang lebih besar
        $updateQuery = "UPDATE assets SET id = id - 1 WHERE id > $id";
        mysqli_query($conn, $updateQuery);
        
        // Reset AUTO_INCREMENT jika tidak ada data tersisa
        $countQuery = "SELECT COUNT(*) as total FROM assets";
        $countResult = mysqli_query($conn, $countQuery);
        $countRow = mysqli_fetch_assoc($countResult);
        
        if ($countRow['total'] == 0) {
            mysqli_query($conn, "ALTER TABLE assets AUTO_INCREMENT = 1");
        }

        // Redirect dengan pesan sukses
        header("Location: asset_list.php?message=Aset berhasil dihapus.");
        exit();
    } else {
        // Redirect dengan pesan error
        header("Location: asset_list.php?error=Error menghapus aset: " . mysqli_error($conn));
        exit();
    }
} else {
    // Redirect jika ID tidak ditemukan
    header("Location: asset_list.php?error=ID aset tidak ditemukan.");
    exit();
}
?>
