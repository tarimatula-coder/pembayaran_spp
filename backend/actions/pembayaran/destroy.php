<?php
include '../../app.php';

// Pastikan ada parameter id dan nisn
if (!isset($_GET['nisn'])) {
    echo "<script>alert('Data tidak valid'); window.location.href='../pages/pembayaran/index.php';</script>";
    exit;
}

$nisn = $_GET['nisn'];

// Hapus pembayaran per baris
$qDelete = "DELETE FROM pembayaran WHERE nisn = $nisn";
if (mysqli_query($connect, $qDelete)) {
    echo "<script>alert('Pembayaran berhasil dihapus'); window.location.href='../../pages/pembayaran/index.php?nisn=$nisn';</script>";
} else {
    echo "<script>alert('Gagal menghapus pembayaran: " . mysqli_error($connect) . "'); window.location.href='../pages/pembayaran/index.php?nisn=$nisn';</script>";
}
