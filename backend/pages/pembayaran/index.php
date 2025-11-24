<?php
include '../../partials/header.php';
include '../../partials/sidebar.php';
include '../../partials/navbar.php';

$qsiswa = "SELECT 
    siswa.nisn, 
    siswa.nis, 
    siswa.nama, 
    spp.nominal,
    kelas.nama_kelas, 
    kelas.kompetensi_keahlian,
    IFNULL(SUM(pembayaran.jumlah_bayar),0) AS sudah_dibayar
FROM siswa
LEFT JOIN kelas ON siswa.id_kelas = kelas.id_kelas
LEFT JOIN spp ON siswa.id_spp = spp.id_spp
LEFT JOIN pembayaran ON siswa.nisn = pembayaran.nisn
GROUP BY siswa.nisn, siswa.nis, siswa.nama, spp.nominal,
         kelas.nama_kelas, kelas.kompetensi_keahlian
";
$result = mysqli_query($connect, $qsiswa) or die(mysqli_error($connect));
?>

<div class="container">
    <div class="page-inner">
        <div class="page-header">
            <h3 class="fw-bold mb-3">Halaman Data Pembayaran</h3>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4 class="table-data-title">Table Data Pembayaran</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="datatable" class="display table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th class="text-center">No</th>
                                        <th class="text-center">NISN</th>
                                        <th class="text-center">NIS</th>
                                        <th class="text-center">Nama</th>
                                        <th class="text-center">Nominal</th>
                                        <th class="text-center">Sudah Dibayar</th>
                                        <th class="text-center">Sisa</th>
                                        <th class="text-center">Status</th>
                                        <th class="text-center">Selengkapnya</th>
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
                                            <td class="text-center"><?= $item->nis ?></td>
                                            <td class="text-center"><?= $item->nama ?></td>
                                            <td class="text-center">Rp<?= number_format($item->nominal, 0, ',', '.') ?></td>
                                            <td class="text-center">Rp<?= number_format($item->sudah_dibayar, 0, ',', '.') ?></td>
                                            <td class="text-center">Rp<?= number_format($sisa, 0, ',', '.') ?></td>
                                            <td>
                                                <?php if ($sisa > 0): ?>
                                                    <a href="./edit.php?nisn=<?= $item->nisn ?>" class="btn btn-danger btn-sm px-3">
                                                        pilih Bayar
                                                    </a>
                                                <?php else: ?>
                                                    <button class="btn btn-success btn-sm px-3" disabled>
                                                        Sudah Lunas
                                                    </button>
                                                <?php endif; ?>
                                            </td>
                                            <td class="text-center" style="width: 200px;">
                                                <div class="d-flex justify-content-center gap-2">
                                                    <a href="./history.php?nisn=<?= $item->nisn ?>" class="btn btn-info btn-sm px-3">
                                                        <i class="fa fa-history"></i> History
                                                    </a>
                                                    <a href="./detail.php?nisn=<?= $item->nisn ?>" class="btn btn-warning btn-sm px-3">
                                                        <i class="fa fa-eye"></i> Detail
                                                    </a>
                                                </div>
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
    </div>
</div>

<?php
include '../../partials/footer.php';
include '../../partials/script.php';
?>