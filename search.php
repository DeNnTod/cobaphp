<?php
require 'functions.php';

$kata_kunci = isset($_GET['kata_kunci']) ? $_GET['kata_kunci'] : '';
$halaman = isset($_GET['halaman']) ? (int)$_GET['halaman'] : 1;
$batas = 5;
$mulai = ($halaman > 1) ? ($halaman * $batas) - $batas : 0;

if ($kata_kunci) {
    $result = searchMahasiswa($kata_kunci);
    $total = mysqli_num_rows($result);
} else {
    $result = getMahasiswaPaginated($mulai, $batas);
    $total = getMahasiswaCount();
}

$jumlahHalaman = ceil($total / $batas);

$table = '<table class="table table-bordered">
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
            <tbody>';

while ($row = mysqli_fetch_assoc($result)) {
    $table .= "<tr>
                <td>{$row['id']}</td>
                <td>{$row['nama']}</td>
                <td>{$row['nisn']}</td>
                <td>{$row['email']}</td>
                <td>{$row['jurusan']}</td>
                <td>
                    <a href='ubah.php?id={$row['id']}' class='btn btn-warning btn-sm'>Ubah</a>
                    <a href='hapus.php?id={$row['id']}' class='btn btn-danger btn-sm' onclick='return confirm(\"Apakah Anda yakin ingin menghapus data ini?\");'>Hapus</a>
                </td>
              </tr>";
}

$table .= '</tbody></table>';

$pagination = '<ul class="pagination justify-content-center">';
for ($i = 1; $i <= $jumlahHalaman; $i++) {
    $pagination .= '<li class="page-item ' . ($halaman == $i ? 'active' : '') . '">
                        <a class="page-link" href="?halaman=' . $i . '">' . $i . '</a>
                    </li>';
}
$pagination .= '</ul>';

echo json_encode(['table' => $table, 'pagination' => $pagination]);
?>
