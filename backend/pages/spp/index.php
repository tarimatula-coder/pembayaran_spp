<?php
include '../../partials/header.php';
include '../../partials/sidebar.php';
include '../../partials/navbar.php';

$qspp = "SELECT spp.id_spp, spp.tahun, spp.nominal FROM spp LEFT JOIN siswa ON spp.id_spp = siswa.id_spp";
$result = mysqli_query($connect, $qspp) or die(mysqli_error($connect));
?>

<!-- content -->
<div class="container">
    <div class="page-inner">
        <div class="page-header">
            <h3 class="fw-bold mb-3">Halaman pilih data</h3>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4 class="table-data-title">Table data spp</h4>
                        <a href="./create.php" class="btn btn-primary d-flex align-items-center">
                            <span class="rounded-circle border border-light d-flex align-items-center justify-content-center me-2" style="width: 28px; height: 28px;">
                                <i class="fa fa-plus"></i>
                            </span>
                            Tambah
                        </a>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table
                                id="datatable"
                                class="display table table-hover">
                                <thead>
                                    <tr>
                                        <th class="text-center">No</th>
                                        <th class="text-center">Tahun</th>
                                        <th class="text-center">Nominal</th>
                                        <th class="text-center">Selengkapnya</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $no = 1;
                                    while ($item = $result->fetch_object()):
                                    ?>
                                        <tr>
                                            <td class="text-center"><?= $no++ ?></td>
                                            <td class="text-center"><?= $item->tahun ?></td>
                                            <td class="text-center">Rp<?= number_format($item->nominal, 0, ',', '.') ?></td>
                                            <td class="text-center" style="width: 200px;">
                                                <div class="d-flex justify-content-center gap-2">
                                                    <a href="./edit.php?id_spp=<?= $item->id_spp ?>" class="btn btn-warning btn-sm px-3" title="Edit">
                                                        <i class="fa fa-edit"></i> Ubah
                                                    </a>
                                                    <a href="../../actions/spp/destroy.php?id_spp=<?= $item->id_spp ?>"
                                                        class="btn btn-danger btn-sm px-3"
                                                        onclick="return confirm('Apakah anda yakin?')"
                                                        title="Hapus">
                                                        <i class="fa fa-trash"></i> Hapus
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php
                                    endwhile;
                                    ?>
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