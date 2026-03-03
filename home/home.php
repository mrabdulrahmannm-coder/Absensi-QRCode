<?php 
include("header.php");

// Hitung jumlah siswa
$stmt = $koneksi->prepare("SELECT COUNT(*) AS total_siswa FROM siswa");
$stmt->execute();
$result = $stmt->get_result();
$data = $result->fetch_assoc();
$total_siswa = $data['total_siswa'];
$stmt->close();
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Dashboard Absensi</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
body {
    background: linear-gradient(135deg, #667eea, #764ba2);
    min-height: 100vh;
    font-family: 'Segoe UI', sans-serif;
}

.glass {
    background: rgba(255,255,255,0.15);
    backdrop-filter: blur(15px);
    border-radius: 20px;
    padding: 40px;
    box-shadow: 0 8px 32px rgba(0,0,0,0.2);
    color: white;
}

.stat-card {
    background: rgba(255,255,255,0.25);
    border-radius: 20px;
    padding: 25px;
    text-align: center;
    transition: 0.3s;
}

.stat-card:hover {
    transform: translateY(-5px);
}

.btn-modern {
    border-radius: 12px;
    font-weight: bold;
}
</style>
</head>

<body>

<div class="container mt-5 col-md-8">
    <div class="glass text-center">

        <h2 class="mb-4">Dashboard Absensi Siswa</h2>
        <p class="mb-4">Kelola data siswa dan absensi dengan sistem yang cepat, aman, dan modern.</p>

        <div class="row mb-4">
            <div class="col-md-12">
                <div class="stat-card">
                    <h3><?= $total_siswa; ?></h3>
                    <p>Total Siswa Terdaftar</p>
                </div>
            </div>
        </div>

        <div class="d-flex justify-content-center gap-3 flex-wrap">

            <a href="ip-siswa.php" class="btn btn-light btn-modern px-4">
                + Tambah Siswa
            </a>

            <a href="absen.php" class="btn btn-dark btn-modern px-4">
                Lihat Data
            </a>

            <a href="ip-barqode.php" class="btn btn-success btn-modern px-4">
                Scan Barcode
            </a>

        </div>

    </div>
</div>

</body>
</html>

<?php
$koneksi->close();
?>