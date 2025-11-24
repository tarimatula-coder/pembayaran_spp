<?php
session_start();
include '../../app.php';

// pastikan hanya siswa yang bisa akses
if (!isset($_SESSION['level']) || $_SESSION['level'] !== 'siswa') {
    echo "<script>alert('Akses ditolak! Silakan login sebagai siswa.');window.location.href='../auth/login.php';</script>";
    exit;
}

$nisn = $_SESSION['id_user'];

// ambil data siswa
$qSiswa = mysqli_query($connect, "SELECT nisn, nama, id_kelas FROM siswa WHERE nisn='$nisn'") or die(mysqli_error($connect));
$siswa = $qSiswa->fetch_object();

// ambil kelas
$qKelas = mysqli_query($connect, "SELECT nama_kelas FROM kelas WHERE id_kelas='$siswa->id_kelas'") or die(mysqli_error($connect));
$kelas = $qKelas->fetch_object();
$nama_kelas = $kelas->nama_kelas ?? '-';

// ambil history pembayaran termasuk nama petugas
$qHistory = "
    SELECT spp.tahun AS spp_tahun, spp.nominal AS spp_nominal,
           pembayaran.jumlah_bayar, pembayaran.tgl_bayar,
           pembayaran.nama_petugas
    FROM pembayaran
    LEFT JOIN spp ON pembayaran.id_spp = spp.id_spp
    WHERE pembayaran.nisn='$nisn'
    ORDER BY pembayaran.tgl_bayar ASC
";
$result = mysqli_query($connect, $qHistory);
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1"> <!-- Biar mobile friendly -->
    <title>History Pembayaran Siswa</title>

    <!-- ================= FAVICON ================= -->
    <link rel="icon" href="../../kaiadmin-lite-1.2.0/kaiadmin-lite-1.2.0/assets/img/kaiadmin/icon-pembayaran.png" type="image/png" />
    <link rel="apple-touch-icon" sizes="180x180" href="../../kaiadmin-lite-1.2.0/kaiadmin-lite-1.2.0/assets/img/kaiadmin/icon-pembayaran.png">
    <link rel="icon" sizes="192x192" href="../../kaiadmin-lite-1.2.0/kaiadmin-lite-1.2.0/assets/img/kaiadmin/icon-pembayaran.png">

    <!-- Bootstrap & Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

    <style>
        @media print {

            body,
            html {
                margin: 0;
                padding: 0;
                width: 100%;
                font-size: 11px;
            }

            body * {
                visibility: hidden;
            }

            .print-area,
            .print-area * {
                visibility: visible;
            }

            .print-area {
                margin: 0 auto;
                width: 100%;
                page-break-after: auto;
            }

            .no-print {
                display: none !important;
            }

            thead {
                display: table-header-group;
            }
        }

        .card-custom {
            border-radius: 12px;
            border: 1px solid #ddd;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.05);
        }

        .card-header-custom {
            background: linear-gradient(90deg, #4e73df, #224abe);
            color: #fff;
            padding: 15px 20px;
            border-radius: 12px 12px 0 0;
        }

        .info-siswa {
            margin-bottom: 15px;
            padding: 10px;
            background: #f8f9fa;
            border-left: 4px solid #4e73df;
            border-radius: 6px;
        }

        .table-responsive {
            overflow-x: auto;
        }
    </style>
</head>

<body>
    <div class="container py-4">
        <div class="card card-custom">
            <div class="card-header-custom d-flex flex-wrap justify-content-between align-items-center">
                <h5 class="mb-2 mb-md-0">📑 History Pembayaran</h5>
                <div class="d-flex gap-2">
                    <button onclick="window.print()" class="btn btn-success btn-sm no-print">
                        <i class="bi bi-printer"></i> Cetak
                    </button>
                    <a href="../../actions/auth/logout.php" class="btn btn-danger btn-sm no-print">
                        <i class="bi bi-box-arrow-right"></i> Logout
                    </a>
                </div>
            </div>
            <div class="card-body">
                <?php if (mysqli_num_rows($result) > 0): ?>
                    <div class="table-responsive-sm print-area">
                        <table class="table align-middle table-bordered table-striped text-center">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>NISN</th>
                                    <th>Nama</th>
                                    <th>Kelas</th>
                                    <th>Tahun SPP</th>
                                    <th>Nominal</th>
                                    <th>Sudah Dibayar</th>
                                    <th>Tanggal Bayar</th>
                                    <th>Petugas</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1;
                                while ($row = $result->fetch_object()):
                                    $spp_nominal = $row->spp_nominal ?? 0;
                                    $jumlah_bayar = $row->jumlah_bayar ?? 0;
                                    $status = ($jumlah_bayar >= $spp_nominal && $spp_nominal > 0) ? "Lunas" : "Belum Lunas";
                                ?>
                                    <tr>
                                        <td><?= $no++ ?></td>
                                        <td><?= htmlspecialchars($siswa->nisn) ?></td>
                                        <td><?= htmlspecialchars($siswa->nama) ?></td>
                                        <td><?= htmlspecialchars($nama_kelas) ?></td>
                                        <td><?= htmlspecialchars($row->spp_tahun ?? '-') ?></td>
                                        <td>Rp<?= number_format($spp_nominal, 0, ',', '.') ?></td>
                                        <td>Rp<?= number_format($jumlah_bayar, 0, ',', '.') ?></td>
                                        <td><?= $row->tgl_bayar ? date('d-m-Y', strtotime($row->tgl_bayar)) : '-' ?></td>
                                        <td><?= htmlspecialchars($row->nama_petugas ?? '-') ?></td>
                                        <td><span class="status-text"><?= $status ?></span></td>
                                    </tr>
                                <?php endwhile; ?>
                            </tbody>
                        </table>
                    </div>
                <?php else: ?>
                    <p class="text-muted">Belum ada pembayaran untuk siswa ini.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</body>

</html>