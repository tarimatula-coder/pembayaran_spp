<?php
include '../../app.php';
include './show.php'; // ambil data petugas berdasarkan id

$id_petugas = $petugas->id_petugas;

// cek apakah ada pembayaran yang masih pakai petugas ini
$cek = mysqli_query($connect, "SELECT COUNT(*) as total FROM pembayaran WHERE id_petugas='$id_petugas'");
$data = $cek->fetch_object();

if ($data->total > 0) {
    echo "
    <script>
        alert('Tidak bisa hapus, masih ada data pembayaran dengan petugas ini');
        window.location.href='../../pages/petugas/index.php';
    </script>";
    exit;
}
// kalau tidak ada pembayaran, hapus petugas
$qDelete = "DELETE FROM petugas WHERE id_petugas = '$id_petugas'";
$result = mysqli_query($connect, $qDelete) or die(mysqli_error($connect));

if ($result) {
    echo " 
    <script>    
        alert('Data berhasil dihapus');
        window.location.href='../../pages/petugas/index.php';
    </script>";
} else {
    echo "
    <script>    
        alert('Data gagal dihapus');
        window.location.href='../../pages/petugas/index.php';
    </script>";
}
?>