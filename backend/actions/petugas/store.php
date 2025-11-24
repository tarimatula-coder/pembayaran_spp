<?php
include '../../app.php'; // pastikan koneksi database ada

if (isset($_POST['tombol'])) {
    // Ambil dan bersihkan input
    $username = isset($_POST['username']) ? mysqli_real_escape_string($connect, $_POST['username']) : '';
    $nama_petugas = isset($_POST['nama_petugas']) ? mysqli_real_escape_string($connect, $_POST['nama_petugas']) : '';
    $level = isset($_POST['level']) ? mysqli_real_escape_string($connect, $_POST['level']) : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';

    // Validasi sederhana
    if (empty($username) || empty($nama_petugas) || empty($level) || empty($password)) {
        echo "
        <script>
            alert('Semua field harus diisi!');
            window.location.href='../../pages/petugas/create.php';
        </script>
        ";
        exit;
    }

    // Hash password
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Insert ke tabel petugas (gunakan hashed password)
    $qInsert = " INSERT INTO petugas (username, nama_petugas, level, password) 
        VALUES ('$username', '$nama_petugas', '$level', '$hashedPassword')
    ";

    if (mysqli_query($connect, $qInsert)) {
        echo "
        <script>
            alert('Data petugas berhasil ditambahkan');
            window.location.href='../../pages/petugas/index.php';
        </script>
        ";
    } else {
        echo "
        <script>
            alert('Gagal menambahkan petugas: " . mysqli_error($connect) . "');
            window.location.href='../../pages/petugas/create.php';
        </script>
        ";
    }
}
