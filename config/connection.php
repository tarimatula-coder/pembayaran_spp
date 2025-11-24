<?php   
$hostname = "localhost";
$username = "root";
$password ="";
$database = "pembayaran_spp";


$connect = mysqli_connect($hostname, $username, $password, $database);
if (!$connect){
    die("koneksi gagal: ".mysqli_connect_error());
}
?>