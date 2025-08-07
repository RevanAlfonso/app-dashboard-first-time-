<?php
// Ambil nama halaman dari URL
$current_page = $_GET['page'] ?? 'dashboard';
?>

<div class="col-md-3 col-lg-2 bg-light vh-100 p-3 border-end">
  <h5 class="mb-4">Menu Navigasi</h5>
  <div class="list-group">
    <a href="index.php?page=dashboard" 
       class="list-group-item list-group-item-action <?= $current_page == 'dashboard' ? 'active' : '' ?>">
      Dashboard
    </a>
    <a href="index.php?page=data" 
       class="list-group-item list-group-item-action <?= $current_page == 'data' ? 'active' : '' ?>">
      Data Siswa
    </a>
    <a href="index.php?page=tambah_admin" 
       class="list-group-item list-group-item-action <?= $current_page == 'tambah_admin' ? 'active' : '' ?>">
      Tambah Admin
    </a>
    <a href="index.php?page=ekspor" 
       class="list-group-item list-group-item-action <?= $current_page == 'ekspor' ? 'active' : '' ?>">
      Ekspor Data
    </a>
    <a href="index.php?page=pengaturan" 
       class="list-group-item list-group-item-action <?= $current_page == 'pengaturan' ? 'active' : '' ?>">
      Pengaturan Admin
    </a>
    <a href="./auth/logout.php" class="list-group-item list-group-item-action text-danger">
      Logout
    </a>
  </div>
</div>
