<?php 
// Diasumsikan file ini dipanggil dari index.php
// Jadi koneksi & session sudah dimuat sebelumnya

if(isset($_POST['submit'])) {
    $nisn = $_POST['nis'];
    $nama = $_POST['nama'];
    $kelas = $_POST['kelas'];
    $jenis_kelamin = $_POST['jenis_kelamin'];
    $tgl_lahir = $_POST['tgl_lahir'];
    $alamat = $_POST['alamat'];

    // Pakai prepared statement untuk mencegah SQL injection
    $stmt = $koneksi->prepare("INSERT INTO siswa (nisn, nama, kelas, jenis_kelamin, tgl_lahir, alamat) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssss", $nisn, $nama, $kelas, $jenis_kelamin, $tgl_lahir, $alamat);
    
    if ($stmt->execute()) {
        echo "<script>alert('Data berhasil disimpan!'); window.location.href='index.php?page=data';</script>";
    } else {
        echo "<script>alert('Gagal menyimpan data!');</script>";
    }

    $stmt->close();
}
?>

<!-- Layout konten -->
<div class="col-md-9 col-lg-10 p-4">
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0">Form Tambah Data Siswa</h4>
        </div>
        <div class="card-body">
            <form method="post">
                <div class="mb-3">
                    <label for="nis" class="form-label">NIS</label>
                    <input type="text" id="nis" name="nis" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label for="nama" class="form-label">Nama Siswa</label>
                    <input type="text" id="nama" name="nama" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label for="kelas" class="form-label">Kelas</label>
                    <input type="text" id="kelas" name="kelas" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label d-block">Jenis Kelamin</label>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="jenis_kelamin" id="jkL" value="L" required>
                        <label class="form-check-label" for="jkL">Laki-laki</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="jenis_kelamin" id="jkP" value="P">
                        <label class="form-check-label" for="jkP">Perempuan</label>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="tgl_lahir" class="form-label">Tanggal Lahir</label>
                    <input type="date" id="tgl_lahir" name="tgl_lahir" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label for="alamat" class="form-label">Alamat Siswa</label>
                    <textarea name="alamat" id="alamat" class="form-control" rows="4" required></textarea>
                </div>

                <button type="submit" name="submit" class="btn btn-success">Simpan</button>
                <a href="index.php?page=data" class="btn btn-secondary">Kembali</a>
            </form>
        </div>
    </div>
</div>
