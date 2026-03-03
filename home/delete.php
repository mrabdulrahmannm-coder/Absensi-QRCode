<?php
include("../koneksi.php");

if (!isset($_GET['id'])) {
    header("Location: absen.php");
    exit();
}

$id = $_GET['id'];

// Ambil foto dulu (pakai prepared statement)
$stmt = $koneksi->prepare("SELECT foto FROM siswa WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$siswa = $result->fetch_assoc();
$stmt->close();

if ($siswa) {

    // Hapus foto dari folder
    $foto_path = "uploads/" . $siswa['foto'];
    if (!empty($siswa['foto']) && file_exists($foto_path)) {
        unlink($foto_path);
    }

    // Hapus data dari database
    $stmt = $koneksi->prepare("DELETE FROM siswa WHERE id = ?");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        $success = true;
    } else {
        $error = $stmt->error;
    }

    $stmt->close();
} else {
    $error = "Data tidak ditemukan.";
}

$koneksi->close();
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Hapus Data</title>

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
    text-align: center;
}
</style>
</head>

<body>

<div class="container mt-5 col-md-6">
    <div class="glass">

        <?php if (isset($success)) { ?>
            <h3>✅ Data Berhasil Dihapus</h3>
            <p>Kartu pelajar siswa telah dihapus dari sistem.</p>

            <script>
                setTimeout(function(){
                    window.location.href = "absen.php";
                }, 2000);
            </script>

        <?php } else { ?>
            <h3>❌ Terjadi Kesalahan</h3>
            <p><?= $error ?? "Terjadi kesalahan." ?></p>

            <a href="absen.php" class="btn btn-light mt-3">
                Kembali
            </a>
        <?php } ?>

    </div>
</div>

</body>
</html>