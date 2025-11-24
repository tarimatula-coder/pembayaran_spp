<?php
if (!isset($_GET['nisn'])) {
    echo "
    <script>    
        alert('Tidak bisa memilih data siswa');
        window.location.href='../../pages/siswa/index.php';
    </script>
    ";
    exit;
}

$nisn = $_GET['nisn'];

$qSelect = "SELECT * FROM siswa WHERE nisn='$nisn'";
$result = mysqli_query($connect, $qSelect) or die(mysqli_error($connect));

$siswa = $result->fetch_object();
if (!$siswa) {
    die("Data tidak ditemukan");
}
?>