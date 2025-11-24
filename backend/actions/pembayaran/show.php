<?php
if (!isset($_GET['nisn'])) {
    echo "
    <script>    
        alert('Tidak bisa memilih ID ini');
        window.location.href='../../pages/pembayaran/index.php';
        </script>
    ";
}

$nisn = $_GET['nisn'];

$qSelect = "SELECT siswa.nisn, siswa.nis, siswa.nama, siswa.alamat, siswa.no_telp, 
        kelas.id_kelas, kelas.nama_kelas, kelas.kompetensi_keahlian,
        spp.id_spp, spp.tahun AS spp_tahun, spp.nominal, 
        IFNULL(SUM(pembayaran.jumlah_bayar), 0) AS sudah_dibayar
    FROM siswa
    JOIN kelas ON kelas.id_kelas = siswa.id_kelas
    JOIN spp ON spp.id_spp = siswa.id_spp
    LEFT JOIN pembayaran ON pembayaran.nisn = siswa.nisn
    WHERE siswa.nisn = '$nisn'
    GROUP BY siswa.nisn, siswa.nis, siswa.nama, siswa.alamat, siswa.no_telp,
        kelas.id_kelas, kelas.nama_kelas, kelas.kompetensi_keahlian,
        spp.id_spp, spp.tahun, spp.nominal'";
$result = mysqli_query($connect, $qSelect) or die(mysqli_error($connect));

$pembayaran = $result->fetch_object();
if (!$pembayaran) {
    die("Data tidak di temukan");
}
?>