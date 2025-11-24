<?php
include '../../partials/header.php';
include '../../partials/sidebar.php';
include '../../partials/navbar.php';

// Pastikan ada parameter id_spp di URL
if (!isset($_GET['id_spp'])) {
    echo "
    <script>
        alert('Tidak bisa memilih id_spp ini');
        window.location.href='../../pages/spp/index.php';
    </script>
    ";
    exit;
}

$id_spp = $_GET['id_spp'];

// Ambil data spp
$qSelect = "SELECT * FROM spp WHERE id_spp = '$id_spp'";
$result = mysqli_query($connect, $qSelect) or die(mysqli_error($connect));
$spp = $result->fetch_object();
if (!$spp) {
    die("Data spp tidak ditemukan");
}
?>

<!-- content -->
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card m-4 p-3">
                <div class="card-header d-flex justify-content-between align-items-center py-3">
                    <h2>Edit Data SPP</h2>
                </div>
                <div class="card-body">
                    <form action="../../actions/spp/update.php?id_spp=<?= $spp->id_spp ?>" method="POST">

                        <!-- Tahun -->
                        <div class="mb-4">
                            <label for="tahunInput" class="form-label">Tahun</label>
                            <select name="tahun" id="tahunInput" class="form-control" required>
                                <option value="">-- Pilih Tahun --</option>
                                <?php
                                for ($th = 2023; $th <= 2028; $th++) {
                                    $selected = ($spp->tahun == $th) ? 'selected' : '';
                                    echo "<option value='$th' $selected>$th</option>";
                                }
                                ?>
                            </select>
                        </div>

                        <!-- Nominal -->
                        <div class="mb-4">
                            <label for="nominalInput" class="form-label">Nominal</label>
                            <!-- input tampilan (dengan titik) -->
                            <input type="text" id="nominalInput" class="form-control"
                                value="<?= number_format($spp->nominal, 0, ',', '.') ?>" required>

                            <!-- hidden input yang dikirim ke PHP -->
                            <input type="hidden" name="nominal" id="nominalHidden" value="<?= $spp->nominal ?>">

                            <small class="text-muted">Masukkan nominal SPP</small>
                        </div>

                        <button type="submit" class="btn btn-success" name="tombol">Simpan</button>
                        <a href="./index.php" class="btn btn-primary">Kembali</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Script format ribuan -->
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const inputNominal = document.getElementById("nominalInput");
        const hiddenNominal = document.getElementById("nominalHidden");

        // format saat mengetik
        inputNominal.addEventListener("input", function() {
            let value = this.value.replace(/\./g, "");
            if (!isNaN(value) && value !== "") {
                this.value = new Intl.NumberFormat("id-ID").format(value);
                hiddenNominal.value = value; // simpan angka murni ke hidden input
            } else {
                hiddenNominal.value = 0;
            }
        });

        // validasi sebelum submit
        inputNominal.form.addEventListener("submit", function() {
            let value = inputNominal.value.replace(/\./g, "");
            hiddenNominal.value = value; // pastikan hidden selalu isi angka polos
        });
    });
</script>

<?php
include '../../partials/footer.php';
include '../../partials/script.php';
?>