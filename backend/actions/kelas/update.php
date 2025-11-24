<?php
include '../../app.php';
include './show.php';

if (isset($_POST['tombol'])) {
    $nama_kelas = escapeString($_POST['nama_kelas']);
    $kompetensi_keahlian = escapeString($_POST['kompetensi_keahlian']);

    $qUpdate = "UPDATE kelas SET nama_kelas='$nama_kelas', kompetensi_keahlian='$kompetensi_keahlian' WHERE id_kelas='$id_kelas'";

    $result = mysqli_query($connect, $qUpdate) or die(mysqli_error($connect));
    if ($result) {
        echo " 
         <script>    
            alert('Data berhasil diubah');
            window.location.href='../../pages/kelas/index.php';
        </script>
            ";
    } else {
        echo "
         <script>    
            alert('Data gagal diubah');
            window.location.href='../../pages/kelas/create.php';
         </script>
     ";
    }
}
?>