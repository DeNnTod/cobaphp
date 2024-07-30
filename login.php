<?php
require 'functions.php';
session_start();

// Jika pengguna sudah login, arahkan ke halaman index
if (isset($_SESSION['user'])) {
    header("Location: index.php");
    exit;
}

// Memeriksa cookie
if (isset($_COOKIE['username']) && isset($_COOKIE['password'])) {
    $username = $_COOKIE['username'];
    $password = $_COOKIE['password'];

    $user = loginUser($username, $password);
    if ($user) {
        $_SESSION['user'] = $user;
        header("Location: index.php");
        exit;
    }
}

if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $remember = isset($_POST['remember']); // Menangkap nilai checkbox

    // Login pengguna
    $user = loginUser($username, $password);
    if ($user) {
        $_SESSION['user'] = $user;

        // Menambahkan cookie jika "Remember Me" di-check
        if ($remember) {
            setcookie('username', $username, time() + (86400 * 30), "/"); // Cookie berlaku selama 30 hari
            setcookie('password', $password, time() + (86400 * 30), "/"); // Cookie berlaku selama 30 hari
        }

        header("Location: index.php");
        exit;
    } else {
        echo "<script>alert('Username atau password salah!');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { padding: 20px; }
        .form-container { margin-top: 20px; }
    </style>
</head>
<body>
    <div class="container">
        <h1 class="text-center">Login Pengguna</h1>
        <div class="form-container">
            <form action="" method="post">
                <div class="form-group">
                    <label for="username">Username:</label>
                    <input type="text" class="form-control" name="username" id="username" required>
                </div>
                <div class="form-group">
                    <label for="password">Password:</label>
                    <input type="password" class="form-control" name="password" id="password" required>
                </div>
                <div class="form-group form-check">
                    <input type="checkbox" class="form-check-input" name="remember" id="remember">
                    <label class="form-check-label" for="remember">Remember Me</label>
                </div>
                <button type="submit" name="login" class="btn btn-success">Login</button>
            </form>
            <div class="text-center mt-3">
                <p>Belum punya akun? <a href="register.php">Register di sini</a></p>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
