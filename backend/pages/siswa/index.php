<?php
include '../../partials/header.php';
include '../../partials/sidebar.php';
include '../../partials/navbar.php';

$qsiswa = "SELECT 
        siswa.nisn,
        siswa.nis, 
        siswa.nama, 
        siswa.password,
        siswa.alamat, 
        siswa.no_telp, 
        siswa.id_spp,
        spp.tahun,
        kelas.nama_kelas, 
        kelas.kompetensi_keahlian 
    FROM siswa 
    LEFT JOIN kelas ON siswa.id_kelas = kelas.id_kelas
    LEFT JOIN spp ON siswa.id_spp = spp.id_spp
";
$result = mysqli_query($connect, $qsiswa) or die(mysqli_error($connect));
?>

<!-- content -->
<div class="container">
    <div class="page-inner">
        <div class="page-header">
            <h3 class="fw-bold mb-3">Halaman pilih data siswa</h3>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4 class="table-data-title">Table data siswa</h4>
                        <a href="./create.php" class="btn btn-primary d-flex align-items-center">
                            <span class="rounded-circle border border-light d-flex align-items-center justify-content-center me-2" style="width: 28px; height: 28px;">
                                <i class="fa fa-plus"></i>
                            </span>
                            Tambah
                        </a>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="datatable"
                                class="display table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th class="text-center">No</th>
                                        <th class="text-center">Nisn</th>
                                        <th class="text-center">Nis</th>
                                        <th class="text-center">Nama</th>
                                        <th class="text-center">Alamat</th>
                                        <th class="text-center">No_telp</th>
                                        <th class="text-center">Tahun SPP</th>
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
                                            <td class="text-center"><?= $item->nisn ?></td>
                                            <td class="text-center"><?= $item->nis ?></td>
                                            <td class="text-center"><?= $item->nama ?></td>
                                            <td class="text-center"><?= $item->alamat ?></td>
                                            <td class="text-center"><?= $item->no_telp ?></td>
                                            <td class="text-center"><?= $item->tahun ?></td>
                                            <td class="text-center" style="width: 200px;">
                                                <div class="d-flex justify-content-center gap-2">
                                                    <a href="./edit.php?nisn=<?= $item->nisn ?>" class="btn btn-warning btn-sm px-3" title="Edit">
                                                        <i class="fa fa-edit"></i> Ubah
                                                    </a>
                                                    <a href="../../actions/siswa/destroy.php?nisn=<?= $item->nisn ?>"
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