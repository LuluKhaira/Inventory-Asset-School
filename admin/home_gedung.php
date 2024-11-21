<?php
include '../config/connect.php';

// Fetch buildings from the database using prepared statements
$query = "SELECT * FROM buildings ORDER BY id ASC";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Gedung - Asset Management System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../config/all.css">
    <style>
        .table-responsive {
            background-color: white;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .table th {
            background-color: #f8f9fa;
        }

        .btn-action {
            margin-right: 5px;
        }
    </style>
</head>

<body>
    <?php include '../navbar/nav_admin.php'; ?>

    <div class="container content-wrapper animate__animated animate__fadeIn">
        <h1 class="text-center mb-5 animate__animated animate__bounceInDown">Daftar Gedung</h1>

        <div class="mb-4">
            <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addGedungModal" name="add">
                <i class="fas fa-plus"></i> Tambah Gedung Baru
            </button>
        </div>

        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nama Gedung</th>
                        <th>Letak Gedung di Lantai Berapa</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (mysqli_num_rows($result) > 0) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo "<tr>";
                            echo "<td>" . htmlspecialchars($row['id']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['building_name']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['letak_gedung_lantai']) . "</td>";
                            echo "<td>";
                            echo "<button class='btn btn-primary btn-sm btn-action view-assets' data-id='" . $row['id'] . "'>Detail</button>";

                            echo "<button class='btn btn-danger btn-sm btn-action delete-gedung' data-id='" . $row['id'] . "'>Hapus</button>";
                            echo "</td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='4' class='text-center'>Tidak ada gedung yang ditemukan.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Add Gedung Modal -->
    <div class="modal fade" id="addGedungModal" tabindex="-1" aria-labelledby="addGedungModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addGedungModalLabel">Tambah Gedung Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="addGedungForm">
                        <div class="mb-3">
                            <label for="building_name" class="form-label">Nama Gedung</label>
                            <input type="text" class="form-control" id="building_name" name="building_name" required>
                        </div>
                        <div class="mb-3">
                            <label for="letak_gedung_lantai" class="form-label">Letak Gedung di Lantai Berapa</label>
                            <input type="number" class="form-control" id="letak_gedung_lantai"
                                name="letak_gedung_lantai" required>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    <button type="button" class="btn btn-primary" id="submitAddGedung">Tambah Gedung</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Detail Aset Modal -->
    <div class="modal fade" id="detailAsetModal" tabindex="-1" aria-labelledby="detailAsetModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="detailAsetModalLabel">Detail Aset Gedung</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div id="assetList">
                        <!-- Asset details will be loaded here via AJAX -->
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script>
        $(document).ready(function () {
            // Submit form to add a new building
            $('#submitAddGedung').click(function () {
                var buildingName = $('#building_name').val().trim();
                var letakGedungLantai = $('#letak_gedung_lantai').val().trim();

                // Validate fields
                if (buildingName === '' || letakGedungLantai === '') {
                    alert('Semua field harus diisi!');
                    return;
                }

                // AJAX request to add_gedung.php
                $.ajax({
                    url: '../gedung/gedung_aksi.php',
                    type: 'POST',
                    data: {
                        building_name: buildingName,
                        letak_gedung_lantai: letakGedungLantai
                    },
                    dataType: 'json',
                    success: function (response) {
                        if (response.status === 'success') {
                            // Success: Close the modal, clear the form, and update the table dynamically
                            $('#addGedungModal').modal('hide');
                            $('#addGedungForm')[0].reset();

                            // Append the new building to the table without reloading
                            var newRow = `<tr>
                        <td>${response.new_building_id}</td>
                        <td>${response.building_name}</td>
                        <td>${response.letak_gedung_lantai}</td>
                        <td>
                            <button class='btn btn-primary btn-sm btn-action view-assets' data-id='${response.new_building_id}'>Detail</button>
                            <button class='btn btn-danger btn-sm btn-action delete-gedung' data-id='${response.new_building_id}'>Hapus</button>
                        </td>
                    </tr>`;
                            $('table tbody').append(newRow);
                        } else {
                            alert('Error: ' + response.message);
                        }
                    },
                    error: function () {
                        alert('Error adding building.');
                    }
                });
            });

            // Event delegation to handle dynamic elements for viewing building assets
            $(document).on('click', '.view-assets', function () {
                var buildingId = $(this).data('id');

                // AJAX request to fetch building details
                $.ajax({
                    url: '../gedung/view_detail_gedung.php', // Pastikan file ini ada
                    type: 'GET',
                    data: { id: buildingId },
                    dataType: 'html',
                    success: function (response) {
                        // Display the asset details in the modal
                        $('#assetList').html(response);
                        $('#detailAsetModal').modal('show'); // Open the modal
                    },
                    error: function () {
                        alert('Error fetching asset details.');
                    }
                });
            });
        });

        $(document).on('click', '.delete-gedung', function () {
    var buildingId = $(this).data('id');

    if (confirm('Apakah Anda yakin ingin menghapus gedung ini?')) {
        // AJAX request to delete the building
        $.ajax({
            url: '../gedung/delete_gedung.php', // File PHP untuk menghapus gedung
            type: 'POST',
            data: { id: buildingId },
            dataType: 'json',
            success: function (response) {
                if (response.status === 'success') {
                    // Success: Remove the building row from the table
                    $('button[data-id="' + buildingId + '"]').closest('tr').remove();
                    alert('Gedung berhasil dihapus.');
                } else {
                    alert('Error: ' + response.message);
                }
            },
            error: function () {
                alert('Error deleting building.');
            }
        });
    }
});


    </script>
</body>

</html>