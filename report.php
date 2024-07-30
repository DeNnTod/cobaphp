<?php
require 'functions.php'; // Memasukkan file functions.php yang berisi fungsi-fungsi database
require 'fpdf/fpdf.php'; // Memasukkan library FPDF

// Mendapatkan data mahasiswa
$mahasiswa = getAllMahasiswa(); // Memanggil fungsi untuk mendapatkan semua data mahasiswa

// Membuat instance FPDF
$pdf = new FPDF(); // Membuat objek baru dari kelas FPDF
$pdf->AddPage(); // Menambahkan halaman baru
$pdf->SetFont('Arial', 'B', 12); // Mengatur font menjadi Arial, bold, ukuran 12

// Header
$pdf->Cell(0, 10, 'Laporan Data Mahasiswa', 0, 1, 'C'); // Membuat header dengan teks "Laporan Data Mahasiswa", posisi center
$pdf->Ln(10); // Menambahkan baris baru

// Tabel Header
$pdf->SetFont('Arial', 'B', 10); // Mengatur font untuk header tabel
$pdf->Cell(10, 10, 'No', 1); // Kolom No
$pdf->Cell(40, 10, 'Nama', 1); // Kolom Nama
$pdf->Cell(30, 10, 'Nisn', 1); // Kolom Nisn
$pdf->Cell(60, 10, 'Email', 1); // Kolom Email
$pdf->Cell(50, 10, 'Jurusan', 1); // Kolom Jurusan
$pdf->Ln(); // Menambahkan baris baru

// Tabel Data
$pdf->SetFont('Arial', '', 10); // Mengatur font untuk data tabel
$no = 1; // Inisialisasi nomor urut
while ($row = mysqli_fetch_assoc($mahasiswa)) { // Mengambil data mahasiswa satu per satu
    $pdf->Cell(10, 10, $no++, 1); // Kolom No
    $pdf->Cell(40, 10, $row['nama'], 1); // Kolom Nama
    $pdf->Cell(30, 10, $row['nisn'], 1); // Kolom Nisn
    $pdf->Cell(60, 10, $row['email'], 1); // Kolom Email
    $pdf->Cell(50, 10, $row['jurusan'], 1); // Kolom Jurusan
    $pdf->Ln(); // Menambahkan baris baru
}

// Output PDF
$pdf->Output('D', 'Laporan_Data_Mahasiswa.pdf'); // Menghasilkan file PDF dengan nama "Laporan_Data_Mahasiswa.pdf" yang akan di-download
?>
