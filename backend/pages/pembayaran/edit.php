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

// Ambil data siswa + total pembayaran
$qSelect = "SELECT siswa.nisn, siswa.nis, siswa.nama, 
        spp.nominal, 
        IFNULL(SUM(pembayaran.jumlah_bayar), 0) AS sudah_dibayar
    FROM siswa
    JOIN spp ON spp.id_spp = siswa.id_spp
    LEFT JOIN pembayaran ON pembayaran.nisn = siswa.nisn
    WHERE siswa.nisn = '$nisn'
    GROUP BY siswa.nisn, siswa.nis, siswa.nama, spp.nominal";
$result = mysqli_query($connect, $qSelect) or die(mysqli_error($connect));
$siswa = $result->fetch_object();
if (!$siswa) {
    die("Data siswa tidak ditemukan");
}

$sisa = $siswa->nominal - $siswa->sudah_dibayar;
?>

<!-- content -->
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card m-4 p-3">
                <div class="card-header d-flex justify-content-between align-items-center py-3">
                    <h5>Edit Pembayaran</h5>
                </div>
                <div class="card-body">
                    <form action="../../actions/pembayaran/update.php?nisn=<?= $siswa->nisn ?>" method="POST">
                        <div class="mb-4">
                            <label class="form-label">Nama Petugas</label>
                            <input type="text" class="form-control"
                                value="<?= htmlspecialchars($_SESSION['nama_petugas'] ?? '') ?>" required>
                        </div>

                        <!-- NISN -->
                        <div class="mb-4">
                            <label for="nisnInput" class="form-label">NISN</label>
                            <input type="text" name="nisn" class="form-control" id="nisnInput"
                                value="<?= $siswa->nisn ?>" required>
                        </div>

                        <!-- Tanggal Bayar -->
                        <div class="mb-4">
                            <label for="tgl_bayar" class="form-label">Tanggal Bayar</label>
                            <input type="date" name="tgl_bayar" class="form-control" id="tgl_bayar" required>
                        </div>

                        <!-- Bulan Dibayar -->
                        <div class="mb-4">
                            <label for="bulanDibayar" class="form-label">Bulan Dibayar</label>
                            <select name="bulan_dibayar" id="bulanDibayar" class="form-control" required>
                                <option value="">-- Pilih Bulan --</option>
                                <?php
                                $bulan = [
                                    "Januari",
                                    "Februari",
                                    "Maret",
                                    "April",
                                    "Mei",
                                    "Juni",
                                    "Juli",
                                    "Agustus",
                                    "September",
                                    "Oktober",
                                    "November",
                                    "Desember"
                                ];
                                foreach ($bulan as $b) {
                                    echo "<option value='$b'>$b</option>";
                                }
                                ?>
                            </select>
                        </div>

                        <!-- Tahun Dibayar -->
                        <div class="mb-4">
                            <label for="tahun_dibayar" class="form-label">Tahun Dibayar</label>
                            <input type="number" name="tahun_dibayar" class="form-control" id="tahun_dibayar"
                                placeholder="Masukan tahun bayar" required>
                        </div>

                        <!-- Jumlah Bayar -->
                        <div class="mb-4">
                            <label for="jumlah_bayar" class="form-label">Jumlah Bayar</label>
                            <!-- Input yang user lihat (ada titik) -->
                            <input type="text" id="jumlah_bayar" class="form-control"
                                value="<?= number_format($sisa, 0, ',', '.') ?>"
                                <?= ($sisa <= 0) ? 'disabled' : '' ?> required>

                            <!-- Hidden input yang dikirim ke PHP -->
                            <input type="hidden" name="jumlah_bayar" id="jumlah_bayar_hidden" value="<?= $sisa ?>">

                            <small class="text-muted">
                                <?php if ($sisa > 0): ?>
                                    Sisa yang harus dibayar: Rp<?= number_format($sisa, 0, ',', '.') ?>
                                <?php else: ?>
                                    <span class="text-success fw-bold">Sudah Lunas</span>
                                <?php endif; ?>
                            </small>
                        </div>

                        <?php if ($sisa > 0): ?>
                            <button type="submit" class="btn btn-success" name="tombol">Simpan</button>
                        <?php else: ?>
                            <button type="button" class="btn btn-secondary" disabled>Sudah Lunas</button>
                        <?php endif; ?>
                        <a href="./index.php" class="btn btn-primary">Kembali</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Script Format Rupiah -->
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const inputBayar = document.getElementById("jumlah_bayar");
        const hiddenBayar = document.getElementById("jumlah_bayar_hidden");
        if (!inputBayar || !hiddenBayar) return;

        const maxBayar = parseInt(hiddenBayar.value);

        // format saat user ketik
        inputBayar.addEventListener("input", function() {
            let value = this.value.replace(/\./g, "");
            if (!isNaN(value) && value !== "") {
                this.value = new Intl.NumberFormat("id-ID").format(value);
                hiddenBayar.value = value; // simpan ke hidden input
            } else {
                hiddenBayar.value = 0;
            }
        });

        // validasi sebelum submit
        inputBayar.form.addEventListener("submit", function(e) {
            let value = hiddenBayar.value;
            if (parseInt(value) > maxBayar) {
                e.preventDefault();
                alert("Jumlah bayar tidak boleh lebih besar dari sisa pembayaran!");
                return false;
            }
        });
    });
</script>

<?php
include '../../partials/footer.php';
include '../../partials/script.php';
?>