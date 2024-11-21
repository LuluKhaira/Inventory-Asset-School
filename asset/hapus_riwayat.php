<?php
include '../config/connect.php';

$response = ['success' => false, 'message' => ''];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $history_id = isset($_POST['history_id']) ? intval($_POST['history_id']) : 0;

    if ($history_id > 0) {
        $query = "DELETE FROM history_barang WHERE id = ?";
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, "i", $history_id);

        if (mysqli_stmt_execute($stmt)) {
            $response['success'] = true;
            $response['message'] = 'History record deleted successfully.';
        } else {
            $response['message'] = 'Failed to delete history record: ' . mysqli_error($conn);
        }
        mysqli_stmt_close($stmt);
    } else {
        $response['message'] = 'Invalid history ID.';
    }
} else {
    $response['message'] = 'Invalid request method.';
}

echo json_encode($response);
mysqli_close($conn);
