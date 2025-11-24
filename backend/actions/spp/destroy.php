<?php
include '../../app.php';
include './show.php'; // ambil data spp berdasarkan id

// cek apakah spp masih dipakai di tabel siswa
$cek = mysqli_query($connect, "SELECT COUNT(*) as jml FROM siswa WHERE id_spp = '$spp->id_spp'");
$row = mysqli_fetch_assoc($cek);

if ($row['jml'] > 0) {
    echo "
    <script>
        alert('Data SPP tidak bisa dihapus karena masih digunakan oleh data siswa!');
        window.location.href='../../pages/spp/index.php';
    </script>
    ";
    exit;
}

// jika tidak dipakai, baru hapus
$qDelete = "DELETE FROM spp WHERE id_spp = '$spp->id_spp'";
$result = mysqli_query($connect, $qDelete) or die(mysqli_error($connect));

if ($result) {
    echo " 
    <script>    
        alert('Data berhasil dihapus');
        window.location.href='../../pages/spp/index.php';
    </script>
    ";
} else {
    echo "
    <script>    
        alert('Data gagal dihapus');
        window.location.href='../../pages/spp/index.php';
    </script>
    ";
}
