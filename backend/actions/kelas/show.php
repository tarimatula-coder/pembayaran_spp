<?php
if (!isset($_GET['id'])) {
    echo "
    <script>    
        alert('Tidak bisa memilih ID ini');
        window.location.href='../../pages/kelas/index.php';
        </script>
    ";
}

$id_kelas = $_GET['id'];

$qSelect = "SELECT * FROM kelas WHERE id_kelas='$id_kelas'";
$result = mysqli_query($connect, $qSelect) or die(mysqli_error($connect));

$kelas = $result->fetch_object();
if (!$kelas) {
    die("Data tidak di temukan");
}
?>