<?php
session_start();
include 'koneksi.php';

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $nama = $koneksi->real_escape_string($_POST['nama']);
    $username = $koneksi->real_escape_string($_POST['username']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    if ($password === $confirm_password) {

        // Lebih aman dari md5
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        $sql = "INSERT INTO login(nama, username, password) 
                VALUES ('$nama', '$username', '$hashed_password')";

        if ($koneksi->query($sql) === TRUE) {
            header("Location: index.php?pesan=sukses");
            exit();
        } else {
            $error = "Username sudah digunakan!";
        }
    } else {
        $error = "Password tidak cocok!";
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Register</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
body {
    background: linear-gradient(135deg, #667eea, #764ba2);
    height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;
    font-family: 'Segoe UI', sans-serif;
}

.card {
    border: none;
    border-radius: 20px;
    backdrop-filter: blur(15px);
    background: rgba(255, 255, 255, 0.15);
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
    transition: 0.3s;
}

.btn-custom:hover {
    background: #f1f1f1;
}
a {
    color: #fff;
    text-decoration: none;
}
a:hover {
    text-decoration: underline;
}
</style>
</head>
<body>

<div class="col-md-4">
    <div class="card p-4">
        <h3 class="text-center mb-4">Buat Akun</h3>

        <?php if(isset($error)) { ?>
            <div class="alert alert-danger text-center">
                <?= $error ?>
            </div>
        <?php } ?>

        <form method="post">
            <div class="mb-3">
                <input type="text" name="nama" class="form-control" placeholder="Nama Lengkap" required>
            </div>

            <div class="mb-3">
                <input type="text" name="username" class="form-control" placeholder="Username" required>
            </div>

            <div class="mb-3">
                <input type="password" name="password" class="form-control" placeholder="Password" required>
            </div>

            <div class="mb-3">
                <input type="password" name="confirm_password" class="form-control" placeholder="Konfirmasi Password" required>
            </div>

            <button type="submit" class="btn btn-custom w-100">Register</button>
        </form>

        <div class="text-center mt-3">
            Sudah punya akun? <a href="index.php">Login</a>
        </div>
    </div>
</div>

</body>
</html>