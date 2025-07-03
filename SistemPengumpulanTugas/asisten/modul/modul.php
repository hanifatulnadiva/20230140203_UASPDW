<?php
$pageTitle = 'Kelola Modul';
$activePage = 'modul';

require_once '../templates/header.php';
require_once '../../config.php';

// Ambil data modul + nama praktikum
$sql = "SELECT m.*, p.nama_praktikum 
        FROM modul m 
        JOIN praktikum p ON m.id_praktikum = p.id 
        ORDER BY m.created_at DESC";
$result = $conn->query($sql);

$data = [];
if ($result && $result->num_rows > 0) {
  while ($row = $result->fetch_assoc()) {
    $data[] = $row;
  }
}

// Konfigurasi untuk table.php
$columns = ['Judul Modul', 'Praktikum', 'Materi', 'Tanggal Buat'];
$fields  = ['judul_modul', 'nama_praktikum', 'file_materi', 'created_at'];
?>

<!-- Notifikasi -->
<?php if (isset($_GET['status'])): ?>
  <?php
    $messages = [
      'tambah' => 'Modul berhasil ditambahkan.',
      'update' => 'Modul berhasil diperbarui.',
      'hapus'  => 'Modul berhasil dihapus.',
    ];
    $status = $_GET['status'];
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
    + Tambah Modul
  </a>
</div>

<!-- Tabel Modul -->
<div class="bg-white shadow rounded-lg overflow-hidden mt-4 mx-auto max-w-6xl">
  <div class="flex justify-between items-center px-6 py-4 border-b border-gray-200">
    <h3 class="text-lg font-semibold text-gray-800">Daftar Modul Praktikum</h3>
  </div>

  <div class="overflow-x-auto">
    <?php include '../templates/table.php'; ?>
  </div>
</div>

<!-- Notifikasi hilang saat scroll/klik -->
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
