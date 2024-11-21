<?php
include '../config/connect.php';

// Function to sanitize input
function sanitize_input($conn, $input) {
    return mysqli_real_escape_string($conn, trim($input));
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = isset($_POST['action']) ? $_POST['action'] : 'add';
    
    // Sanitize inputs
    $asset_id = intval($_POST['asset_id']);
    $user_name = sanitize_input($conn, $_POST['user_name']);
    $start_date = sanitize_input($conn, $_POST['start_date']);
    $end_date = sanitize_input($conn, $_POST['end_date']);

    // Validate input
    if (empty($user_name) || empty($start_date) || empty($end_date)) {
        echo json_encode(['success' => false, 'error' => 'Semua kolom harus diisi.']);
        exit;
    }

    // Check if asset_id exists in assets table
    $checkAssetQuery = "SELECT id FROM assets WHERE id = ?";
    $checkAssetStmt = $conn->prepare($checkAssetQuery);
    $checkAssetStmt->bind_param("i", $asset_id);
    $checkAssetStmt->execute();
    $checkAssetStmt->store_result();

    if ($checkAssetStmt->num_rows == 0) {
        echo json_encode(['success' => false, 'error' => 'Asset ID tidak valid.']);
        exit;
    }

    if ($action === 'add') {
        // Insert new history record
        $query = "INSERT INTO history_barang (asset_id, user, usage_date, end_date) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("isss", $asset_id, $user_name, $start_date, $end_date);
    } else if ($action === 'update') {
        // Update existing history record
        $history_id = intval($_POST['history_id']);
        $query = "UPDATE history_barang SET user=?, usage_date=?, end_date=? WHERE id=? AND asset_id=?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("sssii", $user_name, $start_date, $end_date, $history_id, $asset_id);
    } else {
        echo json_encode(['success' => false, 'error' => 'Invalid action.']);
        exit;
    }

    if ($stmt->execute()) {
        // Fetch the updated history
        $historyQuery = "SELECT * FROM history_barang WHERE asset_id = ? ORDER BY usage_date DESC";
        $historyStmt = $conn->prepare($historyQuery);
        $historyStmt->bind_param("i", $asset_id);
        $historyStmt->execute();
        $historyResult = $historyStmt->get_result();
        
        $history = [];
        while ($row = $historyResult->fetch_assoc()) {
            $history[] = $row;
        }
        
        echo json_encode(['success' => true, 'history' => $history]);
    } else {
        echo json_encode(['success' => false, 'error' => 'Query error: ' . $stmt->error]);
    }

    $stmt->close();
} else {
    echo json_encode(['success' => false, 'error' => 'Invalid request method.']);
}

$conn->close();
?>
