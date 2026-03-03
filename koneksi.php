<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "absensi_qr";

// Membuat koneksi
$koneksi = new mysqli($servername, $username, $password, $dbname);

// Mengecek koneksi
if ($koneksi->connect_error) {
    die("Koneksi gagal: " . $koneksi->connect_error);
}
?>
