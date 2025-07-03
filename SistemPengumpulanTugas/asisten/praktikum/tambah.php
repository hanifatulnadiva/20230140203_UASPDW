<?php
require_once '../../config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $nama     = $_POST['nama_praktikum'];
  $semester = $_POST['semester'];
  $dosen    = $_POST['dosen_pengampu'];

  $stmt = $conn->prepare("INSERT INTO praktikum (nama_praktikum, semester, dosen_pengampu, created_at) VALUES (?, ?, ?, NOW())");
  $stmt->bind_param("sss", $nama, $semester, $dosen);

  if ($stmt->execute()) {
    // ✅ Redirect sebelum output HTML dimulai
    header("Location: praktikum.php?status=tambah");
    exit();
  }

  // jika gagal insert, tampilkan error
  $errorMessage = "Gagal menambahkan data.";
}

// Di bawah ini baru tampilkan HTML
$pageTitle = 'Tambah Praktikum';
$activePage = 'praktikum';
require_once '../templates/header.php';

// Konfigurasi form
$fields = ['nama_praktikum', 'semester', 'dosen_pengampu'];
$labels = ['Nama Praktikum', 'Semester', 'Dosen Pengampu'];
$types  = ['text', 'text', 'text'];
$isEdit = false;
$action = 'tambah.php';
$backUrl = 'praktikum.php';

if (isset($errorMessage)) {
  echo "<div class='text-red-600 text-center mt-4'>$errorMessage</div>";
}

include '../templates/form.php';
require_once '../templates/footer.php';
