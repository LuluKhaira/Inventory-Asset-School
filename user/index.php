<?php
include '../config/connect.php';

// Query untuk menghitung jumlah gedung
$sql = "SELECT COUNT(*) AS totalGedung FROM buildings";
$result = $conn->query($sql);

// Cek apakah query ada error
if ($result === false) {
    echo "<script>console.log('Error di query gedung: " . $conn->error . "');</script>";
} else if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $totalGedung = $row['totalGedung']; 
    echo "<script>console.log('Total Gedung dari Database: " . $totalGedung . "');</script>";
} else {
    echo "<script>console.log('Tidak ada gedung dalam database');</script>";
}

// Query untuk menghitung jumlah assets
$sql = "SELECT COUNT(*) AS totalAssets FROM assets";
$result = $conn->query($sql);

// Cek apakah query ada error
if ($result === false) {
    echo "<script>console.log('Error di query assets: " . $conn->error . "');</script>";
} else if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $totalAssets = $row['totalAssets']; 
    echo "<script>console.log('Total Assets dari Database: " . $totalAssets . "');</script>";
} else {
    echo "<script>console.log('Tidak ada asset dalam database');</script>";
}

$conn->close();  // Tutup koneksi

?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Asset Management System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../config/all.css">
</head>
<body>
    <?php
    include '../navbar/nav_user.php';
    ?>
    

    <div class="container mt-4 content-wrapper animate__animated animate__fadeIn">
        <h1 class="text-center mb-0 animate__animated animate__bounceInDown text-bold text-yellow shadow-text">Selamat Datang di Website Sarana Prasarana</h1>
        <h2 class="text-center mb-0 animate__animated animate__bounceInDown text-bold text-yellow shadow-text">SMK Negeri 7 Batam</h2>
        <div class="row mt-5">
            <div class="col-md-6 mb-4">
                <div class="card feature-card animate__animated animate__fadeInLeft">
                    <div class="card-body text-center">
                        <i class="fas fa-clipboard-list feature-icon"></i>
                        <h5 class="card-title text-bold">Management Asset</h5>
                        <p class="card-text">Mengelola asset sekolah dengan sistem modern.</p>
                        <a href="../user/asset_list.php" class="btn btn-custom mt-3 text-natural">Lihat detail</a>
                    </div>
                </div>
            </div>
            <div class="col-md-6 mb-4">
                <div class="card feature-card animate__animated animate__fadeInUp">
                    <div class="card-body text-center">
                        <i class="fas fa-chart-line feature-icon"></i>
                        <h5 class="card-title text-bold ">Management Lokasi</h5>
                        <p class="card-text">Mengetahui posisi letak Asset secara efisien.</p>
                        <a href="../user/home_gedung.php" class="btn btn-custom mt-3 text-natural">Lihat detail</a>
                    </div>
                </div>
            </div>

            <div class="stats-container animate__animated animate__fadeInUp">
                <div class="row">
                    <div class="col-md-6 stats-item">
                        <div class="stats-number" id="totalGedung"></div>
                        <script>
                            // PHP memasukkan nilai jumlah gedung ke dalam JavaScript
                            let totalGedung = <?php echo $totalGedung; ?>;
                            console.log("Total Gedung yang diterima oleh JavaScript: " + totalGedung);

                            // Menampilkan jumlah gedung di HTML
                            document.getElementById('totalGedung').textContent = totalGedung;
                        </script>
                        <div class="stats-label">Gedung</div>
                    </div>

                    <div class="col-md-6 stats-item">
                        <div class="stats-number" id="totalAssets"></div>
                        <script>
                            // PHP memasukkan nilai jumlah assets ke dalam JavaScript
                            let totalAssets = <?php echo $totalAssets; ?>;
                            console.log("Total Assets yang diterima oleh JavaScript: " + totalAssets);

                            // Menampilkan jumlah assets di HTML
                            document.getElementById('totalAssets').textContent = totalAssets;
                        </script>
                        <div class="stats-label">Asset</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script>
    $(document).ready(function() {
        function animateValue(id, start, end, duration) {
            let range = end - start;
            let current = start;
            let increment = end > start ? 1 : -1;
            let stepTime = Math.abs(Math.floor(duration / range));
            let obj = document.getElementById(id);
            let timer = setInterval(function() {
                current += increment;
                obj.innerHTML = current;
                if (current == end) {
                    clearInterval(timer);
                }
            }, stepTime);
        }

        animateValue("totalGedung", 0, <?php echo $totalGedung; ?>, 2000);

        let timer = setInterval(function() {
            totalValue += 10000;
            document.getElementById("totalValue").innerHTML = "Rp" + totalValue.toLocaleString();
            if (totalValue >= <?php echo $totalValue; ?>) {
                clearInterval(timer);
            }
        }, 20);
    });
</script>

</body>
</html>