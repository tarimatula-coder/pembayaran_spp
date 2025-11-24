<?php
include '../../app.php';

if (isset($_POST['tombol'])) {
    $tahun = escapeString($_POST['tahun']);
    $nominal = escapeString($_POST['nominal']);

    $qInsert = "INSERT INTO spp (tahun, nominal) 
            VALUES ('$tahun','$nominal')";

    mysqli_query($connect, $qInsert) or die(mysqli_error($connect));
    echo " 
    <script>    
        alert('Data berhasil ditambah');
        window.location.href='../../pages/spp/index.php';
    </script>
            ";
} else {
    echo "
    <script>    
        alert('Data gagal ditambah');
        window.location.href='../../pages/spp/create.php';
    </script>
    ";
}
?>
