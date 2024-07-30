<?php
require 'functions.php';
session_start();

if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit;
}

// Pengaturan pagination
$batas = 5; // Jumlah entri yang ditampilkan per halaman
$halaman = isset($_GET['halaman']) ? (int)$_GET['halaman'] : 1;
$mulai = ($halaman > 1) ? ($halaman * $batas) - $batas : 0;

// Mendapatkan total jumlah entri
$total = getMahasiswaCount();
$jumlahHalaman = ceil($total / $batas);

// Mendapatkan data mahasiswa yang sesuai dengan halaman saat ini
if (isset($_GET['cari'])) {
    $kataKunci = $_GET['kata_kunci'];
    $result = searchMahasiswa($kataKunci);
} else {
    $result = getMahasiswaPaginated($mulai, $batas);
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Mahasiswa</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { padding: 20px; }
        .table-container { margin-top: 20px; }
        .btn-custom { margin-top: 20px; }
        .search-container { margin-bottom: 20px; }
    </style>
</head>
<body>
    <div class="container">
        <h1 class="text-center">Data Mahasiswa</h1>

        <div class="search-container">
            <form class="form-inline" id="searchForm">
                <input type="text" class="form-control mr-2" id="kata_kunci" name="kata_kunci" placeholder="Cari nama, nisn, email, atau jurusan" required>
                <button type="submit" class="btn btn-primary">Cari</button>
            </form>
        </div>

        <div class="table-container" id="tableContainer">
            <!-- Konten tabel akan diperbarui dengan AJAX -->
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Nama</th>
                        <th>Nisn</th>
                        <th>Email</th>
                        <th>Jurusan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($kata_kunci) {
                        $result = searchMahasiswa($kata_kunci);
                        $total = mysqli_num_rows($result);
                    } else {
                        $result = getMahasiswaPaginated($mulai, $batas);
                        $total = getMahasiswaCount();
                    }

                    if (!$result) {
                        die("Query failed: " . mysqli_error(koneksi()));
                    }

                    $jumlahHalaman = ceil($total / $batas);

                    while ($row = mysqli_fetch_assoc($result)): ?>
                    <tr>
                        <td><?= $row["id"]; ?></td>
                        <td><?= $row["nama"]; ?></td>
                        <td><?= $row["nisn"]; ?></td>
                        <td><?= $row["email"]; ?></td>
                        <td><?= $row["jurusan"]; ?></td>
                        <td>
                            <a href="ubah.php?id=<?= $row["id"]; ?>" class="btn btn-warning btn-sm">Ubah</a>
                            <a href="hapus.php?id=<?= $row["id"]; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?');">Hapus</a>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>

        <nav id="paginationContainer">
            <ul class="pagination justify-content-center">
                <?php for ($i = 1; $i <= $jumlahHalaman; $i++): ?>
                <li class="page-item <?= ($halaman == $i) ? 'active' : ''; ?>">
                    <a class="page-link" href="?halaman=<?= $i; ?>"><?= $i; ?></a>
                </li>
                <?php endfor; ?>
            </ul>
        </nav>

        <a href="tambah.php" class="btn btn-primary btn-custom">Tambah Data</a>
        <a href="report.php" class="btn btn-info btn-custom">Download PDF</a>
        <a href="logout.php" class="btn btn-secondary btn-custom">Logout</a>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        $(document).ready(function() {
            function fetchData(kata_kunci = '', halaman = 1) {
                $.ajax({
                    url: 'search.php',
                    type: 'GET',
                    data: { kata_kunci: kata_kunci, halaman: halaman },
                    dataType: 'json',
                    success: function(response) {
                        $('#tableContainer').html(response.table);
                        $('#paginationContainer').html(response.pagination);
                    }
                });
            }

            fetchData();

            $('#kata_kunci').on('keyup', function() {
                let kata_kunci = $(this).val();
                fetchData(kata_kunci);
            });

            $(document).on('click', '.page-link', function(e) {
                e.preventDefault();
                let halaman = $(this).attr('href').split('halaman=')[1];
                let kata_kunci = $('#kata_kunci').val();
                fetchData(kata_kunci, halaman);
            });
        });
    </script>
</body>
</html>
