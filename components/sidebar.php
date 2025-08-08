<?php
// Ambil nama halaman dari URL
$current_page = $_GET['page'] ?? 'dashboard';

// Menu list biar sekali tulis
$menus = [
  ['label' => 'Dashboard', 'page' => 'dashboard'],
  ['label' => 'Data Siswa', 'page' => 'data'],
  ['label' => 'Tambah Admin', 'page' => 'tambah_admin'],
  ['label' => 'Ekspor Data', 'page' => 'ekspor'],
  ['label' => 'Pengaturan Admin', 'page' => 'pengaturan'],
];
?>

<!-- Tombol menu untuk mobile -->
<div class="d-md-none p-2 border-bottom">
  <button class="btn btn-primary" type="button" data-bs-toggle="offcanvas" data-bs-target="#sidebarMenu">
    ☰ Menu
  </button>
</div>

<!-- Sidebar Desktop -->
<div class="col-md-3 col-lg-2 bg-light vh-100 p-3 border-end d-none d-md-block">
  <h5 class="mb-4">Menu Navigasi</h5>
  <div class="list-group">
    <?php foreach ($menus as $m): ?>
      <a href="index.php?page=<?= $m['page'] ?>"
         class="list-group-item list-group-item-action <?= $current_page == $m['page'] ? 'active' : '' ?>">
        <?= $m['label'] ?>
      </a>
    <?php endforeach; ?>
    <a href="./auth/logout.php" class="list-group-item list-group-item-action text-danger">
      Logout
    </a>
  </div>
</div>

<!-- Sidebar Mobile Offcanvas -->
<div class="offcanvas offcanvas-start" tabindex="-1" id="sidebarMenu">
  <div class="offcanvas-header">
    <h5 class="offcanvas-title">Menu Navigasi</h5>
    <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
  </div>
  <div class="offcanvas-body">
    <div class="list-group">
      <?php foreach ($menus as $m): ?>
        <a href="index.php?page=<?= $m['page'] ?>"
           class="list-group-item list-group-item-action <?= $current_page == $m['page'] ? 'active' : '' ?>">
          <?= $m['label'] ?>
        </a>
      <?php endforeach; ?>
      <a href="./auth/logout.php" class="list-group-item list-group-item-action text-danger">
        Logout
      </a>
    </div>
  </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
