<?php
include '../config/connect.php';

if (isset($_GET['asset_id'])) {
    $asset_id = intval($_GET['asset_id']);
    
    $history_query = "SELECT * FROM history_barang WHERE asset_id = ? ORDER BY usage_date DESC";
    $stmt = $conn->prepare($history_query);
    $stmt->bind_param("i", $asset_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $history = $result->fetch_all(MYSQLI_ASSOC);
    
    header('Content-Type: application/json');
    echo json_encode($history);
} else {
    header('HTTP/1.1 400 Bad Request');
    echo json_encode(['error' => 'Asset ID not provided']);
}
?>