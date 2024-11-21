<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Aset</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLi0/qaxk5u+6bmc7AZ5f3b3S5FCzT6yES/FBUf4Oz4P9njPlVQm/WsV8FKXBTd" crossorigin="anonymous">
</head>
<body>

    <div class="container mt-5">
        <h1 class="mb-4">Detail Aset Gedung</h1>
        
        <?php
        include '../config/connect.php';

        if (isset($_GET['id'])) {
            $id = $_GET['id'];

            // Query untuk mendapatkan detail aset berdasarkan ID gedung
            $query = "SELECT id, nama, asset_condition FROM assets WHERE building = ?";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                echo '<div class="row">';
                while ($row = $result->fetch_assoc()) {
                    echo '<div class="col-md-4">';
                    echo '<div class="card mb-4">';
                    echo '<div class="card-body">';
                    echo '<h5 class="card-title">ID: ' . htmlspecialchars($row['id']) . '</h5>';
                    echo '<p class="card-text"><strong>Nama:</strong> ' . htmlspecialchars($row['nama']) . '</p>';
                    echo '<p class="card-text"><strong>Kondisi:</strong> ' . htmlspecialchars($row['asset_condition']) . '</p>';
                    echo '</div>';
                    echo '</div>';
                    echo '</div>';
                }
                echo '</div>';
            } else {
                echo '<div class="alert alert-warning" role="alert">';
                echo 'Tidak ada aset di gedung ini.';
                echo '</div>';
            }
        } else {
            echo '<div class="alert alert-danger" role="alert">';
            echo 'ID gedung tidak ditemukan.';
            echo '</div>';
        }
        ?>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-m/QklfA5DZX49lEq/CFgp0BDKHtvgj5ChtVOBDzSdmm/SswMn+dRZvjtnwIJ2v4c" crossorigin="anonymous"></script>
</body>
</html>
