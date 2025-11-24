<?php
// sidebar.php

$level = $_SESSION['level'] ?? '';
$current_file = basename($_SERVER['PHP_SELF']);
$current_dir  = basename(dirname($_SERVER['PHP_SELF']));
?>

<div class="sidebar" data-background-color="dark">
    <div class="sidebar-logo">
        <!-- Logo Header -->
        <div class="logo-header d-flex align-items-center" data-background-color="dark" style="padding: 10px;">
            <a href="../dashboard/index.php" class="logo d-flex align-items-center" style="text-decoration: none;">
                <img
                    src="../../kaiadmin-lite-1.2.0/kaiadmin-lite-1.2.0/assets/img/kaiadmin/icon-pembayaran.png"
                    alt="Logo"
                    height="40"
                    style="margin-right: 10px;" />
                <span style="color: white; font-weight: bold; font-size: 20px;">
                    Pembayaran SPP
                </span>
            </a>
        </div>
    </div>
    
    <div class="sidebar-wrapper scrollbar scrollbar-inner">
        <div class="sidebar-content">
            <ul class="nav nav-secondary">

                <?php if ($level === "admin"): ?>
                    <!-- Menu Admin: semua kecuali petugas -->
                    <li class="nav-item <?= $current_dir == 'dashboard' ? 'active' : '' ?>">
                        <a href="../dashboard/index.php">
                            <i class="fas fa-home"></i>
                            <p>Dashboard</p>
                        </a>
                    </li>
                    <li class="nav-item <?= $current_dir == 'siswa' ? 'active' : '' ?>">
                        <a href="../siswa/index.php">
                            <i class="fas fa-users"></i>
                            <p>Siswa</p>
                        </a>
                    </li>
                    <li class="nav-item <?= $current_dir == 'kelas' ? 'active' : '' ?>">
                        <a href="../kelas/index.php">
                            <i class="fas fa-school"></i>
                            <p>Kelas</p>
                        </a>
                    </li>
                    <li class="nav-item <?= $current_dir == 'spp' ? 'active' : '' ?>">
                        <a href="../spp/index.php">
                            <i class="fas fa-file-invoice"></i>
                            <p>SPP</p>
                        </a>
                    </li>
                    <li class="nav-item <?= $current_dir == 'pembayaran' ? 'active' : '' ?>">
                        <a href="../pembayaran/index.php">
                            <i class="fas fa-money-bill-wave"></i>
                            <p>Pembayaran</p>
                        </a>
                    </li>
                    <li class="nav-item <?= $current_dir == 'laporan' ? 'active' : '' ?>">
                        <a href="../laporan/index.php">
                            <i class="fas fa-file-alt"></i>
                            <p>Laporan</p>
                        </a>
                    </li>

                <?php elseif ($level === "petugas"): ?>
                    <!-- Menu Petugas: hanya pembayaran -->
                    <li class="nav-item <?= $current_dir == 'pembayaran' ? 'active' : '' ?>">
                        <a href="../pembayaran/index.php">
                            <i class="fas fa-money-bill-wave"></i>
                            <p>Pembayaran</p>
                        </a>
                    </li>

                <?php elseif ($level === "siswa"): ?>
                    <!-- Menu Siswa: hanya history -->
                    <li class="nav-item <?= $current_file == 'history2.php' ? 'active' : '' ?>">
                        <a href="../pembayaran/history2.php?nisn=<?= urlencode($_SESSION['id_user']) ?>">
                            <i class="fas fa-history"></i>
                            <p>History Pembayaran</p>
                        </a>
                    </li>
                <?php endif; ?>

                <!-- Logout selalu ada -->
                <li class="nav-item">
                    <a href="../../actions/auth/logout.php">
                        <i class="fas fa-sign-out-alt"></i>
                        <p>Logout</p>
                    </a>
                </li>

            </ul>
        </div>
    </div>
</div>