<?php
include '../../partials/header.php';
include '../../partials/sidebar.php';
include '../../partials/navbar.php';

// Pastikan ada parameter nisn di URL
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

// Ambil data siswa
$qSelect = "SELECT * FROM siswa WHERE nisn = '$nisn'";
$result = mysqli_query($connect, $qSelect) or die(mysqli_error($connect));
$siswa = $result->fetch_object();
if (!$siswa) {
    die("Data siswa tidak ditemukan");
}

// Ambil data kelas
$qKelas = mysqli_query($connect, "SELECT * FROM kelas") or die(mysqli_error($connect));

// Ambil data SPP
$qSpp = mysqli_query($connect, "SELECT * FROM spp") or die(mysqli_error($connect));
?>

<!-- content -->
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card m-4 p-3">
                <div class="card-header d-flex justify-content-between align-items-center py-3">
                    <h2>Table Edit Data Siswa</h2>
                </div>
                <div class="card-body">
                    <form action="../../actions/siswa/update.php?nisn=<?= $siswa->nisn ?>" method="POST" enctype="multipart/form-data">

                        <div class="mb-4">
                            <label for="nisnInput" class="form-label">NISN</label>
                            <input type="text" name="nisn" class="form-control" id="nisnInput"
                                value="<?= $siswa->nisn ?>" required>
                        </div>

                        <div class="mb-4">
                            <label for="nisInput" class="form-label">NIS</label>
                            <input type="text" name="nis" class="form-control" id="nisInput"
                                value="<?= $siswa->nis ?>" required>
                        </div>

                        <div class="mb-4">
                            <label for="namaInput" class="form-label">Nama Siswa</label>
                            <input type="text" name="nama" class="form-control" id="namaInput"
                                value="<?= $siswa->nama ?>" required>
                        </div>

                        <div class="mb-3">
                            <label for="passwordInput" class="form-label">Password</label>
                            <div class="input-group">
                                <input type="password" name="password" id="passwordInput" class="form-control" placeholder="Kosongkan jika tidak ingin mengubah">
                                <button class="btn btn-outline-secondary" type="button" id="togglePassword">👁</button>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="id_kelasInput" class="form-label">Kelas</label>
                            <select name="id_kelas" class="form-control" id="id_kelasInput" required>
                                <option value="">-- Pilih Kelas --</option>
                                <?php while ($kelas = $qKelas->fetch_object()) : ?>
                                    <option value="<?= $kelas->id_kelas; ?>"
                                        <?= ($kelas->id_kelas == $siswa->id_kelas) ? 'selected' : '' ?>>
                                        <?= $kelas->nama_kelas; ?> - <?= $kelas->kompetensi_keahlian; ?>
                                    </option>
                                <?php endwhile; ?>
                            </select>
                        </div>

                        <div class="mb-4">
                            <label for="alamatInput" class="form-label">Alamat</label>
                            <textarea name="alamat" id="alamatInput" class="form-control" rows="5"><?= $siswa->alamat ?></textarea>
                        </div>

                        <div class="mb-4">
                            <label for="no_telpInput" class="form-label">No. Telepon</label>
                            <input type="text" name="no_telp" class="form-control" id="no_telpInput"
                                value="<?= $siswa->no_telp ?>" required>
                        </div>

                        <div class="mb-4">
                            <label for="id_sppInput" class="form-label">Tahun SPP</label>
                            <select name="id_spp" class="form-control" id="id_sppInput" required>
                                <option value="">-- Pilih SPP --</option>
                                <?php while ($spp = $qSpp->fetch_object()) : ?>
                                    <option value="<?= $spp->id_spp; ?>"
                                        <?= ($spp->id_spp == $siswa->id_spp) ? 'selected' : '' ?>>
                                        Tahun <?= $spp->tahun; ?> - Rp<?= number_format($spp->nominal, 0, ',', '.'); ?>
                                    </option>
                                <?php endwhile; ?>
                            </select>
                        </div>

                        <button type="submit" class="btn btn-success" name="tombol">Simpan</button>
                        <a href="./index.php" class="btn btn-primary">Kembali</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    const togglePassword = document.querySelector("#togglePassword");
    const passwordInput = document.querySelector("#passwordInput");

    togglePassword.addEventListener("click", function() {
        const type = passwordInput.getAttribute("type") === "password" ? "text" : "password";
        passwordInput.setAttribute("type", type);
        this.textContent = type === "password" ? "👁" : "🙈";
    });
</script>

<?php
include '../../partials/footer.php';
include '../../partials/script.php';
?>