<?php
session_start();
include '../../app.php';
// mengecek apakah user sudah login
if (!isset($_SESSION['level'])) {
    echo " 
         <script>    
              alert('anda harus login dahulu');
              window.location.href='../auth/login.php';
          </script>
           ";
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>Aplikasi pembayaran spp</title>
    <meta content="width=device-width, initial-scale=1.0, shrink-to-fit=no" name="viewport" />

    <!-- ================= FAVICON ================= -->
    <link rel="icon" href="../../kaiadmin-lite-1.2.0/kaiadmin-lite-1.2.0/assets/img/kaiadmin/icon-pembayaran.png" type="image/png" />
    <link rel="apple-touch-icon" sizes="180x180" href="../../kaiadmin-lite-1.2.0/kaiadmin-lite-1.2.0/assets/img/kaiadmin/icon-pembayaran.png">
    <link rel="icon" sizes="192x192" href="../../kaiadmin-lite-1.2.0/kaiadmin-lite-1.2.0/assets/img/kaiadmin/icon-pembayaran.png">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <!-- Tabler Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css">

    <!-- DataTables -->
    <link rel="stylesheet" href="https://cdn.datatables.net/2.3.4/css/dataTables.dataTables.css" />
    <script src="https://cdn.datatables.net/2.3.4/js/dataTables.js"></script>

    <!-- Fonts and icons -->
    <script src="../../kaiadmin-lite-1.2.0/kaiadmin-lite-1.2.0/assets/js/plugin/webfont/webfont.min.js"></script>
    <script>
        WebFont.load({
            google: {
                families: ["Public Sans:300,400,500,600,700"]
            },
            custom: {
                families: [
                    "Font Awesome 5 Solid",
                    "Font Awesome 5 Regular",
                    "Font Awesome 5 Brands",
                    "simple-line-icons",
                ],
                urls: ["../../kaiadmin-lite-1.2.0/kaiadmin-lite-1.2.0/assets/css/fonts.min.css"],
            },
            active: function() {
                sessionStorage.fonts = true;
            },
        });
    </script>

    <!-- CSS Files -->
    <link rel="stylesheet" href="../../kaiadmin-lite-1.2.0/kaiadmin-lite-1.2.0/assets/css/bootstrap.min.css" />
    <link rel="stylesheet" href="../../kaiadmin-lite-1.2.0/kaiadmin-lite-1.2.0/assets/css/plugins.min.css" />
    <link rel="stylesheet" href="../../kaiadmin-lite-1.2.0/kaiadmin-lite-1.2.0/assets/css/kaiadmin.min.css" />

    <!-- CSS Just for demo purpose, don't include it in your project -->
    <link rel="stylesheet" href="../../kaiadmin-lite-1.2.0/kaiadmin-lite-1.2.0/assets/css/demo.css" />
</head>

<body>