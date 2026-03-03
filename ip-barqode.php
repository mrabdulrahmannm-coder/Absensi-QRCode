<?php
include("koneksi.php");
session_start();

// Proteksi halaman (wajib login)
if (!isset($_SESSION['status']) || $_SESSION['status'] != "login") {
    header("Location: index.php?pesan=belum_login");
    exit();
}

$siswa = null;
$error = null;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nis = trim($_POST['nis']);

    if (!empty($nis)) {
        $stmt = $koneksi->prepare("SELECT * FROM siswa WHERE nis = ?");
        $stmt->bind_param("s", $nis);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $siswa = $result->fetch_assoc();
        } else {
            $error = "Data siswa tidak ditemukan.";
        }
        $stmt->close();
    } else {
        $error = "NIS tidak boleh kosong.";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Scan Barcode Siswa</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
body {
    background: linear-gradient(135deg, #667eea, #764ba2);
    min-height: 100vh;
    font-family: 'Segoe UI', sans-serif;
    padding-top: 40px;
}

.glass {
    background: rgba(255,255,255,0.15);
    backdrop-filter: blur(15px);
    border-radius: 20px;
    padding: 30px;
    box-shadow: 0 8px 32px rgba(0,0,0,0.2);
    color: white;
}

.form-control {
    border-radius: 12px;
    padding: 12px;
}

.btn-custom {
    background: white;
    color: #764ba2;
    font-weight: bold;
    border-radius: 12px;
}

.profile-card {
    background: rgba(255,255,255,0.2);
    border-radius: 20px;
    padding: 20px;
    margin-top: 30px;
}

.profile-img {
    width: 150px;
    border-radius: 15px;
    object-fit: cover;
}
</style>
</head>

<body>

<div class="container col-md-6">
    <div class="glass">

        <h3 class="text-center mb-4">Scan Barcode Siswa</h3>

        <form method="POST">
            <div class="mb-3">
                <input type="text" name="nis" id="nis" class="form-control"
                       placeholder="Scan / Masukkan NIS"
                       autofocus required>
            </div>

            <button type="submit" class="btn btn-custom w-100 mb-2">
                Cari Siswa
            </button>

            <a href="home/logout.php" class="btn btn-danger w-100">
                Logout
            </a>
        </form>

        <?php if ($siswa): ?>
            <div class="profile-card text-center">

                <img src="home/uploads/<?php echo htmlspecialchars($siswa['foto']); ?>"
                     class="profile-img mb-3">

                <h4><?php echo htmlspecialchars($siswa['nama']); ?></h4>
                <hr style="color:white;">

                <p><strong>NIS:</strong> <?php echo htmlspecialchars($siswa['nis']); ?></p>
                <p><strong>Kelas:</strong> <?php echo htmlspecialchars($siswa['kelas']); ?></p>
                <p><strong>TTL:</strong> <?php echo htmlspecialchars($siswa['ttl']); ?></p>
                <p><strong>Jenis Kelamin:</strong> <?php echo htmlspecialchars($siswa['jenis_kelamin']); ?></p>
                <p><strong>Alamat:</strong> <?php echo htmlspecialchars($siswa['alamat']); ?></p>

            </div>

        <?php elseif ($error): ?>

            <div class="alert alert-danger mt-4 text-center">
                <?php echo htmlspecialchars($error); ?>
            </div>

        <?php endif; ?>

    </div>
</div>

<script>
document.getElementById("nis").focus();
</script>

</body>
</html>