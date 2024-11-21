<?php
include '../config/connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $building_name = $_POST['building_name'];
    $letak_gedung_lantai = $_POST['letak_gedung_lantai'];

    if (!empty($building_name) && !empty($letak_gedung_lantai)) {
        // Sanitize input and insert into database
        $stmt = $conn->prepare("INSERT INTO buildings (building_name, letak_gedung_lantai) VALUES (?, ?)");
        $stmt->bind_param("ss", $building_name, $letak_gedung_lantai);
        if ($stmt->execute()) {
            // Return success response
            $response = array(
                'status' => 'success',
                'new_building_id' => $conn->insert_id,
                'building_name' => htmlspecialchars($building_name),
                'letak_gedung_lantai' => htmlspecialchars($letak_gedung_lantai)
            );
        } else {
            $response = array('status' => 'error', 'message' => 'Failed to add building.');
        }
        $stmt->close();
    } else {
        $response = array('status' => 'error', 'message' => 'Fields are missing.');
    }

    echo json_encode($response);
}
?>
