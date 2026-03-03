<?php
include("header.php");

$search = "";
$siswa_data = [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $search = $_POST['search'];
}

$sql = "SELECT * FROM siswa WHERE 1=1";
$params = [];
$types = "";

if (!empty($search)) {
    $sql .= " AND (nama LIKE ? OR nis LIKE ? OR kelas LIKE ?)";
    $searchParam = "%$search%";
    $params = [$searchParam, $searchParam, $searchParam];
    $types = "sss";
}

$stmt = $koneksi->prepare($sql);

if (!empty($params)) {
    $stmt->bind_param($types, ...$params);
}

$stmt->execute();
$result = $stmt->get_result();

while ($row = $result->fetch_assoc()) {
    $siswa_data[] = $row;
}

$stmt->close();
$no = 1;
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Daftar Siswa</title>

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
    padding: 30px;
    box-shadow: 0 8px 32px rgba(0,0,0,0.2);
    color: white;
}

.table {
    background: white;
    border-radius: 15px;
    overflow: hidden;
}

.btn-custom {
    border-radius: 12px;
}
</style>
</head>

<body>

<div class="container mt-5 col-md-10">
    <div class="glass">

        <h2 class="mb-4 text-center">Daftar Siswa</h2>

        <form method="POST" class="row mb-4">
            <div class="col-md-8">
                <input type="text" name="search" class="form-control"
                       placeholder="Cari nama, NIS, atau kelas"
                       value="<?= htmlspecialchars($search) ?>">
            </div>
            <div class="col-md-4">
                <button type="submit" class="btn btn-light w-100 btn-custom">
                    Cari Siswa
                </button>
            </div>
        </form>

        <div class="mb-3 d-flex justify-content-between">
            <a href="ip-siswa.php" class="btn btn-dark btn-custom">+ Tambah Siswa</a>
            <a href="export_excel.php?search=<?= urlencode($search); ?>" 
               class="btn btn-success btn-custom">Download Excel</a>
        </div>

        <div class="table-responsive">
            <table class="table table-bordered text-center">
                <thead class="table-dark">
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>NIS</th>
                        <th>Kelas</th>
                        <th>Tanggal Dibuat</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>

                <?php if (count($siswa_data) > 0): ?>
                    <?php foreach ($siswa_data as $siswa): ?>
                        <tr>
                            <td><?= $no++; ?></td>
                            <td><?= htmlspecialchars($siswa['nama']); ?></td>
                            <td><?= htmlspecialchars($siswa['nis']); ?></td>
                            <td><?= htmlspecialchars($siswa['kelas']); ?></td>
                            <td><?= date('d-m-Y H:i', strtotime($siswa['created_at'])); ?></td>
                            <td>
                                <a href="tmpl.php?id=<?= $siswa['id']; ?>" class="btn btn-primary btn-sm">Kartu</a>
                                <a href="edit.php?id=<?= $siswa['id']; ?>" class="btn btn-warning btn-sm">Edit</a>
                                <a href="delete.php?id=<?= $siswa['id']; ?>" 
                                   class="btn btn-danger btn-sm"
                                   onclick="return confirm('Yakin hapus data?')">
                                   Hapus
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6">Data siswa tidak ditemukan.</td>
                    </tr>
                <?php endif; ?>

                </tbody>
            </table>
        </div>

    </div>
</div>

</body>
</html>