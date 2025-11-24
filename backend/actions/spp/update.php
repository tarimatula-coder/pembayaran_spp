<?php
include '../../app.php';
include './show.php';

if (isset($_POST['tombol'])) {
    $tahun = escapeString($_POST['tahun']);
    $nominal = escapeString($_POST['nominal']);

    $qUpdate = "UPDATE spp SET tahun='$tahun', nominal='$nominal' WHERE id_spp='$id_spp'";

    $result = mysqli_query($connect, $qUpdate) or die(mysqli_error($connect));
    if ($result) {
        echo " 
         <script>    
            alert('Data berhasil diubah');
            window.location.href='../../pages/spp/index.php';
        </script>
            ";
    } else {
        echo "
         <script>    
            alert('Data gagal diubah');
            window.location.href='../../pages/spp/create.php';
         </script>
     ";
    }
}
?>