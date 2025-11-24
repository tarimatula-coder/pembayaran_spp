<?php
include '../../partials/header.php';
include '../../partials/sidebar.php';
include '../../partials/navbar.php';

// Ambil data kelas
$qspp = "SELECT kelas.id_kelas, kelas.nama_kelas, kelas.kompetensi_keahlian 
         FROM kelas 
         LEFT JOIN siswa ON kelas.id_kelas = siswa.id_kelas";
$result = mysqli_query($connect, $qspp) or die(mysqli_error($connect));
?>

<!-- content -->
<div class="container">
    <div class="page-inner">
        <div class="page-header">
            <h3 class="fw-bold mb-3">Halaman pilih data kelas</h3>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4 class="table-data-title">Table data kelas</h4>
                        <a href="./create.php" class="btn btn-primary d-flex align-items-center">
                            <span class="rounded-circle border border-light d-flex align-items-center justify-content-center me-2" style="width: 28px; height: 28px;">
                                <i class="fa fa-plus"></i>
                            </span>
                            Tambah
                        </a>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="datatable" class="display table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th class="text-center">No</th>
                                        <th class="text-center">Nama Kelas</th>
                                        <th class="text-center">Kompetensi Keahlian</th>
                                        <th class="text-center">Selengkapnya</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $no = 1;
                                    while ($item = $result->fetch_object()):
                                    ?>
                                        <tr>
                                            <td class="text-center"><?= $no ?></td>
                                            <td class="text-center"><?= $item->nama_kelas ?></td>
                                            <td class="text-center"><?= $item->kompetensi_keahlian ?></td>
                                            <td class="text-center" style="width: 250px;">
                                                <div class="d-flex justify-content-center gap-2">
                                                    <a href="./edit.php?id=<?= $item->id_kelas ?>" class="btn btn-warning btn-sm px-3" title="Edit">
                                                        <i class="fa fa-edit"></i> Ubah
                                                    </a>
                                                    <a href="../../actions/kelas/destroy.php?id=<?= $item->id_kelas ?>"
                                                        class="btn btn-danger btn-sm px-3"
                                                        onclick="return confirm('Apakah anda yakin ingin menghapus data ini?')"
                                                        title="Hapus">
                                                        <i class="fa fa-trash"></i> Hapus
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php
                                        $no++;
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