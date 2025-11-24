<?php
session_start();
if (!isset($_SESSION['level'])) {
    echo "<script>alert('Silakan login dahulu!');window.location.href='../auth/login.php';</script>";
    exit;
}

// Jika login siswa, tendang ke history
if ($_SESSION['level'] === 'siswa') {
    header("Location: ../pembayaran/history2.php?nisn=" . urlencode($_SESSION['id_user']));
    exit;
}

include '../../partials/header.php';
include '../../partials/sidebar.php';
include '../../partials/navbar.php';


if ($_SESSION['level'] != 'admin') {
    echo "
      <script>
        alert('Anda tidak bisa memasuki halaman ini');
        window.location.href='../../pages/dashboard/index.php';
    </script>
    
    ";
}

// Query data petugas (tambahkan id_petugas!)
$qpetugas = "SELECT 
        petugas.id_petugas, 
        petugas.username, 
        petugas.password, 
        petugas.nama_petugas, 
        petugas.level
    FROM petugas
    LEFT JOIN pembayaran ON petugas.id_petugas = pembayaran.id_petugas
";
$result = mysqli_query($connect, $qpetugas) or die(mysqli_error($connect));
?>

<!-- content -->
<div class="container">
    <div class="page-inner">
        <div class="page-header">
            <h3 class="fw-bold mb-3">Tabel Data Petugas</h3>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4 class="table-data-title">Data Petugas</h4>
                        <a href="./create.php" class="btn btn-primary">Tambah</a>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="multi-filter-select" class="display table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>Id petugas</th>
                                        <th>Username</th>
                                        <th>Password</th>
                                        <th>Nama Petugas</th>
                                        <th>Level</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $no = 1;
                                    while ($item = $result->fetch_object()):
                                    ?>
                                        <tr>
                                            <td class="text-center"><?= $no ?></td>
                                            <td><?= $item->username ?></td>
                                            <td>••••••••</td> <!-- Password disensor -->
                                            <td><?= $item->nama_petugas ?></td>
                                            <td><?= $item->level ?></td>
                                            <td class="text-center" style="width: 220px;">
                                                <div class="d-flex justify-content-center gap-2">
                                                    <a href="./edit.php?id_petugas=<?= $item->id_petugas ?>"
                                                        class="btn btn-warning btn-sm px-3"
                                                        title="Edit">
                                                        <i class="fa fa-edit"></i> Edit
                                                    </a>
                                                    <a href="../../actions/petugas/destroy.php?id_petugas=<?= $item->id_petugas ?>"
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