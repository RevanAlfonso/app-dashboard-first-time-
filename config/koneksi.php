<?php 

$host = "localhost";
$usn = "root";
$pass = "";
$db = "tbl_siswa";

$koneksi = mysqli_connect($host, $usn, $pass, $db);

if (!$koneksi) {
    die('Koneksi Gagal' . mysqli_connect_error());
}

?>