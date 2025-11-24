<?php
include '../../partials/header.php';
include '../../partials/sidebar.php';
include '../../partials/navbar.php';

if (!isset($_GET['nisn'])) {
    echo "<script>alert('Tidak bisa memilih NISN ini');window.location.href='index.php';</script>";
    exit;
}

$nisn = $_GET['nisn'];

// Ambil data siswa
$qsiswa = "
SELECT 
    siswa.nisn, 
    siswa.nis, 
    siswa.nama, 
    siswa.alamat, 
    siswa.no_telp, 
    kelas.nama_kelas, 
    kelas.kompetensi_keahlian,
    spp.nominal,
    IFNULL(SUM(pembayaran.jumlah_bayar),0) AS sudah_dibayar
FROM siswa
LEFT JOIN kelas ON siswa.id_kelas = kelas.id_kelas
LEFT JOIN spp ON siswa.id_spp = spp.id_spp
LEFT JOIN pembayaran ON siswa.nisn = pembayaran.nisn
WHERE siswa.nisn = '$nisn'
GROUP BY siswa.nisn
";
$result = mysqli_query($connect, $qsiswa) or die(mysqli_error($connect));
$siswa = mysqli_fetch_object($result);
if (!$siswa) die("Data siswa tidak ditemukan");

// Hitung sisa bayar dan status
$sisa_bayar = $siswa->nominal - $siswa->sudah_dibayar;
$status = ($sisa_bayar <= 0) ? "Lunas" : "Belum Lunas";
?>

<!-- Script untuk Cetak -->
<script>
    function printTable() {
        var printContents = document.getElementById('printTableArea').innerHTML;
        var originalContents = document.body.innerHTML;

        document.body.innerHTML = printContents;
        window.print();
        document.body.innerHTML = originalContents;
        location.reload(); // reload untuk mengembalikan JS & CSS normal
    }
</script>

<!-- CSS khusus print -->
<style>
    @media print {
        body * {
            visibility: hidden;
        }

        #printTableArea,
        #printTableArea * {
            visibility: visible;
        }

        #printTableArea {
            position: absolute;
            left: 0;
            top: 0;
            width: 100%;
        }
    }
</style>

<div class="container">
    <div class="row">
        <div class="col-md-12">

            <!-- Card Detail Siswa -->
            <div class="card m-4 shadow-sm">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0"><i class="fa fa-user-graduate me-2"></i> Detail Siswa</h5>
                    <div>
                        <button onclick="printTable()" class="btn btn-success btn-sm float-right">Cetak</button>
                        <a href="index.php" class="btn btn-light btn-sm"><i class="fa fa-arrow-left"></i> Kembali</a>
                    </div>
                </div>
                <div class="card-body" id="printTableArea">
                    <h5>Detail Siswa</h5>
                    <table class="table table-bordered mb-4">
                        <tbody>
                            <tr>
                                <th>NISN</th>
                                <td><?= $siswa->nisn ?></td>
                            </tr>
                            <tr>
                                <th>NIS</th>
                                <td><?= $siswa->nis ?></td>
                            </tr>
                            <tr>
                                <th>Nama</th>
                                <td><?= $siswa->nama ?></td>
                            </tr>
                            <tr>
                                <th>Kelas</th>
                                <td><?= $siswa->nama_kelas ?></td>
                            </tr>
                            <tr>
                                <th>Kompetensi Keahlian</th>
                                <td><?= $siswa->kompetensi_keahlian ?></td>
                            </tr>
                            <tr>
                                <th>Alamat</th>
                                <td><?= $siswa->alamat ?></td>
                            </tr>
                            <tr>
                                <th>No. Telepon</th>
                                <td><?= $siswa->no_telp ?></td>
                            </tr>
                            <tr>
                                <th>Nominal SPP</th>
                                <td>Rp<?= number_format($siswa->nominal, 0, ',', '.') ?></td>
                            </tr>
                            <tr>
                                <th>Sudah dibayar</th>
                                <td>Rp<?= number_format($siswa->sudah_dibayar, 0, ',', '.') ?></td>
                            </tr>
                            <tr>
                                <th>Sisa Bayar</th>
                                <td>Rp<?= number_format($sisa_bayar, 0, ',', '.') ?></td>
                            </tr>
                            <tr>
                                <th>Status</th>
                                <td><?= $status ?></td>
                            </tr>
                        </tbody>
                    </table>
                </div> <!-- card-body -->
            </div> <!-- card -->

        </div>
    </div>
</div>

<?php
include '../../partials/footer.php';
include '../../partials/script.php';
?>