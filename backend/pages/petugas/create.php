<?php
include '../../partials/header.php';
include '../../partials/sidebar.php';
include '../../partials/navbar.php';
?>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5>Tambahkan Data Petugas</h5>
            </div>
            <div class="card-body">
                <form action="../../actions/petugas/store.php" method="post">

                    <!-- Username -->
                    <div class="mb-3">
                        <label for="usernameInput" class="form-label">Username</label>
                        <input type="text" name="username" id="usernameInput" class="form-control" placeholder="Masukkan username..." required>
                    </div>

                    <!-- Nama Petugas -->
                    <div class="mb-3">
                        <label for="nama_petugasInput" class="form-label">Nama Petugas</label>
                        <input type="text" name="nama_petugas" id="nama_petugasInput" class="form-control" placeholder="Masukkan nama petugas..." required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="passwordInput" class="form-label">Password</label>
                        <input type="password" name="password" id="passwordInput" class="form-control" placeholder="Masukkan password..." required>
                    </div>

                    <!-- Level -->
                    <div class="mb-3">
                        <label for="levelInput" class="form-label">Level</label>
                        <select name="level" id="levelInput" class="form-control" required>
                            <option value="">-- Pilih Level --</option>
                            <option value="admin">Admin</option>
                            <option value="petugas">Petugas</option>
                        </select>
                    </div>

                    <button type="submit" class="btn btn-success" name="tombol">Tambah</button>
                    <a href="./index.php" class="btn btn-primary">Kembali</a>
                </form>
            </div>
        </div>
    </div>
</div>

<?php
include '../../partials/footer.php';
include '../../partials/script.php';
?>