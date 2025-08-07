<?php 
// session_start();
include './config/koneksi.php';
include './log.php';

// Cek login
// if (!isset($_SESSION['admin_id']) || !isset($_SESSION['username'])) {
//     header("Location: ./auth/login.php");
//     exit;
// }

$keyword = $_POST['keyword'] ?? '';
$keyword_escaped = mysqli_real_escape_string($koneksi, $keyword);

if (!empty($keyword)) {
    $query = mysqli_query($koneksi, "SELECT * FROM siswa WHERE nama LIKE '%$keyword_escaped%' ORDER BY id DESC");
} else {
    $query = mysqli_query($koneksi, "SELECT * FROM siswa ORDER BY id ASC");
}

// Proses tambah data
if (isset($_POST['tambah'])) {
    $nisn         = $_POST['nis'];
    $nama         = $_POST['nama'];
    $kelas        = $_POST['kelas'];
    $jenis_kelamin= $_POST['jenis_kelamin'];
    $tgl_lahir    = $_POST['tgl_lahir'];
    $alamat       = $_POST['alamat'];

    $stmt = $koneksi->prepare("INSERT INTO siswa (nisn, nama, kelas, jenis_kelamin, tgl_lahir, alamat) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssss", $nisn, $nama, $kelas, $jenis_kelamin, $tgl_lahir, $alamat);

    if ($stmt->execute()) {
        // Catat aktivitas
        log_aktivitas_db($koneksi, $_SESSION['admin_id'], "Menambahkan siswa: $nama");
        echo "<script>alert('Data berhasil disimpan!'); window.location.href='./index.php';</script>";
    } else {
        echo "<script>alert('Gagal menyimpan data!');</script>";
    }

    $stmt->close();
}
?>

<div class="p-3">
    <h2>Data Siswa</h2>

    <!-- Tombol Tambah -->
    <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#exampleModal">
      Tambah Data Siswa
    </button>

    <!-- Form Cari -->
    <form method="post" class="mb-3">
        <input type="text" name="keyword" placeholder="Cari Data Siswa" class="form-control mb-2" value="<?= htmlspecialchars($keyword) ?>">
        <button type="submit" name="cari" class="btn btn-primary">Cari</button>
    </form>

    <!-- Tabel Data -->
    <div class="table-responsive">
        <table class="table table-striped table-hover text-center">
            <thead>
                <tr>
                    <th>No</th>
                    <th>NISN</th>
                    <th>Nama</th>
                    <th>Kelas</th>
                    <th>Jenis Kelamin</th>
                    <th>Tanggal Lahir</th>
                    <th>Alamat</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                $no = 1;
                if (mysqli_num_rows($query) > 0):
                    while($row = mysqli_fetch_assoc($query)): ?>
                    <tr>
                        <td><?= $no++ ?></td>
                        <td><?= htmlspecialchars($row['nisn']) ?></td>
                        <td><?= htmlspecialchars($row['nama']) ?></td>
                        <td><?= htmlspecialchars($row['kelas']) ?></td>
                        <td><?= $row['jenis_kelamin'] == 'L' ? 'Laki-laki' : 'Perempuan' ?></td>
                        <td><?= htmlspecialchars($row['tgl_lahir']) ?></td>
                        <td><?= htmlspecialchars($row['alamat']) ?></td>
                        <td>
                            <a href="edit.php?id=<?= $row['id'] ?>" class="btn btn-warning btn-sm">Edit</a>
                            <a href="hapus.php?id=<?= $row['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus data ini?')">Hapus</a>
                        </td>
                    </tr>
                <?php endwhile; else: ?>
                    <tr>
                        <td colspan="8">Data tidak ditemukan.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Modal Tambah -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form method="post" class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Tambah Data Siswa</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
      </div>
      <div class="modal-body">
        <label>NIS</label>
        <input type="text" name="nis" class="form-control" required>
        <label>Nama Siswa</label>
        <input type="text" name="nama" class="form-control" required>
        <label>Tanggal Lahir</label>
        <input type="date" name="tgl_lahir" class="form-control" required>
        <label>Jenis Kelamin</label><br>
        <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="jenis_kelamin" value="L" required>
            <label class="form-check-label">Laki-laki</label>
        </div>
        <div class="form-check form-check-inline mb-2">
            <input class="form-check-input" type="radio" name="jenis_kelamin" value="P" required>
            <label class="form-check-label">Perempuan</label>
        </div>
        <label>Kelas</label>
        <select name="kelas" class="form-control" required>
            <option value="">Pilih Kelas</option>
            <option value="X">X</option>
            <option value="XI">XI</option>
            <option value="XII">XII</option>
        </select>
        <label>Alamat</label>
        <textarea name="alamat" class="form-control" required></textarea>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
        <button type="submit" class="btn btn-primary" name="tambah">Tambah Data</button>
      </div>
    </form>
  </div>
</div>
<!-- Modal Edit -->
 