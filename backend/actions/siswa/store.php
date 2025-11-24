<?php
include '../../app.php';

if (isset($_POST['tombol'])) {
    $nisn     = htmlspecialchars(trim($_POST['nisn']));
    $nis      = htmlspecialchars(trim($_POST['nis']));
    $nama     = htmlspecialchars(trim($_POST['nama']));
    $password = password_hash(trim($_POST['password']), PASSWORD_DEFAULT); // hash password
    $id_kelas = htmlspecialchars(trim($_POST['id_kelas']));
    $alamat   = htmlspecialchars(trim($_POST['alamat']));
    $no_telp  = htmlspecialchars(trim($_POST['no_telp']));
    $id_spp   = htmlspecialchars(trim($_POST['id_spp']));

    $query = "INSERT INTO siswa (nisn, nis, nama, password, id_kelas, alamat, no_telp, id_spp) 
              VALUES ('$nisn', '$nis', '$nama', '$password', '$id_kelas', '$alamat', '$no_telp', '$id_spp')";

    if (mysqli_query($connect, $query)) {
        echo "<script>alert('Data siswa berhasil ditambahkan!');window.location.href='../../pages/siswa/index.php';</script>";
    } else {
        echo "<script>alert('Gagal menambahkan siswa: " . mysqli_error($connect) . "');window.history.back();</script>";
    }
} else {
    echo "<script>alert('Form tidak valid!');window.history.back();</script>";
}