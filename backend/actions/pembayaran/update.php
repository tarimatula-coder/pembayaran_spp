<?php
session_start();
include '../../app.php';

// ===== CEK LOGIN ADMIN/PETUGAS =====
if (!isset($_SESSION['level']) || !in_array($_SESSION['level'], ['petugas', 'admin'])) {
    echo "<script>
        alert('Anda tidak punya akses!');
        window.location.href = '../../pages/auth/login.php';
    </script>";
    exit;
}

$id_petugas = $_SESSION['id_petugas'] ?? null;
$nama_petugas = $_SESSION['nama_petugas'] ?? ''; // ambil dari session login

if (!$id_petugas || empty($nama_petugas)) {
    echo "<script>
        alert('Session petugas tidak valid');
        window.location.href = '../../pages/auth/login.php';
    </script>";
    exit;
}

if (isset($_POST['tombol'])) {
    $nisn = htmlspecialchars($_POST['nisn']);
    $jumlah_bayar = isset($_POST['jumlah_bayar']) ? (int)$_POST['jumlah_bayar'] : 0;

    if ($jumlah_bayar <= 0) {
        echo "<script>
            alert('Jumlah bayar harus lebih dari 0');
            window.location.href='../../pages/pembayaran/edit.php?nisn=$nisn';
        </script>";
        exit;
    }

    // ===== Ambil id_spp siswa =====
    $stmt = $connect->prepare("SELECT id_spp FROM siswa WHERE nisn = ?");
    if (!$stmt) die("Prepare failed: " . $connect->error);

    $stmt->bind_param("s", $nisn);
    $stmt->execute();
    $stmt->bind_result($id_spp);

    if (!$stmt->fetch()) {
        $stmt->close();
        echo "<script>
            alert('Siswa tidak ditemukan');
            window.location.href = '../../pages/pembayaran/index.php';
        </script>";
        exit;
    }
    $stmt->close();

    $tgl_bayar = date('Y-m-d');
    $bulan_dibayar = date('m');
    $tahun_dibayar = date('Y');

    // ===== Insert pembayaran =====
    $stmtInsert = $connect->prepare(" INSERT INTO pembayaran 
        (id_petugas, nisn, tgl_bayar, bulan_dibayar, tahun_dibayar, id_spp, jumlah_bayar, nama_petugas) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?)
    ");
    if (!$stmtInsert) die("Prepare failed: " . $connect->error);

    $stmtInsert->bind_param(
        "isssiiss",
        $id_petugas,
        $nisn,
        $tgl_bayar,
        $bulan_dibayar,
        $tahun_dibayar,
        $id_spp,
        $jumlah_bayar,
        $nama_petugas
    );

    if ($stmtInsert->execute()) {
        echo "<script>
            alert('Pembayaran berhasil disimpan');
            window.location.href='../../pages/pembayaran/index.php';
        </script>";
    } else {
        echo "<script>
            alert('Pembayaran gagal disimpan');
            window.location.href='../../pages/pembayaran/edit.php?nisn=$nisn';
        </script>";
    }

    $stmtInsert->close();
}
