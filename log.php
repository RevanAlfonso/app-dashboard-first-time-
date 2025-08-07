<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include './config/koneksi.php'; // sesuaikan path jika perlu

if (!function_exists('log_aktivitas_db')) {
    function log_aktivitas_db($koneksi, $admin_id, $aksi) {
        if (!$koneksi || !$admin_id || !$aksi) return;

        $sql = "INSERT INTO aktivitas_log (admin_id, aksi) VALUES (?, ?)";
        $stmt = $koneksi->prepare($sql);
        if ($stmt) {
            $stmt->bind_param("is", $admin_id, $aksi);
            $stmt->execute();
            $stmt->close();
        }
    }
}
