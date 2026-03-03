<?php
include("header.php");
include("../koneksi.php"); // Pastikan koneksi ke database

// Inisialisasi variabel dengan nilai kosong
$nama = $nis = $kelas = $ttl = $jenis_kelamin = $alamat = $agama = $nama_ayah = $nama_ibu = "";
$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ambil data dari form dan lakukan sanitasi
    $nama = mysqli_real_escape_string($koneksi, $_POST['nama']);
    $nis = mysqli_real_escape_string($koneksi, $_POST['nis']);
    $kelas = mysqli_real_escape_string($koneksi, $_POST['kelas']);
    $ttl = mysqli_real_escape_string($koneksi, $_POST['ttl']);
    $jenis_kelamin = mysqli_real_escape_string($koneksi, $_POST['jenis_kelamin']);
    $alamat = mysqli_real_escape_string($koneksi, $_POST['alamat']);
    $agama = mysqli_real_escape_string($koneksi, $_POST['agama']); // Ambil agama
    $nama_ayah = mysqli_real_escape_string($koneksi, $_POST['nama_ayah']); // Ambil nama ayah
    $nama_ibu = mysqli_real_escape_string($koneksi, $_POST['nama_ibu']); // Ambil nama ibu
    $created_at = date('Y-m-d H:i:s');

    // Validasi NIS hanya berisi angka
    if (!ctype_digit($nis)) {
        $message = "NIS hanya boleh berisi angka.";
    } else {
        // Proses upload foto
        $foto = $_FILES['foto']['name'];
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($foto);
        $uploadOk = true;

        // Validasi upload file
        if ($_FILES['foto']['size'] > 500000) { // Contoh: maksimum 500KB
            $message = "Ukuran file foto terlalu besar.";
            $uploadOk = false;
        }

        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        $allowed_types = ['jpg', 'jpeg', 'png', 'gif'];
        if (!in_array($imageFileType, $allowed_types)) {
            $message = "Hanya file JPG, JPEG, PNG, dan GIF yang diperbolehkan.";
            $uploadOk = false;
        }

        if ($uploadOk && move_uploaded_file($_FILES['foto']['tmp_name'], $target_file)) {
            // Jika file berhasil diupload, simpan data ke database
            $sql = "INSERT INTO siswa (nama, nis, kelas, ttl, jenis_kelamin, alamat, foto, agama, nama_ayah, nama_ibu, created_at) 
                    VALUES ('$nama', '$nis', '$kelas', '$ttl', '$jenis_kelamin', '$alamat', '$foto', '$agama', '$nama_ayah', '$nama_ibu', '$created_at')";
            if (mysqli_query($koneksi, $sql)) {
                header("Location: absen.php");
                exit();
            } else {
                $message = "Error: " . mysqli_error($koneksi);
            }
        } else {
            if (empty($message)) {
                $message = "Gagal mengupload foto.";
            }
        }
    }
}
?>


<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Input Data Siswa</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

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

.form-control, .form-select {
    border-radius: 12px;
}

.btn-modern {
    border-radius: 12px;
    font-weight: bold;
    padding: 10px 25px;
}

label {
    font-weight: 500;
}
</style>
</head>

<body>

<div class="container mt-5 col-md-8">
    <div class="glass">

        <h2 class="mb-4 text-center">
            <i class="fas fa-user-plus"></i> Input Data Siswa
        </h2>

        <?php if (!empty($message)) { ?>
            <div class="alert alert-warning text-dark">
                <?= $message; ?>
            </div>
        <?php } ?>

        <form method="POST" enctype="multipart/form-data">

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label>Nama Siswa</label>
                    <input type="text" name="nama" class="form-control"
                        value="<?= htmlspecialchars($nama); ?>" required>
                </div>

                <div class="col-md-6 mb-3">
                    <label>Jurusan</label>
                    <input type="text" name="kelas" class="form-control"
                        value="<?= htmlspecialchars($kelas); ?>" required>
                </div>
            </div>

            <div class="mb-3">
                <label>NIS</label>
                <input type="number" name="nis" class="form-control"
                    value="<?= htmlspecialchars($nis); ?>" required>
            </div>

            <div class="mb-3">
                <label>Tempat, Tanggal Lahir</label>
                <input type="text" name="ttl" class="form-control"
                    value="<?= htmlspecialchars($ttl); ?>" required>
            </div>

            <div class="mb-3">
                <label>Jenis Kelamin</label>
                <select name="jenis_kelamin" class="form-select" required>
                    <option value="">Pilih</option>
                    <option value="Laki-laki" <?= $jenis_kelamin == "Laki-laki" ? "selected" : ""; ?>>Laki-laki</option>
                    <option value="Perempuan" <?= $jenis_kelamin == "Perempuan" ? "selected" : ""; ?>>Perempuan</option>
                </select>
            </div>

            <div class="mb-3">
                <label>Alamat</label>
                <textarea name="alamat" class="form-control" required><?= htmlspecialchars($alamat); ?></textarea>
            </div>

            <div class="mb-3">
                <label>Agama</label>
                <select name="agama" class="form-select" required>
                    <option value="">Pilih Agama</option>
                    <option value="Islam" <?= $agama == "Islam" ? "selected" : ""; ?>>Islam</option>
                    <option value="Kristen" <?= $agama == "Kristen" ? "selected" : ""; ?>>Kristen</option>
                    <option value="Katolik" <?= $agama == "Katolik" ? "selected" : ""; ?>>Katolik</option>
                    <option value="Hindu" <?= $agama == "Hindu" ? "selected" : ""; ?>>Hindu</option>
                    <option value="Buddha" <?= $agama == "Buddha" ? "selected" : ""; ?>>Buddha</option>
                    <option value="Konghucu" <?= $agama == "Konghucu" ? "selected" : ""; ?>>Konghucu</option>
                </select>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label>Nama Ayah</label>
                    <input type="text" name="nama_ayah" class="form-control"
                        value="<?= htmlspecialchars($nama_ayah); ?>" required>
                </div>

                <div class="col-md-6 mb-3">
                    <label>Nama Ibu</label>
                    <input type="text" name="nama_ibu" class="form-control"
                        value="<?= htmlspecialchars($nama_ibu); ?>" required>
                </div>
            </div>

            <div class="mb-4">
                <label>Foto Siswa</label>
                <input type="file" name="foto" class="form-control" required>
            </div>

            <div class="text-center">
                <button type="submit" class="btn btn-light btn-modern">
                    <i class="fas fa-save"></i> Simpan
                </button>

                <a href="home.php" class="btn btn-dark btn-modern ms-2">
                    Kembali
                </a>
            </div>

        </form>
    </div>
</div>

</body>
</html>