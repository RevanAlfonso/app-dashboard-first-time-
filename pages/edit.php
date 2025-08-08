<?php 
include "../config/koneksi.php";

if(!isset($_GET['id'])) {
    echo "<script>alert('ID Tidak ditemukan!');window.location.href='data.php';</script>";
    exit;
}

$id = $_GET['id'];

$query = mysqli_query($koneksi, "SELECT * FROM siswa WHERE id='$id'");
$data = mysqli_fetch_assoc($query);

if(!$data){
    echo "<script>alert('Data tidak ditemukan!');window.location.href='data.php';</script>";
    exit;
}

if(isset($_POST['update'])) {
    $nisn = $_POST['nisn'];
    $nama = $_POST['nama'];
    $kelas = $_POST['kelas'];
    $jenis_kelamin = $_POST['jenis_kelamin'];
    $tgl_lahir = $_POST['tgl_lahir'];
    $alamat = $_POST['alamat'];

    $update = mysqli_query($koneksi,
        "UPDATE siswa SET
        nisn = '$nisn',
        nama = '$nama', 
        kelas = '$kelas',
        jenis_kelamin = '$jenis_kelamin',
        tgl_lahir = '$tgl_lahir',
        alamat = '$alamat'
        WHERE id='$id'
        "
    );

    if($update) {
        echo "<script>alert('Data Berhasil Diupdate!');window.location.href='data.php';</script>";
    } else {
        echo "<script>alert('Gagal update data!');</script>";
    }
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Edit Data</title>
    <!-- Bootstrap CSS CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2 class="mb-4">Edit Data Siswa</h2>
        <form method="post">
            <div class="mb-3">
                <label for="nisn" class="form-label">NISN</label>
                <input type="text" class="form-control" id="nisn" name="nisn" value="<?= $data['nisn'] ?>" required>
            </div>
            <div class="mb-3">
                <label for="nama" class="form-label">Nama</label>
                <input type="text" class="form-control" id="nama" name="nama" value="<?= $data['nama'] ?>" required>
            </div>
            <div class="mb-3">
                <label for="kelas" class="form-label">Kelas</label>
                <input type="text" class="form-control" id="kelas" name="kelas" value="<?= $data['kelas'] ?>" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Jenis Kelamin</label>
                <div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="jenis_kelamin" id="laki" value="L" <?= ($data['jenis_kelamin'] == 'L') ? 'checked' : '' ?>>
                        <label class="form-check-label" for="laki">Laki-laki</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="jenis_kelamin" id="perempuan" value="P" <?= ($data['jenis_kelamin'] == 'P') ? 'checked' : '' ?>>
                        <label class="form-check-label" for="perempuan">Perempuan</label>
                    </div>
                </div>
            </div>
            <div class="mb-3">
                <label for="tgl_lahir" class="form-label">Tanggal Lahir</label>
                <input type="date" class="form-control" id="tgl_lahir" name="tgl_lahir" value="<?= $data['tgl_lahir'] ?>" required>
            </div>
            <div class="mb-3">
                <label for="alamat" class="form-label">Alamat</label>
                <textarea class="form-control" id="alamat" name="alamat" rows="3"><?= $data['alamat'] ?></textarea>
            </div>
            <button type="submit" name="update" class="btn btn-primary">Update</button>
            <a href="data.php" class="btn btn-secondary">Kembali</a>
        </form>
    </div>

    <!-- Bootstrap JS (optional, for modal/tooltips if needed) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
