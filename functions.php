<?php
// Fungsi untuk menghubungkan ke database
function koneksi() {
    $conn = mysqli_connect("sql309.infinityfree.com", "if0_36995900", "kQ7pQdD51egR4EO", "if0_36995900_belajarphp");
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }
    return $conn;
}


// Fungsi untuk menjalankan query
function query($query)
{
    $conn = koneksi(); // Menghubungkan ke database
    return mysqli_query($conn, $query); // Menjalankan query dan mengembalikan hasilnya
}

// Fungsi untuk mendapatkan semua data mahasiswa
function getAllMahasiswa()
{
    return query("SELECT * FROM mahasiswa"); // Mengambil semua data dari tabel mahasiswa
}

// Fungsi untuk mencari mahasiswa berdasarkan kata kunci
function searchMahasiswa($keyword)
{
    $conn = koneksi(); // Menghubungkan ke database
    $query = "SELECT * FROM mahasiswa WHERE 
              nama LIKE '%$keyword%' OR 
              nisn LIKE '%$keyword%' OR 
              email LIKE '%$keyword%' OR 
              jurusan LIKE '%$keyword%'"; // Membuat query pencarian dengan kata kunci
    return mysqli_query($conn, $query); // Menjalankan query dan mengembalikan hasilnya
}

// Fungsi untuk menambah data mahasiswa
function tambahMahasiswa($data)
{
    $conn = koneksi(); // Menghubungkan ke database
    $nama = htmlspecialchars($data["nama"]); // Mengamankan input nama
    $nisn = htmlspecialchars($data["nisn"]); // Mengamankan input nisn
    $email = htmlspecialchars($data["email"]); // Mengamankan input email
    $jurusan = htmlspecialchars($data["jurusan"]); // Mengamankan input jurusan

    // Membuat query untuk menambah data mahasiswa
    $query = "INSERT INTO mahasiswa (nama, nisn, email, jurusan) VALUES ('$nama', '$nisn', '$email', '$jurusan')";
    mysqli_query($conn, $query); // Menjalankan query
}

// Fungsi untuk menghapus data mahasiswa berdasarkan id
function hapusMahasiswa($id)
{
    $conn = koneksi(); // Menghubungkan ke database
    $query = "DELETE FROM mahasiswa WHERE id = $id"; // Membuat query untuk menghapus data mahasiswa berdasarkan id
    mysqli_query($conn, $query); // Menjalankan query
}

// Fungsi untuk mengubah data mahasiswa
function ubahMahasiswa($id, $nama, $nisn, $email, $jurusan) {
    $conn = koneksi();
    $id = mysqli_real_escape_string($conn, $id);
    $nama = mysqli_real_escape_string($conn, $nama);
    $nisn = mysqli_real_escape_string($conn, $nisn);
    $email = mysqli_real_escape_string($conn, $email);
    $jurusan = mysqli_real_escape_string($conn, $jurusan);

    $query = "UPDATE mahasiswa SET nama = '$nama', nisn = '$nisn', email = '$email', jurusan = '$jurusan' WHERE id = $id";
    mysqli_query($conn, $query);
}

// Fungsi untuk mendaftarkan pengguna baru
function registerUser($username, $password)
{
    $conn = koneksi(); // Menghubungkan ke database
    $username = htmlspecialchars($username); // Mengamankan input username
    $password = password_hash($password, PASSWORD_DEFAULT); // Mengenkripsi password

    // Mengecek apakah username sudah ada di database
    $result = query("SELECT * FROM user WHERE username = '$username'");
    if (mysqli_num_rows($result) > 0) {
        return false; // Jika username sudah ada, kembalikan false
    }

    // Membuat query untuk menambah pengguna baru
    $query = "INSERT INTO user (username, password) VALUES ('$username', '$password')";
    mysqli_query($conn, $query); // Menjalankan query
    return true; // Kembalikan true jika pendaftaran berhasil
}

// Fungsi untuk login pengguna
function loginUser($username, $password)
{
    $conn = koneksi(); // Menghubungkan ke database
    $username = htmlspecialchars($username); // Mengamankan input username

    // Membuat query untuk mencari pengguna berdasarkan username
    $result = query("SELECT * FROM user WHERE username = '$username'");
    if (mysqli_num_rows($result) === 1) {
        $row = mysqli_fetch_assoc($result); // Mengambil data pengguna
        if (password_verify($password, $row['password'])) { // Memverifikasi password
            return $row; // Jika password cocok, kembalikan data pengguna
        }
    }
    return false; // Jika username atau password salah, kembalikan false
}

function getMahasiswaPaginated($mulai, $batas) {
    $conn = koneksi();
    $query = "SELECT * FROM mahasiswa LIMIT $mulai, $batas";
    $result = mysqli_query($conn, $query);
    
    if (!$result) {
        die("Query Error: " . mysqli_error($conn));
    }
    
    return $result;
}


function getMahasiswaCount()
{
    $conn = koneksi();
    $query = "SELECT COUNT(*) as total FROM mahasiswa";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);
    return $row['total'];
}

function getMahasiswaById($id) {
    $conn = koneksi();
    $query = "SELECT * FROM mahasiswa WHERE id = $id";
    $result = mysqli_query($conn, $query);
    return mysqli_fetch_assoc($result);
}
?>
