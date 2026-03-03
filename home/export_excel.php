<?php
include("../koneksi.php"); // Include koneksi ke database

header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment; filename="data_siswa.xls"');

$search = isset($_GET['search']) ? mysqli_real_escape_string($koneksi, $_GET['search']) : '';

// Query untuk mengambil data siswa dari database dengan pencarian
$sql = "SELECT * FROM siswa WHERE 1=1";

if (!empty($search)) {
    $sql .= " AND (nama LIKE '%$search%' OR nis LIKE '%$search%' OR kelas LIKE '%$search%')";
}

$result = $koneksi->query($sql);

if ($result->num_rows > 0) {
    // Mencetak header tabel
    echo "No\tNama\tNIS\tKelas\tTgl Buat\n";

    $no = 1;
    // Mencetak data siswa
    while ($row = $result->fetch_assoc()) {
        echo $no++ . "\t";
        echo ucwords($row['nama']) . "\t";
        echo $row['nis'] . "\t";
        echo strtoupper($row['kelas']) . "\t";
        echo date('d-m-Y', strtotime($row['created_at'])) . "\n";
    }
} else {
    echo "Tidak ada data siswa.";
}

$koneksi->close();
exit();
?>
