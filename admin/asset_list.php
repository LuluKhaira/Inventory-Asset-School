<?php
// Sertakan koneksi database
include '../config/connect.php';

// Sertakan query aset dan gedung
include '../config/list_gedungasset.php';

// Sertakan handler untuk form
include '../config/tambah_riwayat.php';
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Aset - Sistem Manajemen Aset</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="../config/all.css">
</head>

<body class="bg-light">
    <!-- Navbar -->
    <?php include '../navbar/nav_admin.php'; ?>

    <div class="container my-5">
        <h1 class="text-center mb-4">Daftar Aset</h1>

        <div class="mb-4 text-end">
            <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addAssetModal">Tambah Aset
                Baru</button>
        </div>

        <table class="table table-striped">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Nama Aset</th>
                    <th>Gedung</th>
                    <th>Jumlah</th>
                    <th>Kondisi</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $nomor = 1; // Variabel untuk nomor urut
                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<tr>";
                        echo "<td>" . $nomor++ . "</td>"; // Menampilkan nomor urut bertambah
                        echo "<td>" . htmlspecialchars($row['nama']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['building_name']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['jumlah']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['asset_condition']) . "</td>";
                        echo "<td>
                    <button class='btn btn-primary btn-sm edit-asset' data-bs-toggle='modal' data-bs-target='#editAssetModal' data-id='" . $row['id'] . "'>Edit</button>
                    <a href='delete_asset.php:?id=" . $row['id'] . "' class='btn btn-danger btn-sm' onclick='return confirm(\"Apakah Anda yakin ingin menghapus aset ini?\")'>Hapus</a>
                    <button class='btn btn-info btn-sm' data-bs-toggle='modal' data-bs-target='#tambahRiwayatModal' data-id='" . $row['id'] . "'>Tambah Riwayat</button>
                    <button class='btn btn-info btn-sm btn-action' data-bs-toggle='modal' data-bs-target='#viewHistoryModal' data-id='" . $row['id'] . "'>Lihat Riwayat Pengguna</button>
                </td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='5' class='text-center'>Tidak ada aset yang ditemukan.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

    <!-- Modal Tambah Riwayat Pengguna -->
    <div class="modal fade" id="tambahRiwayatModal" tabindex="-1" aria-hidden="true"
        aria-labelledby="tambahRiwayatModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="tambahRiwayatModalLabel">Tambah Riwayat Pengguna</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="formTambahRiwayat">
                        <input type="hidden" id="asset_id" name="asset_id">
                        <div class="mb-3">
                            <label for="user_name" class="form-label">Nama Pengguna</label>
                            <input type="text" class="form-control" id="user_name" name="user_name" required>
                        </div>
                        <div class="mb-3">
                            <label for="start_date" class="form-label">Tanggal Mulai</label>
                            <input type="date" class="form-control" id="start_date" name="start_date" required>
                        </div>
                        <div class="mb-3">
                            <label for="end_date" class="form-label">Tanggal Akhir</label>
                            <input type="date" class="form-control" id="end_date" name="end_date" required>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    <button type="button" class="btn btn-primary" id="submitTambahRiwayat">Simpan Riwayat</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Tambah Aset -->
    <div class="modal fade" id="addAssetModal" tabindex="-1" aria-labelledby="addAssetModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addAssetModalLabel">Tambah Aset Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <!-- Form untuk menambah aset -->
                <form id="addAssetForm" method="POST" action="../asset/tambah_asset.php">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="nama" class="form-label">Nama Aset</label>
                            <input type="text" class="form-control" id="nama" name="nama" required>
                        </div>
                        <div class="mb-3">
                            <label for="building" class="form-label">Gedung</label>
                            <select class="form-select" id="building" name="building" required>
                                <option value="">Pilih Gedung</option>
                                <?php
                                if (mysqli_num_rows($buildingResult) > 0) {
                                    while ($buildingRow = mysqli_fetch_assoc($buildingResult)) {
                                        echo "<option value='" . $buildingRow['id'] . "'>" . htmlspecialchars($buildingRow['building_name']) . "</option>";
                                    }
                                } else {
                                    echo "<option value=''>Tidak ada gedung tersedia</option>";
                                }
                                ?>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="jumlah" class="form-label">Jumlah Assets</label>
                            <input type="number" class="form-control" id="jumlah" name="jumlah"
                                value="<?php echo $jumlah; ?>" required>
                        </div>

                        <div class="mb-3">
                            <label for="asset_condition" class="form-label">Kondisi</label>
                            <select class="form-control" id="asset_condition" name="asset_condition" required>
                                <option value="Aktif">Aktif</option>
                                <option value="Tidak Aktif">Tidak Aktif</option>
                                <option value="Perbaikan">Perbaikan</option>
                                <option value="Rusak">Rusak</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                        <!-- Tombol submit untuk mengirim form -->
                        <button type="submit" class="btn btn-primary">Tambah Aset</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- New modal for viewing user history -->
    <div class="modal fade" id="viewHistoryModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Riwayat Pengguna</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="table-responsive">
                        <table class="table table-hover" id="historyTable">
                            <thead>
                                <tr>
                                    <th>Pengguna</th>
                                    <th>Mulai</th>
                                    <th>Akhir</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($history)): ?>
                                    <?php foreach ($history as $record): ?>
                                        <tr>
                                            <td><?php echo htmlspecialchars($record['user']); ?></td>
                                            <td><?php echo htmlspecialchars($record['usage_date']); ?></td>
                                            <td><?php echo htmlspecialchars($record['end_date']); ?></td>
                                            <td>
                                                <button class="btn btn-primary btn-sm" data-bs-toggle="modal"
                                                    data-bs-target="#editHistoryModal-<?php echo $record['idPrimary']; ?>">Edit</button>
                                                <button class="btn btn-danger btn-sm" data-bs-toggle="modal"
                                                    data-bs-target="#deleteHistoryModal"
                                                    onclick="setDeleteHistoryId(<?php echo $record['idPrimary']; ?>)">Hapus</button>
                                            </td>

                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="4" class="text-center">Belum ada riwayat penggunaan.</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit History Modal -->
    <div class="modal fade" id="editHistoryModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit User History</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="editHistoryForm">
                    <div class="modal-body">
                        <input type="hidden" id="edit_history_id" name="history_id">
                        <div class="mb-3">
                            <label for="edit_user_name" class="form-label">User Name</label>
                            <input type="text" class="form-control" id="edit_user_name" name="user_name" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit_start_date" class="form-label">Start Date</label>
                            <input type="date" class="form-control" id="edit_start_date" name="start_date" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit_end_date" class="form-label">End Date</label>
                            <input type="date" class="form-control" id="edit_end_date" name="end_date" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Edit Aset -->
    <div class="modal fade" id="editAssetModal" tabindex="-1" aria-labelledby="editAssetModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editAssetModalLabel">Edit Aset</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="editAssetForm" method="POST">
                    <div class="modal-body">
                        <input type="hidden" id="edit_id" name="id">
                        <div class="mb-3">
                            <label for="edit_name" class="form-label">Nama Aset</label>
                            <input type="text" class="form-control" id="edit_name" name="nama" required>
                        </div>

                        <div class="mb-3">
                            <label for="edit_building" class="form-label">Gedung</label>
                            <select class="form-select" id="edit_building" name="building" required>
                                <option value="">Pilih Gedung</option>
                                <?php
                                $buildingQuery = "SELECT id, building_name FROM buildings ORDER BY building_name";
                                $buildingResult = mysqli_query($conn, $buildingQuery);
                                while ($buildingRow = mysqli_fetch_assoc($buildingResult)) {
                                    echo "<option value='" . $buildingRow['id'] . "'>" . htmlspecialchars($buildingRow['building_name']) . "</option>";
                                }
                                ?>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="letak_gedung_lantai" class="form-label">Jumlah Assets</label>
                            <input type="number" class="form-control" id="jumlah" name="jumlah" required>
                        </div>

                        <div class="mb-3">
                            <label for="asset_condition" class="form-label">Kondisi</label>
                            <select class="form-control" id="asset_condition" name="asset_condition" required>
                                <option value="Aktif">Aktif</option>
                                <option value="Tidak Aktif">Tidak Aktif</option>
                                <option value="Perbaikan">Perbaikan</option>
                                <option value="Rusak">Rusak</option>
                            </select>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                        <button type="button" class="btn btn-primary" id="submitEditAsset">Perbarui Aset</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function () {
            // Add Asset
            $('#submitAddAsset').click(function () {
                var formData = $('#addAssetForm').serialize();
                $.ajax({
                    url: 'add_asset.php',
                    type: 'POST',
                    data: formData,
                    success: function (response) {
                        alert(response);
                        location.reload();
                    },
                    error: function () {
                        alert('Error adding asset');
                    }
                });
            });

            // Edit Asset
            $(document).on('click', '.edit-asset', function () {
                var id = $(this).data('id');
                $.ajax({
                    url: '../asset/edit_asset.php',
                    type: 'GET',
                    data: {
                        id: id
                    },
                    success: function (data) {
                        var asset = JSON.parse(data);
                        $('#edit_id').val(asset.id);
                        $('#edit_name').val(asset.nama);  // Nama di JSON harus benar, pastikan nama field dari database juga benar.
                        $('#edit_building').val(asset.building);
                        $('#edit_jumlah').val(asset.jumlah);
                        $('#edit_condition').val(asset.asset_condition);

                    },
                    error: function () {
                        alert('Error fetching asset details');
                    }
                });
            });

            $('#submitEditAsset').click(function () {
                var formData = $('#editAssetForm').serialize();
                $.ajax({
                    url: '../asset/edit_up_asset.php',
                    type: 'POST',
                    data: formData,
                    success: function (response) {
                        alert(response);
                        location.reload();
                    },
                    error: function () {
                        alert('Error updating asset');
                    }
                });
            });

            $(document).on('click', '.btn-info[data-bs-target="#tambahRiwayatModal"]', function () {
                const assetId = $(this).data('id');
                $('#asset_id').val(assetId); // Set asset_id ke input hidden
            });

            // Add History
            $('#submitTambahRiwayat').click(function () {
                var formData = $('#formTambahRiwayat').serialize();

                $.ajax({
                    url: '../riwayat/tambah_riwayat.php',
                    type: 'POST',
                    data: formData,
                    dataType: 'json',
                    success: function (response) {
                        if (response.success) {
                            alert('Riwayat berhasil ditambahkan.');

                            // Sembunyikan modal tambah riwayat
                            $('#tambahRiwayatModal').modal('hide');

                            // Tunggu sampai modal benar-benar tersembunyi sebelum menampilkan modal berikutnya
                            $('#tambahRiwayatModal').on('hidden.bs.modal', function () {
                                // Update tabel riwayat dengan data terbaru
                                updateHistoryTable(response.history);

                                // Tampilkan modal untuk melihat riwayat yang sudah ditambahkan
                                $('#viewHistoryModal').modal('show');
                            });
                        } else {
                            alert('Gagal menambahkan riwayat: ' + (response.error || 'Unknown error'));
                        }
                    },
                    error: function () {
                        alert('Terjadi kesalahan saat menambahkan riwayat.');
                    }


                });
            });

            // View History
            // Function to load asset history
            function loadAssetHistory(assetId) {
                $.ajax({
                    url: '../riwayat/lihat_history.php',
                    type: 'GET',
                    data: {
                        asset_id: assetId
                    },
                    dataType: 'json',
                    success: function (response) {
                        updateHistoryTable(response);
                    },
                    error: function () {
                        alert('Failed to retrieve asset history.');
                    }
                });
            }

            // Function to update the history table
            function updateHistoryTable(history) {
                var tableBody = $('#historyTable tbody');
                tableBody.empty();
                if (Array.isArray(history) && history.length > 0) {
                    $.each(history, function (index, record) {
                        var row = `<tr>
                <td>${escapeHtml(record.user)}</td>
                <td>${escapeHtml(record.usage_date)}</td>
                <td>${escapeHtml(record.end_date)}</td>
                <td>
                    <button class="btn btn-primary btn-sm edit-history" 
                        data-id="${record.id}" 
                        data-user="${escapeHtml(record.user)}" 
                        data-start-date="${record.usage_date}" 
                        data-end-date="${record.end_date}">Edit</button>
                    <button class="btn btn-danger btn-sm delete-history" 
                        data-id="${record.id}">Delete</button>
                </td>
            </tr>`;
                        tableBody.append(row);
                    });
                } else {
                    tableBody.append('<tr><td colspan="4" class="text-center">No usage history available.</td></tr>');
                }

                // Reattach event listeners
                attachHistoryEventListeners();
            }

            // Function to attach event listeners for edit and delete buttons
            function attachHistoryEventListeners() {
                $('.edit-history').click(function () {
                    var id = $(this).data('id');
                    var user = $(this).data('user');
                    var startDate = $(this).data('start-date');
                    var endDate = $(this).data('end-date');

                    $('#edit_history_id').val(id);
                    $('#edit_user_name').val(user);
                    $('#edit_start_date').val(startDate);
                    $('#edit_end_date').val(endDate);

                    $('#editHistoryModal').modal('show');
                });

                $('.delete-history').click(function () {
                    var id = $(this).data('id');
                    if (confirm('Are you sure you want to delete this history record?')) {
                        deleteHistory(id);
                    }
                });
            }

            // Function to delete history
            function deleteHistory(id) {
                $.ajax({
                    url: '../asset/hapus_riwayat.php',
                    type: 'POST',
                    data: {
                        history_id: id
                    },
                    dataType: 'json',
                    success: function (response) {
                        if (response.success) {
                            alert('History record deleted successfully.');
                            loadAssetHistory($('#asset_id').val());
                        } else {
                            alert('Error: ' + response.message);
                        }
                    },
                    error: function () {
                        alert('Error deleting history record');
                    }
                });
            }

            // Event listener for edit history form submission
            $('#editHistoryForm').submit(function (e) {
                e.preventDefault();
                $.ajax({
                    url: '../asset/tambah_riwayat.php',
                    type: 'POST',
                    data: $(this).serialize(),
                    dataType: 'json',
                    success: function (response) {
                        if (response.success) {
                            $('#editHistoryModal').modal('hide');
                            alert('History updated successfully.');
                            loadAssetHistory($('#asset_id').val());
                        } else {
                            alert('Error: ' + response.message);
                        }
                    },
                    error: function () {
                        alert('Error updating history');
                    }
                });
            });

            // Helper function to escape HTML
            function escapeHtml(unsafe) {
                return unsafe
                    .replace(/&/g, "&amp;")
                    .replace(/</g, "&lt;")
                    .replace(/>/g, "&gt;")
                    .replace(/"/g, "&quot;")
                    .replace(/'/g, "&#039;");
            }

            // Initialize event listeners when document is ready
            $(document).ready(function () {
                // Existing code for adding assets and viewing history...

                // View History
                $('.btn-action[data-bs-target="#viewHistoryModal"]').click(function () {
                    var assetId = $(this).data('id');
                    $('#asset_id').val(assetId);
                    loadAssetHistory(assetId);
                });
            });
        });
    </script>
</body>

</html>