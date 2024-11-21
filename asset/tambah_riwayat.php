<?php
include '../config/connect.php';

$response = ['success' => false, 'message' => ''];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $history_id = isset($_POST['history_id']) ? intval($_POST['history_id']) : 0;
    $user_name = isset($_POST['user_name']) ? mysqli_real_escape_string($conn, $_POST['user_name']) : '';
    $start_date = isset($_POST['start_date']) ? $_POST['start_date'] : '';
    $end_date = isset($_POST['end_date']) ? $_POST['end_date'] : '';

    if ($history_id > 0) {
        $query = "UPDATE history_barang SET user = ?, usage_date = ?, end_date = ? WHERE id = ?";
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, "sssi", $user_name, $start_date, $end_date, $history_id);

        if (mysqli_stmt_execute($stmt)) {
            $response['success'] = true;
            $response['message'] = 'History updated successfully.';
        } else {
            $response['message'] = 'Failed to update history: ' . mysqli_error($conn);
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
