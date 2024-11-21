<?php
// Check if the asset_id is set
$asset_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve and sanitize input data
    $asset_id = isset($_POST['asset_id']) ? intval($_POST['asset_id']) : 0;
    if ($asset_id <= 0) {
        die('Gagal menambahkan riwayat');
    }
    // Additional form handling logic here...
}
?>