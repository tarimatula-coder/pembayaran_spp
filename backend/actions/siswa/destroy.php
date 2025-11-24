<?php
include '../../app.php';
include './show.php'; // ambil data siswa berdasarkan id/nisn

// Hapus dulu semua pembayaran siswa terkait
$qDeleteBayar = "DELETE FROM pembayaran WHERE nisn = '$siswa->nisn'";
$resultBayar = mysqli_query($connect, $qDeleteBayar);

if ($resultBayar) {
    // Baru hapus data siswa
    $qDeleteSiswa = "DELETE FROM siswa WHERE nisn = '$siswa->nisn'";
    $resultSiswa = mysqli_query($connect, $qDeleteSiswa);

    if ($resultSiswa) {
        echo "
            <script>
                alert('Data siswa dan pembayaran berhasil dihapus');
                window.location.href='../../pages/siswa/index.php';
            </script>
        ";
    } else {
        echo "
            <script>
                alert('Gagal menghapus data siswa');
                window.location.href='../../pages/siswa/index.php';
            </script>
        ";
    }
} else {
    echo "
        <script>
            alert('Gagal menghapus data pembayaran siswa');
            window.location.href='../../pages/siswa/index.php';
        </script>
    ";
}
?>