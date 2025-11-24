<?php
if (!isset($_GET['id_petugas'])) {
    echo "
    <script>    
        alert('Tidak bisa memilih ID ini');
        window.location.href='../../pages/petugas/index.php';
    </script>
    ";
    exit;
}

$id_petugas = $_GET['id_petugas'];

$qSelect = "SELECT * FROM petugas WHERE id_petugas='$id_petugas'";
$result = mysqli_query($connect, $qSelect) or die(mysqli_error($connect));

$petugas = $result->fetch_object();
if (!$petugas) {
    echo "
    <script>    
        alert('Data tidak ditemukan');
        window.location.href='../../pages/petugas/index.php';
    </script>
    ";
    exit;
}
