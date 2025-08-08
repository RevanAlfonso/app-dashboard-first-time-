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
    $jenis_kelamin = $_POST['jenis_kelamin'];
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

// Proses update data
if (isset($_POST['update'])) {
    $id            = $_POST['id'];
    $nisn          = $_POST['nis'];
    $nama          = $_POST['nama'];
    $kelas         = $_POST['kelas'];
    $jenis_kelamin = $_POST['jenis_kelamin'];
    $tgl_lahir     = $_POST['tgl_lahir'];
    $alamat        = $_POST['alamat'];

    $stmt = $koneksi->prepare("UPDATE siswa SET nisn=?, nama=?, kelas=?, jenis_kelamin=?, tgl_lahir=?, alamat=? WHERE id=?");
    $stmt->bind_param("ssssssi", $nisn, $nama, $kelas, $jenis_kelamin, $tgl_lahir, $alamat, $id);

    if ($stmt->execute()) {
        log_aktivitas_db($koneksi, $_SESSION['admin_id'], "Mengedit siswa: $nama");
        echo "<script>alert('Data berhasil diupdate!'); window.location.href='./index.php';</script>";
    } else {
        echo "<script>alert('Gagal update data!');</script>";
    }

    $stmt->close();
}

if (isset($_GET['hapus'])) {
    $id = (int) $_GET['hapus'];
    // $nama = get_nama_siswa($koneksi, $id);
    // echo "<script>alert('delete')</script>";
    $stmt = $koneksi->prepare("DELETE FROM siswa WHERE id=?");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        log_aktivitas_db($koneksi, $_SESSION['admin_id'], "Menghapus siswa ID : $id");
        echo "<script>alert('Data Berhasil Dihapus');window.location.href='./index.php';</script>";
    } else {
        echo "<script>alert('Data Gagal Dihapus');</script>";
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
                    while ($row = mysqli_fetch_assoc($query)): ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td><?= htmlspecialchars($row['nisn']) ?></td>
                            <td><?= htmlspecialchars($row['nama']) ?></td>
                            <td><?= htmlspecialchars($row['kelas']) ?></td>
                            <td><?= $row['jenis_kelamin'] == 'L' ? 'Laki-laki' : 'Perempuan' ?></td>
                            <td><?= htmlspecialchars($row['tgl_lahir']) ?></td>
                            <td><?= htmlspecialchars($row['alamat']) ?></td>
                            <td>
                                <button
                                    type="button"
                                    class="btn btn-warning btn-sm btn-edit"
                                    data-bs-toggle="modal"
                                    data-bs-target="#modalEdit"
                                    data-id="<?= $row['id'] ?>"
                                    data-nis="<?= htmlspecialchars($row['nisn']) ?>"
                                    data-nama="<?= htmlspecialchars($row['nama']) ?>"
                                    data-kelas="<?= htmlspecialchars($row['kelas']) ?>"
                                    data-jk="<?= $row['jenis_kelamin'] ?>"
                                    data-tgllahir="<?= htmlspecialchars($row['tgl_lahir']) ?>"
                                    data-alamat="<?= htmlspecialchars($row['alamat']) ?>">
                                    Edit
                                </button>

                                <a href="?page=data&hapus=<?= $row['id']  ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus data ini?')">Hapus</a>
                            </td>
                        </tr>
                    <?php endwhile;
                else: ?>
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
<div class="modal fade" id="modalEdit" tabindex="-1" aria-labelledby="modalEditLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form method="post" class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalEditLabel">Edit Data Siswa</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>
            <div class="modal-body">
                <input type="hidden" name="id" id="edit-id">

                <label>NIS</label>
                <input type="text" name="nis" id="edit-nis" class="form-control" required>

                <label>Nama Siswa</label>
                <input type="text" name="nama" id="edit-nama" class="form-control" required>

                <label>Tanggal Lahir</label>
                <input type="date" name="tgl_lahir" id="edit-tgllahir" class="form-control" required>

                <label>Jenis Kelamin</label><br>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="jenis_kelamin" id="edit-jk-l" value="L" required>
                    <label class="form-check-label" for="edit-jk-l">Laki-laki</label>
                </div>
                <div class="form-check form-check-inline mb-2">
                    <input class="form-check-input" type="radio" name="jenis_kelamin" id="edit-jk-p" value="P" required>
                    <label class="form-check-label" for="edit-jk-p">Perempuan</label>
                </div>

                <label>Kelas</label>
                <select name="kelas" id="edit-kelas" class="form-control" required>
                    <option value="">Pilih Kelas</option>
                    <option value="X">X</option>
                    <option value="XI">XI</option>
                    <option value="XII">XII</option>
                </select>

                <label>Alamat</label>
                <textarea name="alamat" id="edit-alamat" class="form-control" required></textarea>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                <button type="submit" class="btn btn-primary" name="update">Update Data</button>
            </div>
        </form>
    </div>
</div>
<script>
    document.querySelectorAll('.btn-edit').forEach(button => {
        button.addEventListener('click', () => {
            document.getElementById('edit-id').value = button.dataset.id;
            document.getElementById('edit-nis').value = button.dataset.nis;
            document.getElementById('edit-nama').value = button.dataset.nama;
            document.getElementById('edit-tgllahir').value = button.dataset.tgllahir;
            document.getElementById('edit-alamat').value = button.dataset.alamat;
            document.getElementById('edit-kelas').value = button.dataset.kelas;

            if (button.dataset.jk === 'L') {
                document.getElementById('edit-jk-l').checked = true;
            } else {
                document.getElementById('edit-jk-p').checked = true;
            }
        });
    });
</script>