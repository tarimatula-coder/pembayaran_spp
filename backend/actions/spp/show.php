<?php
if (!isset($_GET['id_spp'])) {
    echo "
    <script>    
        alert('Tidak bisa memilih ID ini');
        window.location.href='../../pages/spp/index.php';
        </script>
    ";
}

$id_spp = $_GET['id_spp'];

$qSelect = "SELECT * FROM spp WHERE id_spp='$id_spp'";
$result = mysqli_query($connect, $qSelect) or die(mysqli_error($connect));

$spp = $result->fetch_object();
if (!$spp) {
    die("Data tidak di temukan");
}
?>