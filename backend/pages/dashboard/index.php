<?php
include '../../partials/header.php';
include '../../partials/sidebar.php';
include '../../partials/navbar.php';

// ===== QUERY DATA SISWA DAN PEMBAYARAN =====
$qSiswa = mysqli_query($connect, "SELECT siswa.nisn, siswa.nis, siswa.nama, siswa.alamat, siswa.no_telp,
    IFNULL(SUM(pembayaran.jumlah_bayar),0) AS total_bayar,
    MAX(pembayaran.tgl_bayar) AS tgl_terakhir
    FROM siswa
    LEFT JOIN pembayaran ON pembayaran.nisn = siswa.nisn
    GROUP BY siswa.nisn, siswa.nis, siswa.nama, siswa.alamat, siswa.no_telp
");

$labelsSiswa = [];
$dataTotalBayar = [];
$infoSiswa = [];

while ($row = mysqli_fetch_assoc($qSiswa)) {
    $labelsSiswa[] = $row['nama'];
    $total = (int)$row['total_bayar'];
    $dataTotalBayar[] = $total;

    $infoSiswa[] = [
        "nama" => $row['nama'],
        "nis" => $row['nis'],
        "nisn" => $row['nisn'],
        "alamat" => $row['alamat'],
        "total_bayar" => $total,
        "tgl_terakhir" => $row['tgl_terakhir'] ? date('d-m-Y', strtotime($row['tgl_terakhir'])) : "-"
    ];
}

// ===== QUERY KELAS =====
$qKelas = mysqli_query($connect, "SELECT nama_kelas, kompetensi_keahlian FROM kelas");
$labelsKelas = [];
$dataKelas = [];
$colorsKelas = [];
while ($row = mysqli_fetch_assoc($qKelas)) {
    $labelsKelas[] = $row['nama_kelas'] . " (" . $row['kompetensi_keahlian'] . ")";
    $dataKelas[] = strlen($row['kompetensi_keahlian']);
    switch (strtoupper($row['kompetensi_keahlian'])) {
        case "PPLG":
            $colorsKelas[] = "rgba(255,165,0,0.7)";
            break;
        case "AKL":
            $colorsKelas[] = "rgba(255,215,0,0.7)";
            break;
        case "PM":
            $colorsKelas[] = "rgba(199,21,133,0.7)";
            break;
        case "TO":
            $colorsKelas[] = "rgba(220,20,60,0.7)";
            break;
        case "MPLB":
            $colorsKelas[] = "rgba(30,144,255,0.7)";
            break;
        default:
            $colorsKelas[] = "rgba(100,100,100,0.7)";
    }
}

// ===== QUERY SPP =====
$qSPP = mysqli_query($connect, "SELECT tahun, nominal FROM spp ORDER BY tahun ASC");
$labelsSPP = [];
$dataSPP = [];
while ($row = mysqli_fetch_assoc($qSPP)) {
    $labelsSPP[] = $row['tahun'];
    $dataSPP[] = (int)$row['nominal'];
}
?>

<div class="container">
    <div class="page-inner">
        <h3 class="fw-bold mb-3">Dashboard Statistik Lengkap</h3>
        <div class="row">
            <!-- Diagram Batang -->
            <div class="col-md-6">
                <div class="card card-round mb-4">
                    <div class="card-header">
                        <h4 class="table-data-title">Diagram Batang SPP</h4>
                    </div>
                    <div class="card-body d-flex justify-content-center">
                        <canvas id="barChart" style="width:420px; height:420px"></canvas>
                    </div>
                </div>
            </div>

            <!-- Diagram Pie -->
            <div class="col-md-6">
                <div class="card card-round mb-4">
                    <div class="card-header">
                        <h4 class="table-data-title">Diagram Pie Kelas & keahlian Kompetensi</h4>
                    </div>
                    <div class="card-body d-flex justify-content-center">
                        <canvas id="pizzaChart" style="width:420px; height:420px"></canvas>
                    </div>
                </div>
            </div>

            <!-- Diagram Gelombang Pembayaran Slayer -->
            <div class="col-md-12">
                <div class="card card-round mb-4">
                    <div class="card-header">
                        <h4 class="table-data-title">Diagram gelombang siswa dan Pembayaran</h4>
                    </div>
                    <div class="card-body">
                        <canvas id="wavePaymentChart" style="min-height:400px"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const siswaInfo = <?= json_encode($infoSiswa) ?>;

    // Diagram Batang SPP
    new Chart(document.getElementById("barChart"), {
        type: "bar",
        data: {
            labels: <?= json_encode($labelsSPP) ?>,
            datasets: [{
                label: "Nominal SPP",
                data: <?= json_encode($dataSPP) ?>,
                backgroundColor: "rgba(54,162,235,0.7)",
                borderColor: "rgba(54,162,235,1)",
                borderWidth: 1
            }]
        },
        options: {
            responsive: false,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });

    // Diagram Pie Kelas
    const centerDotPlugin = {
        id: 'centerDot',
        afterDraw: (chart) => {
            const {
                ctx,
                chartArea: {
                    left,
                    right,
                    top,
                    bottom
                }
            } = chart;
            const x = (left + right) / 2;
            const y = (top + bottom) / 2;
            ctx.save();
            ctx.beginPath();
            ctx.arc(x, y, 8, 0, 2 * Math.PI);
            ctx.fillStyle = "#333";
            ctx.fill();
            ctx.restore();
        }
    };
    new Chart(document.getElementById("pizzaChart"), {
        type: "pie",
        data: {
            labels: <?= json_encode($labelsKelas) ?>,
            datasets: [{
                data: <?= json_encode($dataKelas) ?>,
                backgroundColor: <?= json_encode($colorsKelas) ?>,
                borderColor: "#fff",
                borderWidth: 2
            }]
        },
        options: {
            responsive: false,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: "bottom"
                }
            }
        },
        plugins: [centerDotPlugin]
    });

    // Diagram Gelombang Slayer (Total Bayar + Info Lengkap)
    const ctxWave = document.getElementById("wavePaymentChart").getContext("2d");
    const gradient = ctxWave.createLinearGradient(0, 0, 0, 400);
    gradient.addColorStop(0, 'rgba(255,99,132,0.5)');
    gradient.addColorStop(1, 'rgba(255,99,132,0)');

    new Chart(ctxWave, {
        type: 'line',
        data: {
            labels: <?= json_encode($labelsSiswa) ?>,
            datasets: [{
                label: "Total Bayar",
                data: <?= json_encode($dataTotalBayar) ?>,
                borderColor: "rgba(255,99,132,1)",
                backgroundColor: gradient,
                fill: true,
                tension: 0.4,
                borderWidth: 3,
                pointRadius: 5,
                pointBackgroundColor: "rgba(255,99,132,1)"
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: "top"
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            const i = context.dataIndex;
                            const siswa = siswaInfo[i];
                            return [
                                "Nama: " + siswa.nama,
                                "NIS: " + siswa.nis,
                                "NISN: " + siswa.nisn,
                                "Alamat: " + siswa.alamat,
                                "Total Bayar: Rp" + siswa.total_bayar.toLocaleString('id-ID'),
                                "Tanggal Terakhir: " + siswa.tgl_terakhir
                            ];
                        }
                    }
                }
            },
            interaction: {
                mode: "nearest",
                intersect: false
            },
            scales: {
                x: {
                    grid: {
                        display: false
                    }
                },
                y: {
                    beginAtZero: true,
                    title: {
                        display: true,
                        text: "Total Bayar (Rp)"
                    },
                    grid: {
                        color: "rgba(200,200,200,0.2)"
                    }
                }
            }
        }
    });
</script>

<?php
include '../../partials/footer.php';
include '../../partials/script.php';
?>