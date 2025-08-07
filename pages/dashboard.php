<?php
// session_start();
include './config/koneksi.php';
include './log.php'; // Fungsi log diletakkan di folder functions/

// Cek login admin
if (!isset($_SESSION['admin_id']) || !isset($_SESSION['username'])) {
    header("Location: ./auth/login.php");
    exit;
}

$admin_id = $_SESSION['admin_id'];
$username = $_SESSION['username'];
?>

<!-- dashboard.php -->
<div class="col-md-9 col-lg-10 p-4">
  <h2>Selamat Datang, <?= htmlspecialchars($username) ?></h2>

  <div class="row g-4">
    <!-- Kartu Jumlah Total Siswa -->
    <div class="col-md-3">
      <div class="card text-white bg-success h-100">
        <div class="card-body">
          <h5 class="card-title">Jumlah Total Siswa</h5>
          <p class="card-text fs-3">
            <?php
              $result = $koneksi->query("SELECT COUNT(*) AS total FROM siswa");
              $data = $result->fetch_assoc();
              echo $data['total'];
            ?>
          </p>
        </div>
      </div>
    </div>

    <!-- Kartu Jumlah Kelas -->
    <div class="col-md-3">
      <div class="card text-white bg-info h-100">
        <div class="card-body">
          <h5 class="card-title">Jumlah Kelas</h5>
          <p class="card-text fs-3">
            <?php
              $result = $koneksi->query("SELECT COUNT(DISTINCT kelas) AS jumlah_kelas FROM siswa");
              $data = $result->fetch_assoc();
              echo $data['jumlah_kelas'];
            ?>
          </p>
        </div>
      </div>
    </div>

    <!-- Kartu Siswa per Kelas -->
    <div class="col-md-6">
      <div class="card h-100">
        <div class="card-body">
          <h5 class="card-title">Jumlah Siswa per Kelas</h5>
          <ul class="list-group list-group-flush">
            <?php
              $result = $koneksi->query("SELECT kelas, COUNT(*) AS jumlah FROM siswa GROUP BY kelas");
              while ($row = $result->fetch_assoc()) {
                echo "<li class='list-group-item d-flex justify-content-between align-items-center'>
                        " . htmlspecialchars($row['kelas']) . "
                        <span class='badge bg-primary rounded-pill'>{$row['jumlah']}</span>
                      </li>";
              }
            ?>
          </ul>
        </div>
      </div>
    </div>

    <!-- Log Aktivitas -->
    <div class="col-md-12">
      <div class="card">
        <div class="card-body">
          <h5 class="card-title">Log Aplikasi Terakhir</h5>
          <ul class="list-group list-group-flush">
            <?php
              $sql = "SELECT al.aksi, al.waktu, a.username 
                      FROM aktivitas_log al 
                      JOIN admin a ON al.admin_id = a.id 
                      ORDER BY al.waktu DESC 
                      LIMIT 10";
              $result = $koneksi->query($sql);

              if ($result->num_rows > 0) {
                  while ($row = $result->fetch_assoc()) {
                      echo "<li class='list-group-item'>
                              <strong>" . htmlspecialchars($row['username']) . "</strong> - 
                              " . htmlspecialchars($row['aksi']) . "<br>
                              <small class='text-muted'>{$row['waktu']}</small>
                            </li>";
                  }
              } else {
                  echo "<li class='list-group-item'>Belum ada aktivitas yang tercatat.</li>";
              }
            ?>
          </ul>
        </div>
      </div>
    </div>
  </div>
</div>
