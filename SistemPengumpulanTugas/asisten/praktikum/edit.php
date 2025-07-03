<?php
require_once '../../config.php';

$id = $_GET['id'] ?? null;
if (!$id) {
  die('ID tidak ditemukan.');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $nama     = $_POST['nama_praktikum'];
  $semester = $_POST['semester'];
  $dosen    = $_POST['dosen_pengampu'];

  $stmt = $conn->prepare("UPDATE praktikum SET nama_praktikum=?, semester=?, dosen_pengampu=? WHERE id=?");
  $stmt->bind_param("sssi", $nama, $semester, $dosen, $id);

  if ($stmt->execute()) {
    header("Location: praktikum.php?status=update");
    exit();
  } else {
    $errorMessage = "Gagal memperbarui data.";
  }
}

// Ambil data praktikum untuk form
$stmt = $conn->prepare("SELECT * FROM praktikum WHERE id=?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$data = $result->fetch_assoc();

if (!$data) {
  die('Data tidak ditemukan.');
}

// Konfigurasi form
$pageTitle = 'Edit Praktikum';
$activePage = 'praktikum';
require_once '../templates/header.php';

$fields = ['nama_praktikum', 'semester', 'dosen_pengampu'];
$labels = ['Nama Praktikum', 'Semester', 'Dosen Pengampu'];
$types  = ['text', 'text', 'text'];
$isEdit = true;
$action = "edit.php?id=$id";
$backUrl = 'praktikum.php';

if (isset($errorMessage)) {
  echo "<div class='text-red-600 text-center mt-4'>$errorMessage</div>";
}

include '../templates/form.php';
require_once '../templates/footer.php';
