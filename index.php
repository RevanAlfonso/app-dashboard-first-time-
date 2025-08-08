<?php 

include './config/koneksi.php';
// if (!isset($_SESSION['login'])) {
//       header("Location: ./auth/login.php");
//       exit;
// }

session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Dashboard</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css"/>
</head>
<body>

  <!-- Navbar -->
  <?php include './components/navbar.php'; ?>

  <!-- Layout -->
  <div class="container-fluid">
    <div class="row">
      <!-- Sidebar -->
      <?php include './components/sidebar.php'; ?>

      <!-- Content -->
<div class="col-md-9 col-lg-10 p-4">
  <?php 
    $page = $_GET['page'] ?? 'dashboard';
    $file_path = "pages/$page.php";

    if(file_exists($file_path)) {
      include $file_path;
    } else {
      echo "<div class='alert alert-danger'>Halaman Tidak Ditemukan.</div>";
    }
  ?>
</div>


       ?>
    </div>
  </div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
