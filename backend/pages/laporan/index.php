<?php
include '../../partials/header.php';
include '../../partials/sidebar.php';
include '../../partials/navbar.php';

// Ambil data siswa + total pembayaran
$qsiswa = "SELECT 
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
GROUP BY siswa.nisn
ORDER BY siswa.nama ASC";

$result = mysqli_query($connect, $qsiswa) or die(mysqli_error($connect));
?>

<!-- Content -->
<div class="container print-area">
    <div class="page-inner">
        <div class="page-header">
            <h3 class="fw-bold mb-3 text-center">Laporan Pembayaran SPP</h3>
        </div>
        <div class="card">
            <!-- Card Header -->
            <div class="card-header d-flex justify-content-between align-items-center no-print">
                <h4 class="table-data-title">Data Pembayaran Siswa</h4>
            </div>
            <!-- Card Body -->
            <div class="card-body">
                <div class="table-responsive">
                    <table class="display table table-hover">
                        <thead>
                            <tr>
                                <th class="text-center">No</th>
                                <th class="text-center">NISN</th>
                                <th class="text-center">Nama</th>
                                <th class="text-center">Kompetensi</th>
                                <th class="text-center">Nominal</th>
                                <th class="text-center">Sudah Dibayar</th>
                                <th class="text-center">Sisa Bayar</th>
                                <th class="text-center">Status</th>
                                <th class="text-center no-print">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $no = 1;
                            while ($item = $result->fetch_object()):
                                $sisa = $item->nominal - $item->sudah_dibayar;
                                if ($sisa < 0) $sisa = 0;
                            ?>
                                <tr>
                                    <td class="text-center"><?= $no++ ?></td>
                                    <td class="text-center"><?= $item->nisn ?></td>
                                    <td class="text-center"><?= $item->nama ?></td>
                                    <td class="text-center"><?= $item->kompetensi_keahlian ?></td>
                                    <td class="text-center">Rp<?= number_format($item->nominal, 0, ',', '.') ?></td>
                                    <td class="text-center">Rp<?= number_format($item->sudah_dibayar, 0, ',', '.') ?></td>
                                    <td class="text-center">Rp<?= number_format($sisa, 0, ',', '.') ?></td>
                                    <td class="text-center">
                                        <?= $sisa > 0 ? '<span class="badge bg-danger">Belum Lunas</span>' : '<span class="badge bg-success">Lunas</span>' ?>
                                    </td>
                                    <td class="text-center no-print">
                                        <a href="detail.php?nisn=<?= $item->nisn ?>" class="btn btn-info btn-sm">
                                            <i class="fa fa-eye"></i> Detail
                                        </a>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
include '../../partials/footer.php';
include '../../partials/script.php';
?>