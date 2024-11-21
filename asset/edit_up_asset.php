<?php
include '../config/connect.php';

header('Content-Type: application/json');



if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $nama = $_POST['nama'];
    $building = $_POST['building'];
    $jumlah = $_POST['jumlah'];
    $asset_condition = $_POST['asset_condition'];

    // Validasi input
    if (!empty($id) && !empty($nama) && !empty($asset_condition) && !empty($jumlah) && !empty($building)) {
        $query = "UPDATE assets SET nama = ?, asset_condition = ?, jumlah = ?, building = ? WHERE id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param('ssiii', $nama, $asset_condition, $jumlah, $building, $id);

        if ($stmt->execute()) {
            echo json_encode(['status' => 'success', 'message' => 'Aset berhasil diperbarui.']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Error: ' . $stmt->error]);
        }

        $stmt->close();
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Mohon lengkapi semua field.']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Metode request tidak valid.']);
}
?>
