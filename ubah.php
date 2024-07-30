<?php
require 'functions.php';

// Mendapatkan ID dari URL
$id = $_GET['id'];

// Mendapatkan data mahasiswa berdasarkan ID
$row = getMahasiswaById($id);

// Cek apakah form telah disubmit
if (isset($_POST['submit'])) {
    // Mengambil data input dari form
    $nama = $_POST['nama'];
    $nisn = $_POST['nisn'];
    $email = $_POST['email'];
    $jurusan = $_POST['jurusan'];

    // Memperbarui data di tabel "mahasiswa"
    ubahMahasiswa($id, $nama, $nisn, $email, $jurusan);

    // Mengarahkan kembali ke halaman utama setelah data diperbarui
    header("Location: index.php");
    exit; // Pastikan untuk mengakhiri eksekusi setelah redirect
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ubah Data</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { padding: 20px; }
        .form-container { margin-top: 20px; }
    </style>
</head>
<body>
    <div class="container">
        <h1 class="text-center">Ubah Data Mahasiswa</h1>
        <div class="form-container">
            <form action="" method="post">
                <div class="form-group">
                    <label for="nama">Nama:</label>
                    <input type="text" class="form-control" name="nama" id="nama" value="<?= htmlspecialchars($row['nama']); ?>" required>
                </div>
                <div class="form-group">
                    <label for="nisn">Nisn:</label>
                    <input type="text" class="form-control" name="nisn" id="nisn" value="<?= htmlspecialchars($row['nisn']); ?>" required>
                </div>
                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" class="form-control" name="email" id="email" value="<?= htmlspecialchars($row['email']); ?>" required>
                </div>
                <div class="form-group">
                    <label for="jurusan">Jurusan:</label>
                    <input type="text" class="form-control" name="jurusan" id="jurusan" value="<?= htmlspecialchars($row['jurusan']); ?>" required>
                </div>
                <button type="submit" name="submit" class="btn btn-success">Ubah Data</button>
            </form>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
