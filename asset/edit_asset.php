<?php
include '../config/connect.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $query = "SELECT * FROM assets WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();


    if ($result->num_rows > 0) {
        $asset = $result->fetch_assoc();
        echo json_encode($asset);
    } else {
        echo json_encode(["error" => "Asset not found"]);
    }
} else {
    echo json_encode(["error" => "ID not provided"]);
}
?>
