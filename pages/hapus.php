<?php 

include '../config/koneksi.php';

if(!isset($_GET['id'])) {
    echo "<script>alert('ID Tidak Ditemukan');window.location.href='data.php';</script>";
    exit;
}

$id = $_GET['id'];

$cek = mysqli_query($koneksi, "SELECT * FROM siswa WHERE id='$id'");

if(mysqli_num_rows($cek) == 0) {
    echo "<script>alert('Data Tidak Ditemukan');window.location.href='data.php';</script>";
    exit;
}

$hapus = mysqli_query($koneksi, "DELETE from siswa WHERE id='$id' ");

if($hapus) {
    echo "<script>alert('Data Berhasil Dihapus');window.location.href='data.php';</script>";
} else {
    echo "<script>alert('Data Gagal Dihapus');window.location.href='data.php';</script>";
}


?>