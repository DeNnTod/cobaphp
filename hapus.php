<?php
require 'functions.php';

// Mendapatkan ID dari URL
$id = $_GET['id'];

// Menghapus data berdasarkan ID
hapusMahasiswa($id);

// Mengarahkan kembali ke halaman utama setelah data dihapus
header("Location: index.php");
?>
