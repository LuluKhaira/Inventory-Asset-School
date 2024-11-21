<?php
include '../config/connect.php';

if (isset($_POST['id'])) {
    $id = $_POST['id'];

    // Prepare and execute delete query
    $query = "DELETE FROM buildings WHERE id = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, 'i', $id);

    if (mysqli_stmt_execute($stmt)) {
        // Respond with success
        echo json_encode(['status' => 'success']);
    } else {
        // Respond with error
        echo json_encode(['status' => 'error', 'message' => 'Gagal menghapus gedung.']);
    }

    mysqli_stmt_close($stmt);
}

mysqli_close($conn);
?>
