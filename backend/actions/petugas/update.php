<?php
include '../../app.php';

// helper fallback jika escapeString tidak tersedia
if (!function_exists('escapeString')) {
    function escapeString($value)
    {
        global $connect;
        return mysqli_real_escape_string($connect, trim($value));
    }
}

// Pastikan form submit
if (isset($_POST['tombol'])) {

    // Ambil data dari form dan sanitasi
    $id_petugas   = isset($_POST['id_petugas']) ? escapeString($_POST['id_petugas']) : '';
    $username     = isset($_POST['username']) ? escapeString($_POST['username']) : '';
    $nama_petugas = isset($_POST['nama_petugas']) ? escapeString($_POST['nama_petugas']) : '';
    $level        = isset($_POST['level']) ? escapeString($_POST['level']) : '';
    $password     = isset($_POST['password']) ? trim($_POST['password']) : ''; // jika kosong, password tidak diubah

    // Validasi minimal
    if ($id_petugas === '' || $username === '' || $nama_petugas === '' || $level === '') {
        echo "<script>
                alert('Field wajib tidak boleh kosong');
                window.location.href='../../pages/petugas/edit.php?id_petugas={$id_petugas}';
              </script>";
        exit;
    }

    // Buat query update
    if ($password !== '') {
        // Hash password baru sebelum disimpan
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // Pastikan hashedPassword di-escape juga (meskipun biasanya aman)
        $hashedPasswordEsc = mysqli_real_escape_string($connect, $hashedPassword);

        $qUpdate = "UPDATE petugas 
                    SET username='$username', password='$hashedPasswordEsc', nama_petugas='$nama_petugas', level='$level' 
                    WHERE id_petugas='$id_petugas'";
    } else {
        // Password tidak diubah
        $qUpdate = "UPDATE petugas 
                    SET username='$username', nama_petugas='$nama_petugas', level='$level' 
                    WHERE id_petugas='$id_petugas'";
    }

    $result = mysqli_query($connect, $qUpdate);

    if ($result) {
        echo "<script>
                alert('Data berhasil diubah');
                window.location.href='../../pages/petugas/index.php';
              </script>";
    } else {
        echo "<script>
                alert('Data gagal diubah: " . mysqli_real_escape_string($connect, mysqli_error($connect)) . "');
                window.location.href='../../pages/petugas/edit.php?id_petugas={$id_petugas}';
              </script>";
    }
}
