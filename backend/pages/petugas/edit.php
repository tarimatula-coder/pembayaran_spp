<?php
include '../../partials/header.php';
include '../../partials/sidebar.php';
include '../../partials/navbar.php';
?>

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5>Edit Data Guru</h5>
                </div>
                <div class="card-body">
                    <?php
                    // Ambil data petugas dari show.php
                    include '../../actions/petugas/show.php';
                    // Pastikan show.php mengisi variabel $petugas
                    ?>
                    <form action="../../actions/petugas/update.php" method="POST">
                        <input type="hidden" name="id_petugas" value="<?= $petugas->id_petugas ?>">

                        <div class="mb-3">
                            <label>Username</label>
                            <input type="text" name="username" class="form-control" value="<?= $petugas->username ?>" required>
                        </div>

                        <div class="mb-3">
                            <label>Nama Petugas</label>
                            <input type="text" name="nama_petugas" class="form-control" value="<?= $petugas->nama_petugas ?>" required>
                        </div>
                        
                        <div class="mb-3">
                            <label for="passwordInput" class="form-label">Password</label>
                            <input type="password" name="password" id="passwordInput" class="form-control" placeholder="Masukkan password..." required>
                        </div>

                        <div class="mb-3">
                            <label>Level</label>
                            <select name="level" class="form-control" required>
                                <option value="admin" <?= $petugas->level == 'admin' ? 'selected' : '' ?>>Admin</option>
                                <option value="petugas" <?= $petugas->level == 'petugas' ? 'selected' : '' ?>>Petugas</option>
                            </select>
                        </div>

                        <button type="submit" name="tombol" class="btn btn-success">Simpan</button>
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

<!-- Script untuk tombol mata password -->
<script>
    const togglePassword = document.querySelector('#togglePassword');
    const passwordInput = document.querySelector('#passwordInput');

    togglePassword.addEventListener('click', function() {
        const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
        passwordInput.setAttribute('type', type);
        this.querySelector('i').classList.toggle('bi-eye');
        this.querySelector('i').classList.toggle('bi-eye-slash');
    });
</script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">