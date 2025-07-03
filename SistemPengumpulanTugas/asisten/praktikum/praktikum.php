<?php
$pageTitle = 'Kelola Praktikum';
$activePage = 'praktikum';

require_once '../templates/header.php'; 
require_once '../../config.php';

// --- Ambil data praktikum dari DB ---
$sql = "SELECT * FROM praktikum ORDER BY created_at DESC";
$result = $conn->query($sql);

$data = [];
if ($result && $result->num_rows > 0) {
  while ($row = $result->fetch_assoc()) {
    $data[] = $row;
  }
}

// Konfigurasi untuk table.php
$columns = ['Nama Praktikum', 'Semester', 'Dosen Pengampu', 'Tanggal Buat'];
$fields  = ['nama_praktikum', 'semester', 'dosen_pengampu', 'created_at'];

?>

<!-- Notifikasi -->
<?php if (isset($_GET['status'])): ?>
  <?php
    $status = $_GET['status'];
    $messages = [
      'tambah' => 'Data berhasil ditambahkan.',
      'update' => 'Data berhasil diperbarui.',
      'hapus'  => 'Data berhasil dihapus.',
    ];
  ?>
  <?php if (isset($messages[$status])): ?>
    <div id="notif" class="p-3 bg-green-100 text-green-800 rounded mb-4 max-w-4xl mx-auto transition-opacity duration-500">
      <?= $messages[$status] ?>
    </div>
  <?php endif; ?>
<?php endif; ?>

<!-- Tombol Tambah -->
<div class="mt-6 mx-auto max-w-6xl flex justify-end">
  <a href="tambah.php" class="bg-blue-600 text-white px-4 py-2 text-sm rounded hover:bg-blue-700">
    + Tambah Praktikum
  </a>
</div>

<!-- Tabel Praktikum -->
<div class="bg-white shadow rounded-lg overflow-hidden mt-4 mx-auto max-w-6xl">
  <div class="flex justify-between items-center px-6 py-4 border-b border-gray-200">
    <h3 class="text-lg font-semibold text-gray-800">Daftar Mata Praktikum</h3>
  </div>

  <div class="overflow-x-auto">
    <?php include '../templates/table.php'; ?>
  </div>
</div>

<!-- Notifikasi hide on scroll or click -->
<script>
  document.addEventListener("DOMContentLoaded", function () {
    const notif = document.getElementById('notif');

    function hideNotif() {
      if (notif) {
        notif.style.opacity = '0';
        setTimeout(() => notif.remove(), 300);
        window.removeEventListener('scroll', hideNotif);
        document.removeEventListener('click', hideNotif);
      }
    }

    window.addEventListener('scroll', hideNotif);
    document.addEventListener('click', hideNotif);
  });
</script>

<?php require_once '../templates/footer.php'; ?>
