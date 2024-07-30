<?php
require 'functions.php'; // Memanggil file functions.php yang berisi fungsi-fungsi yang digunakan

if (isset($_POST['register'])) { // Mengecek apakah form registrasi telah disubmit
    $username = $_POST['username']; // Mengambil username dari input form
    $password = $_POST['password']; // Mengambil password dari input form

    if (registerUser($username, $password)) { // Mencoba untuk mendaftarkan user baru
        echo "<script>alert('Registrasi berhasil! Silakan login.');</script>"; // Menampilkan pesan sukses
        header("Location: login.php"); // Mengarahkan ke halaman login
        exit;
    } else {
        echo "<script>alert('Registrasi gagal. Username sudah digunakan.');</script>"; // Menampilkan pesan gagal jika username sudah digunakan
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrasi</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { padding: 20px; } /* Menambahkan padding pada body */
        .form-container { margin-top: 20px; } /* Menambahkan margin pada container form */
    </style>
</head>
<body>
    <div class="container">
        <h1 class="text-center">Registrasi Pengguna</h1> <!-- Judul halaman -->

        <div class="form-container">
            <!-- Membuat form registrasi -->
            <form action="" method="post">
                <div class="form-group">
                    <label for="username">Username:</label> <!-- Label untuk input username -->
                    <input type="text" class="form-control" name="username" id="username" required> <!-- Input untuk username -->
                </div>
                <div class="form-group">
                    <label for="password">Password:</label> <!-- Label untuk input password -->
                    <input type="password" class="form-control" name="password" id="password" required> <!-- Input untuk password -->
                </div>
                <!-- Tombol untuk submit form registrasi -->
                <button type="submit" name="register" class="btn btn-success">Register</button>
            </form>

            <div class="text-center mt-3">
                <p>Sudah punya akun? <a href="login.php">Login di sini</a></p> <!-- Link ke halaman login -->
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script> <!-- Menyertakan jQuery dari CDN -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script> <!-- Menyertakan Popper.js dari CDN -->
    <script src="https://maxcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script> <!-- Menyertakan Bootstrap JS dari CDN -->
</body>
</html>
q