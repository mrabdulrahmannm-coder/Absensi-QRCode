<?php session_start();
include 'koneksi.php';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = MD5($_POST['password']);
    if ($username === 'admin' && $password === MD5('#admin123')) {
        $_SESSION['username'] = $username;
        $_SESSION['status'] = 'login';
        header("Location: home/home.php");
        exit();
    }
    $query = "SELECT * FROM login WHERE username='$username' AND password='$password'";
    $result = mysqli_query($koneksi, $query);
    $count = mysqli_num_rows($result);
    if ($count > 0) {
        $_SESSION['username'] = $username;
        $_SESSION['status'] = 'login';
        header("Location: ip-barqode.php");
        exit();
    } else {
        header("Location: index.php?pesan=gagal");
        exit();
    }
} ?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css">
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
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.2);
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

        .btn-outline {
            border: 1px solid white;
            color: white;
            border-radius: 12px;
        }

        a {
            color: white;
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
            <h3 class="text-center mb-4">Welcome Back</h3>

            <?php if (isset($error)) { ?>
                <div class="alert alert-danger text-center">
                    <?= $error ?>
                </div>
            <?php } ?>

            <form method="post">

                <div class="mb-3">
                    <input type="text" name="username" class="form-control" placeholder="Username" required>
                </div>

                <div class="mb-3 position-relative">
                    <input type="password" name="password" id="password" class="form-control" placeholder="Password" required>
                    <span onclick="togglePassword()"
                        style="position:absolute; right:15px; top:50%; transform:translateY(-50%); cursor:pointer; color:#666;">
                        <i class="fa-solid fa-eye"></i>
                    </span>
                </div>

                <button type="submit" class="btn btn-custom w-100 mb-2">
                    Login
                </button>

                <a href="register.php" class="btn btn-outline w-100">
                    Buat Akun
                </a>

            </form>
        </div>
    </div>

    <script>
        function togglePassword() {
            var x = document.getElementById("password");
            if (x.type === "password") {
                x.type = "text";
            } else {
                x.type = "password";
            }
        }
    </script>

</body>

</html>