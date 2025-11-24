<?php
include '../../app.php';

if (isset($_POST['tombol'])) {
    $nisn     = escapeString($_POST['nisn']);
    $nis      = escapeString($_POST['nis']);
    $nama     = escapeString($_POST['nama']);
    $id_kelas = escapeString($_POST['id_kelas']);
    $alamat   = escapeString($_POST['alamat']);
    $no_telp  = escapeString($_POST['no_telp']);
    $id_spp   = escapeString($_POST['id_spp']);
    $password = isset($_POST['password']) ? trim($_POST['password']) : '';

    // Gunakan nisn lama dari URL
    $old_nisn = $_GET['nisn'];

    // cek id_spp lama
    $cek = mysqli_query($connect, "SELECT id_spp FROM siswa WHERE nisn='$old_nisn'");
    $row = mysqli_fetch_assoc($cek);
    $id_spp_lama = $row['id_spp'];

    if ($id_spp != $id_spp_lama) {
        // cek apakah siswa punya data pembayaran
        $cekBayar = mysqli_query($connect, "SELECT COUNT(*) as jml FROM pembayaran WHERE id_spp='$id_spp_lama'");
        $hitung = mysqli_fetch_assoc($cekBayar);

        if ($hitung['jml'] > 0) {
            echo "
            <script>
                alert('Tidak bisa mengubah ID SPP karena sudah ada data pembayaran!');
                window.location.href='../../pages/siswa/edit.php?nisn=$old_nisn';
            </script>";
            exit;
        }
    }

    // siapkan query update
    if ($password != '') {
        // jika admin isi password baru, hash password
        $passwordHash = password_hash($password, PASSWORD_DEFAULT);
        $qUpdate = "UPDATE siswa SET 
                        nisn='$nisn', 
                        nis='$nis', 
                        nama='$nama', 
                        id_kelas='$id_kelas', 
                        alamat='$alamat', 
                        no_telp='$no_telp', 
                        id_spp='$id_spp',
                        password='$passwordHash'
                    WHERE nisn='$old_nisn'";
    } else {
        // jika kosong, password tidak berubah
        $qUpdate = "UPDATE siswa SET 
                        nisn='$nisn', 
                        nis='$nis', 
                        nama='$nama', 
                        id_kelas='$id_kelas', 
                        alamat='$alamat', 
                        no_telp='$no_telp', 
                        id_spp='$id_spp'
                    WHERE nisn='$old_nisn'";
    }

    $result = mysqli_query($connect, $qUpdate) or die(mysqli_error($connect));
    if ($result) {
        echo "
        <script>
            alert('Data berhasil diubah');
            window.location.href='../../pages/siswa/index.php';
        </script>";
    } else {
        echo "
        <script>
            alert('Data gagal diubah');
            window.location.href='../../pages/siswa/edit.php?nisn=$old_nisn';
        </script>";
    }
}
