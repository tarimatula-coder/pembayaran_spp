<?php
include '../../app.php';
include './show.php'; // ambil data kelas berdasarkan id

$id_kelas = $kelas->id_kelas;

// cek apakah ada siswa yang masih pakai kelas ini
$cek = mysqli_query($connect, "SELECT COUNT(*) as total FROM siswa WHERE id_kelas='$id_kelas'");
$data = $cek->fetch_object();

if ($data->total > 0) {
    // kalau masih ada siswa, jangan hapus
    echo "
    <script>
        alert('Tidak bisa hapus, masih ada siswa di kelas ini');
        window.location.href='../../pages/kelas/index.php';
    </script>";
    exit;
}

// kalau tidak ada siswa, hapus kelas
$qDelete = "DELETE FROM kelas WHERE id_kelas = '$id_kelas'";
$result = mysqli_query($connect, $qDelete) or die(mysqli_error($connect));

if ($result) {
    echo " 
    <script>    
        alert('Data berhasil dihapus');
        window.location.href='../../pages/kelas/index.php';
    </script>";
} else {
    echo "
    <script>    
        alert('Data gagal dihapus');
        window.location.href='../../pages/kelas/index.php';
    </script>";
}
