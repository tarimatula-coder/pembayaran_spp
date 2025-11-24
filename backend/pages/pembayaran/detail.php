<?php
include '../../partials/header.php';
include '../../partials/sidebar.php';
include '../../partials/navbar.php';

if (!isset($_GET['nisn'])) {
    echo "
    <script>
        alert('Tidak bisa memilih NISN ini');
        window.location.href='../../pages/siswa/index.php';
    </script>
    ";
    exit;
}

$nisn = $_GET['nisn'];

// Data siswa
$qSelect = "SELECT siswa.nisn, siswa.nis, siswa.nama, siswa.alamat, siswa.no_telp,
        kelas.nama_kelas, kelas.kompetensi_keahlian,
        spp.nominal, 
        IFNULL(SUM(pembayaran.jumlah_bayar), 0) AS sudah_dibayar
    FROM siswa
    JOIN spp ON spp.id_spp = siswa.id_spp
    JOIN kelas ON kelas.id_kelas = siswa.id_kelas
    LEFT JOIN pembayaran ON pembayaran.nisn = siswa.nisn
    WHERE siswa.nisn = '$nisn'
    GROUP BY siswa.nisn, siswa.nis, siswa.nama, siswa.alamat, siswa.no_telp,
             kelas.nama_kelas, kelas.kompetensi_keahlian, spp.nominal";
$result = mysqli_query($connect, $qSelect) or die(mysqli_error($connect));
$siswa = $result->fetch_object();
if (!$siswa) die("Data siswa tidak ditemukan");

$sisa = $siswa->nominal - $siswa->sudah_dibayar;

// Ambil pembayaran terakhir beserta nama petugas
$qPembayaran = "SELECT pembayaran.*, petugas.nama_petugas FROM pembayaran 
                LEFT JOIN petugas ON pembayaran.id_petugas = petugas.id_petugas
                WHERE nisn = '$nisn' 
                ORDER BY id_pembayaran DESC 
                LIMIT 1";
$rPembayaran = mysqli_query($connect, $qPembayaran) or die(mysqli_error($connect));
$pembayaran = $rPembayaran->fetch_object();
?>

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card m-4 shadow-sm">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0"><i class="fa fa-user-graduate me-2"></i> Detail Siswa & Pembayaran</h5>
                    <a href="./index.php" class="btn btn-light btn-sm">
                        <i class="fa fa-arrow-left"></i> Kembali
                    </a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered align-middle">
                            <tbody>
                                <tr>
                                    <th style="width: 30%;">NISN</th>
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
                                    <td><?= $siswa->nama_kelas ?> - <?= $siswa->kompetensi_keahlian ?></td>
                                </tr>
                                <tr>
                                    <th>Alamat</th>
                                    <td><?= $siswa->alamat ?></td>
                                </tr>
                                <tr>
                                    <th>No. Telepon</th>
                                    <td><?= $siswa->no_telp ?></td>
                                </tr>
                                <tr class="table-light">
                                    <th colspan="2" class="text-center">Informasi Pembayaran</th>
                                </tr>
                                <tr>
                                    <th>Tanggal Bayar Terakhir</th>
                                    <td><?= $pembayaran ? $pembayaran->tgl_bayar : '-' ?></td>
                                </tr>
                                <tr>
                                    <th>Bulan Dibayar</th>
                                    <td><?= $pembayaran ? $pembayaran->bulan_dibayar : '-' ?></td>
                                </tr>
                                <tr>
                                    <th>Tahun Dibayar</th>
                                    <td><?= $pembayaran ? $pembayaran->tahun_dibayar : '-' ?></td>
                                </tr>
                                <tr>
                                    <th>Jumlah Bayar Terakhir</th>
                                    <td><?= $pembayaran ? 'Rp' . number_format($pembayaran->jumlah_bayar, 0, ',', '.') : '-' ?></td>
                                </tr>
                                <!-- Tambahkan nama petugas di sini -->
                                <tr>
                                    <th>Petugas</th>
                                    <td><?= $pembayaran ? $pembayaran->nama_petugas : '-' ?></td>
                                </tr>
                                <tr>
                                    <th>Status</th>
                                    <td>
                                        <?php if ($sisa > 0): ?>
                                            <span class="badge bg-danger">Belum Lunas (Sisa Rp<?= number_format($sisa, 0, ',', '.') ?>)</span>
                                        <?php else: ?>
                                            <span class="badge bg-success">Sudah Lunas</span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div> <!-- table-responsive -->
                </div> <!-- card-body -->
            </div> <!-- card -->
        </div> <!-- col-md-12 -->
    </div> <!-- row -->
</div> <!-- container -->
<?php
include '../../partials/footer.php';
include '../../partials/script.php';
?>