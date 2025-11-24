<?php
include '../../app.php';

if (isset($_POST['tombol'])) {
    $nama_kelas = escapeString($_POST['nama_kelas']);
    $kompetensi_keahlian = escapeString($_POST['kompetensi_keahlian']);

    $qInsert = "INSERT INTO kelas (nama_kelas, kompetensi_keahlian) 
            VALUES ('$nama_kelas','$kompetensi_keahlian')";

    mysqli_query($connect, $qInsert) or die(mysqli_error($connect));
    echo " 
    <script>    
        alert('Data berhasil ditambah');
        window.location.href='../../pages/siswa/index.php';
    </script>
            ";
} else {
    echo "
    <script>    
        alert('Data gagal ditambah');
        window.location.href='../../pages/siswa/create.php';
    </script>
    ";
}
?>