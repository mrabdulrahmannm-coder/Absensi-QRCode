<?php
include("../koneksi.php");
session_start();

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("ID tidak valid.");
}

$id_siswa = $_GET['id'];

$stmt = $koneksi->prepare("SELECT * FROM siswa WHERE id = ?");
$stmt->bind_param("i", $id_siswa);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    die("Data siswa tidak ditemukan.");
}

$siswa = $result->fetch_assoc();
$stmt->close();
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Kartu Siswa</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/jsbarcode@3.11.6/dist/JsBarcode.all.min.js"></script>

<style>
body {
    background: linear-gradient(135deg, #667eea, #764ba2);
    font-family: 'Segoe UI', sans-serif;
}

.kartu-wrapper {
    display: flex;
    justify-content: center;
    gap: 20px;
    margin-top: 40px;
    flex-wrap: wrap;
}

.kartu {
    width: 3in;
    height: 5in;
    border-radius: 20px;
    overflow: hidden;
    box-shadow: 0 8px 30px rgba(0,0,0,0.3);
    position: relative;
    color: white;
    padding: 20px;
}

.front {
    background: linear-gradient(160deg, #1e3c72, #2a5298);
}

.back {
    background: linear-gradient(160deg, #232526, #414345);
}

.logo-title {
    display: flex;
    align-items: center;
    font-weight: bold;
    font-size: 14px;
}

.logo-title img {
    width: 25px;
    margin-right: 8px;
}

.foto-siswa {
    width: 160px;
    height: 160px;
    object-fit: cover;
    border-radius: 50%;
    border: 4px solid #ffd700;
    margin: 15px auto;
    display: block;
}

.nama {
    font-size: 20px;
    font-weight: bold;
}

.kelas {
    font-size: 14px;
    letter-spacing: 1px;
}

.barcode {
    margin-top: 15px;
    text-align: center;
}

@media print {
    body {
        background: white;
    }
    .btn-area {
        display: none;
    }
}
</style>
</head>

<body>

<div class="kartu-wrapper">

    <!-- FRONT CARD -->
    <div class="kartu front text-center">

        <div class="logo-title">
            <img src="logo/1.png">
            SMKN 7 BATAM
        </div>

        <img src="uploads/<?php echo htmlspecialchars($siswa['foto']); ?>" 
             class="foto-siswa">

        <div class="nama">
            <?php echo ucwords(htmlspecialchars($siswa['nama'])); ?>
        </div>

        <div class="kelas">
            <?php echo strtoupper(htmlspecialchars($siswa['kelas'])); ?>
        </div>

        <div class="barcode">
            <svg id="barcode"></svg>
        </div>

    </div>

    <!-- BACK CARD -->
    <div class="kartu back text-center d-flex flex-column justify-content-center">
        <h5>INFORMASI SISWA</h5>
        <hr>
        <p><strong>NIS:</strong> <?php echo htmlspecialchars($siswa['nis']); ?></p>
        <p><strong>TTL:</strong> <?php echo htmlspecialchars($siswa['ttl']); ?></p>
        <p><strong>Jenis Kelamin:</strong> <?php echo htmlspecialchars($siswa['jenis_kelamin']); ?></p>
        <p><strong>Alamat:</strong> <?php echo htmlspecialchars($siswa['alamat']); ?></p>
    </div>

</div>

<div class="text-center mt-4 btn-area">
    <button onclick="window.print();" class="btn btn-primary">Print Kartu</button>
    <a href="absen.php" class="btn btn-secondary">Kembali</a>
</div>

<script>
JsBarcode("#barcode", "<?php echo $siswa['nis']; ?>", {
    format: "CODE39",
    displayValue: false,
    width: 2,
    height: 40,
    lineColor: "#ffffff",
    background: "transparent"
});
</script>

</body>
</html>