<?php
include '../../partials/header.php';
include '../../partials/sidebar.php';
include '../../partials/navbar.php';

// Ambil data kelas untuk dropdown
$qKelas = mysqli_query($connect, "SELECT * FROM kelas") or die(mysqli_error($connect));

// Ambil data spp untuk dropdown
$qSpp = mysqli_query($connect, "SELECT * FROM spp") or die(mysqli_error($connect));
?>
<div class="container ">
    <div class="row">
        <div class="col-md-12">
            <div class="card m-4 p-3">
                <div class="card-header d-flex justify-content-between align-items-center py-3">
                    <h2>Tambahkan Data Siswa</h2>
                </div>
                <div class="card-body">
                    <form action="../../actions/siswa/store.php" method="post">

                        <div class="mb-4">
                            <label for="nisnInput" class="form-label">NISN</label>
                            <input type="text" name="nisn" class="form-control" id="nisnInput" placeholder="Masukkan NISN..." required>
                        </div>

                        <div class="mb-4">
                            <label for="nisInput" class="form-label">NIS</label>
                            <input type="text" name="nis" class="form-control" id="nisInput" placeholder="Masukkan NIS..." required>
                        </div>

                        <div class="mb-4">
                            <label for="namaInput" class="form-label">Nama Siswa</label>
                            <input type="text" name="nama" class="form-control" id="namaInput" placeholder="Masukkan nama siswa..." required>
                        </div>

                        <div class="mb-3">
                            <label for="passwordInput" class="form-label">Password</label>
                            <input type="password" name="password" id="passwordInput" class="form-control" placeholder="Masukkan password..." required>
                        </div>
                        
                        <div class="mb-4">
                            <label for="id_kelasInput" class="form-label">Kelas</label>
                            <select name="id_kelas" class="form-control" id="id_kelasInput" required>
                                <option value="">-- Pilih Kelas --</option>
                                <?php while ($kelas = $qKelas->fetch_object()) : ?>
                                    <option value="<?= $kelas->id_kelas; ?>">
                                        <?= $kelas->nama_kelas; ?> - <?= $kelas->kompetensi_keahlian; ?>
                                    </option>
                                <?php endwhile; ?>
                            </select>
                        </div>

                        <div class="mb-4">
                            <label for="alamatInput" class="form-label">Alamat</label>
                            <textarea name="alamat" id="alamatInput" class="form-control" placeholder="Masukkan alamat" rows="5"></textarea>
                        </div>

                        <div class="mb-4">
                            <label for="no_telpInput" class="form-label">No. Telepon</label>
                            <input type="text" name="no_telp" class="form-control" id="no_telpInput" placeholder="Masukkan no. telepon..." required>
                        </div>

                        <div class="mb-4">
                            <label for="id_sppInput" class="form-label">Tahun SPP</label>
                            <select name="id_spp" class="form-control" id="id_sppInput" required>
                                <option value="">-- Pilih SPP --</option>
                                <?php while ($spp = $qSpp->fetch_object()) : ?>
                                    <option value="<?= $spp->id_spp; ?>">
                                        Tahun <?= $spp->tahun; ?> - Rp<?= number_format($spp->nominal, 0, ',', '.'); ?>
                                    </option>
                                <?php endwhile; ?>
                            </select>
                        </div>

                        <button type="submit" class="btn btn-success" name="tombol">Tambah</button>
                        <a href="./index.php" class="btn btn-primary">Kembali</a>
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