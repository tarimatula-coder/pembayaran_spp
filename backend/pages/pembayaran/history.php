<?php
session_start();
include '../../app.php';

if (!isset($_GET['nisn'])) {
    echo "<script>
        alert('Tidak bisa menampilkan history tanpa NISN'); 
        window.location.href='index.php';
    </script>";
    exit;
}

$nisn = $_GET['nisn'];


$qSiswa = mysqli_query($connect, "SELECT nisn, nama, id_kelas FROM siswa WHERE nisn='$nisn'") or die(mysqli_error($connect));
$siswa = $qSiswa->fetch_object();
if (!$siswa) die("Data siswa tidak ditemukan");

$qKelas = mysqli_query($connect, "SELECT nama_kelas FROM kelas WHERE id_kelas='$siswa->id_kelas'") or die(mysqli_error($connect));
$kelas = $qKelas->fetch_object();
$nama_kelas = $kelas->nama_kelas ?? '-';

if (isset($_POST['hapus_data'])) {
    mysqli_query($connect, "DELETE FROM pembayaran WHERE nisn='$nisn'") or die(mysqli_error($connect));
    echo "<script>
        alert('History pembayaran berhasil dihapus!');
        window.location.href='?nisn=$nisn';
    </script>";
    exit;
}


$qHistory = "SELECT 
        pembayaran.id_pembayaran,
        pembayaran.nisn,
        spp.tahun AS spp_tahun,
        spp.nominal AS spp_nominal,
        pembayaran.jumlah_bayar,
        pembayaran.tgl_bayar,
        pembayaran.nama_petugas
    FROM pembayaran
    LEFT JOIN spp ON pembayaran.id_spp = spp.id_spp
    WHERE pembayaran.nisn='$nisn'
    ORDER BY pembayaran.tgl_bayar ASC
";
$result = mysqli_query($connect, $qHistory) or die(mysqli_error($connect));
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>History Pembayaran SPP</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="icon" href="../../kaiadmin-lite-1.2.0/kaiadmin-lite-1.2.0/assets/img/kaiadmin/icon-pembayaran.png" type="image/png" />
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
    <div class="container-fluid py-3">
        <div class="card card-custom">
            <div class="card-header-custom d-flex flex-wrap justify-content-between align-items-center">
                <h5 class="mb-2 mb-md-0">📑 History Pembayaran</h5>
                <div class="d-flex gap-2 flex-wrap">
                    <form method="post" onsubmit="return confirm('Yakin ingin menghapus semua history pembayaran siswa ini?')">
                        <button type="submit" name="hapus_data" class="btn btn-danger btn-sm no-print">
                            <i class="bi bi-trash"></i> Hapus Data
                        </button>
                    </form>
                    <button class="btn btn-success btn-sm no-print" onclick="window.print()">
                        <i class="bi bi-printer"></i> Cetak
                    </button>
                    <button class="btn btn-light btn-sm no-print" onclick="window.location.href='index.php'">
                        <i class="bi bi-box-arrow-left"></i> Keluar
                    </button>
                </div>
            </div>
            <div class="card-body print-area">
                <?php if (mysqli_num_rows($result) > 0): ?>
                    <div class="table-responsive-sm">
                        <table class="table table-bordered table-striped text-center align-middle">
                            <thead class="table-primary">
                                <tr>
                                    <th>No</th>
                                    <th>NISN</th>
                                    <th>Nama</th>
                                    <th>Kelas</th>
                                    <th>Tahun SPP</th>
                                    <th>Nominal SPP</th>
                                    <th>Sudah Dibayar</th>
                                    <th>Tanggal Bayar</th>
                                    <th>Petugas</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $no = 1;
                                while ($row = $result->fetch_object()):
                                    $spp_nominal = $row->spp_nominal ?? 0;
                                    $jumlah_bayar = $row->jumlah_bayar ?? 0;
                                    $status = ($jumlah_bayar >= $spp_nominal && $spp_nominal > 0) ? "Lunas" : "Belum Lunas";
                                ?>
                                    <tr>
                                        <td><?= $no++ ?></td>
                                        <td><?= htmlspecialchars($row->nisn) ?></td>
                                        <td><?= htmlspecialchars($siswa->nama) ?></td>
                                        <td><?= htmlspecialchars($nama_kelas) ?></td>
                                        <td><?= htmlspecialchars($row->spp_tahun ?? '-') ?></td>
                                        <td>Rp<?= number_format($spp_nominal, 0, ',', '.') ?></td>
                                        <td>Rp<?= number_format($jumlah_bayar, 0, ',', '.') ?></td>
                                        <td><?= isset($row->tgl_bayar) ? date('d-m-Y', strtotime($row->tgl_bayar)) : '-' ?></td>
                                        <td><?= htmlspecialchars($row->nama_petugas ?? '-') ?></td>
                                        <td style="color:black;"><?= $status ?></td>
                                    </tr>
                                <?php endwhile; ?>
                            </tbody>
                        </table>
                    </div>
                <?php else: ?>
                    <div class="text-center py-3">
                        <i class="bi bi-info-circle text-muted fs-3"></i>
                        <p class="text-muted mt-2 mb-0">Belum ada pembayaran untuk siswa ini.</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</body>

</html>