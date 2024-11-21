<?php
// Ambil daftar aset
$query = "SELECT assets.*, buildings.building_name FROM assets LEFT JOIN buildings ON assets.building = buildings.id ORDER BY assets.id ASC";
$result = mysqli_query($conn, $query);

// Ambil daftar gedung dari tabel buildings
$buildingQuery = "SELECT id, building_name FROM buildings ORDER BY building_name";
$buildingResult = mysqli_query($conn, $buildingQuery);

// Cek apakah query untuk gedung berhasil
if (!$buildingResult) {
    die("Query Error: " . mysqli_error($conn));
}

// Cek apakah query untuk aset berhasil
if (!$result) {
    die("Query Error: " . mysqli_error($conn));
}
?>