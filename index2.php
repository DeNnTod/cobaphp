<?php
$conn = mysqli_connect("localhost", "root","","belajarphp");


$result = mysqli_query($conn, " SELECT * FROM mahasiswa" );
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <table border="2" cellpading="10" cellspacing="2" >
        <tr>
            <td>No.</td>
            <td>Nama</td>
            <td>Nisn</td>
            <td>Email</td>
            <td>Jurusan</td>
            <td>Aksi</td>
        </tr>
        <?php  while($row = mysqli_fetch_assoc($result)): ?>
        <tr>
            <td><?= $row["id"]; ?></td>
            <td><?= $row["nama"]; ?></td>
            <td><?= $row["nisn"]; ?></td>
            <td><?= $row["email"]; ?></td>
            <td><?= $row["jurusan"]; ?></td>
            <td> <a href=""> ubah</a>
                <a href="">hapus</a>
            </td>
        <?php endwhile; ?>
        </tr>
    </table>
</body>
</html>