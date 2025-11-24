<?php
include '../../partials/header.php';
include '../../partials/sidebar.php';
include '../../partials/navbar.php';
?>
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card m-4 p-3">
                <div class="card-header d-flex justify-content-between align-items-center py-3">
                    <h2>Tambahkan Data Spp</h2>
                </div>
                <div class="card-body">
                    <form action="../../actions/spp/store.php" method="post">

                        <!-- Tahun -->
                        <div class="mb-4">
                            <label for="tahunInput" class="form-label">Tahun</label>
                            <select name="tahun" id="tahunInput" class="form-control" required>
                                <option value="">-- Pilih Tahun --</option>
                                <option value="2023">2023</option>
                                <option value="2024">2024</option>
                                <option value="2025">2025</option>
                                <option value="2026">2026</option>
                                <option value="2027">2027</option>
                                <option value="2028">2028</option>
                            </select>
                        </div>

                        <!-- Nominal -->
                        <div class="mb-4">
                            <label for="nominalInput" class="form-label">Nominal</label>
                            <select name="nominal" id="nominalInput" class="form-control" required>
                                <option value="">-- Pilih Nominal --</option>
                                <option value="100000">Rp 100.000</option>
                                <option value="150000">Rp 150.000</option>
                                <option value="200000">Rp 200.000</option>
                                <option value="250000">Rp 250.000</option>
                                <option value="300000">Rp 300.000</option>
                                <option value="350000">Rp 350.000</option>
                                <option value="400000">Rp 400.000</option>
                                <option value="450000">Rp 450.000</option>
                                <option value="500000">Rp 500.000</option>
                                <option value="550000">Rp 550.000</option>
                                <option value="600000">Rp 600.000</option>
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