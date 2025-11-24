<?php
include '../../partials/header.php';
include '../../partials/sidebar.php';
include '../../partials/navbar.php';
?>

<!-- content -->
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <!-- Card dengan margin semua sisi -->
            <div class="card m-4 p-3"> <!-- m-4 = margin atas/kanan/bawah/kiri, p-3 = padding dalam card -->
                <div class="card-header d-flex justify-content-between align-items-center py-3">
                    <h5 class="mb-0">Tabel edit data guru</h5>
                </div>
                <div class="card-body">
                    <?php
                    include '../../actions/kelas/show.php';
                    ?>
                    <form action="../../actions/kelas/update.php?id=<?= $kelas->id_kelas ?>" method="POST" enctype="multipart/form-data">

                        <!-- Nama Kelas -->
                        <div class="mb-4">
                            <label for="nama_kelasInput" class="form-label">Nama Kelas</label>
                            <select name="nama_kelas" id="nama_kelasInput" class="form-control" required>
                                <option value="">-- Pilih Nama Kelas --</option>
                                <option value="X">X</option>
                                <option value="XI">XI</option>
                                <option value="XII">XII</option>
                            </select>
                        </div>

                        <!-- Kompetensi Keahlian -->
                        <div class="mb-4">
                            <label for="kompetensi_keahlianInput" class="form-label">Kompetensi Keahlian</label>
                            <select name="kompetensi_keahlian" id="kompetensi_keahlianInput" class="form-control" required>
                                <option value="">-- Pilih Kompetensi Keahlian --</option>
                                <option value="PPLG">Pengembangan perangkat lunak dan gim</option>
                                <option value="MPLB">Manajemen Perkantoran dan Layanan Bisnis</option>
                                <option value="AKL">Akuntansi dan Keuangan Lembaga</option>
                                <option value="TO">Teknik Otomotif atau Teknik Otomasi Industri</option>
                                <option value="PM">Pemasaran</option>
                            </select>
                        </div>

                        <!-- Tombol -->
                        <div class="mt-3">
                            <button type="submit" class="btn btn-success" name="tombol">Simpan</button>
                            <a href="./index.php" class="btn btn-primary">Kembali</a>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
include '../../partials/footer.php';
include '../../partials/script.php';
?>