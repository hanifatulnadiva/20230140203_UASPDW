<?php
require_once '../../config.php';
require_once '../templates/header.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'asisten') {
  header("Location: ../../login.php");
  exit();
}

$id = $_GET['id'] ?? '';
if (!$id) {
  echo "<p class='text-red-600 text-center mt-4'>ID laporan tidak ditemukan.</p>";
  exit();
}

// Ambil data laporan
$stmt = $conn->prepare("
  SELECT l.*, u.nama AS nama_mahasiswa, m.judul_modul 
  FROM laporan l
  JOIN users u ON l.id_user = u.id
  JOIN modul m ON l.id_modul = m.id
  WHERE l.id_laporan = ?
");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$laporan = $result->fetch_assoc();

if (!$laporan) {
  echo "<p class='text-red-600 text-center mt-4'>Data laporan tidak ditemukan.</p>";
  exit();
}

// Jika form feedback disubmit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $nilai = $_POST['nilai'] ?? '';
  $feedback = $_POST['feedback'] ?? '';

  $update = $conn->prepare("UPDATE laporan SET nilai = ?, feedback = ? WHERE id_laporan = ?");
  $update->bind_param("isi", $nilai, $feedback, $id);
  if ($update->execute()) {
    echo "<p class='text-green-600 text-center mt-2'>✅ Feedback berhasil disimpan.</p>";
    // Refresh data
    $stmt->execute();
    $result = $stmt->get_result();
    $laporan = $result->fetch_assoc();
  } else {
    echo "<p class='text-red-600 text-center mt-2'>❌ Gagal menyimpan feedback.</p>";
  }
}
?>

<div class="max-w-3xl mx-auto mt-6 bg-white p-6 rounded shadow">
  <h2 class="text-xl font-bold mb-4">Detail Laporan</h2>

  <table class="w-full mb-4 text-sm">
    <tr><td><strong>Nama Mahasiswa</strong></td><td>: <?= htmlspecialchars($laporan['nama_mahasiswa']) ?></td></tr>
    <tr><td><strong>Judul Modul</strong></td><td>: <?= htmlspecialchars($laporan['judul_modul']) ?></td></tr>
    <tr><td><strong>Judul Laporan</strong></td><td>: <?= htmlspecialchars($laporan['judul_laporan']) ?></td></tr>
    <tr><td><strong>Tanggal Upload</strong></td><td>: <?= date('d-m-Y H:i', strtotime($laporan['tanggal_upload'])) ?></td></tr>
    <tr><td><strong>Status</strong></td><td>: <?= $laporan['status'] === 'sudah' ? '✅ Sudah' : '❌ Belum' ?></td></tr>
    <tr><td><strong>File Laporan</strong></td><td>:
      <?php if ($laporan['file_laporan']): ?>
        <a href="../../uploads/laporan/<?= urlencode($laporan['file_laporan']) ?>" target="_blank" class="text-blue-600 underline">Unduh File</a>
      <?php else: ?>
        <span class="text-gray-400">Tidak ada file</span>
      <?php endif; ?>
    </td></tr>
    <tr><td><strong>Nilai</strong></td><td>: <?= $laporan['nilai'] ?? '-' ?></td></tr>
    <tr><td><strong>Feedback</strong></td><td>: <?= nl2br(htmlspecialchars($laporan['feedback'] ?? '-')) ?></td></tr>
  </table>

  <h3 class="text-lg font-semibold mt-6 mb-2">Beri Nilai & Feedback</h3>
  <form action="" method="POST" class="space-y-4">
    <div>
      <label class="block text-sm font-medium">Nilai (0-100)</label>
      <input type="number" name="nilai" value="<?= htmlspecialchars($laporan['nilai'] ?? '') ?>" class="border p-2 rounded w-full" min="0" max="100" required>
    </div>
    <div>
      <label class="block text-sm font-medium">Feedback</label>
      <textarea name="feedback" rows="4" class="border p-2 rounded w-full"><?= htmlspecialchars($laporan['feedback'] ?? '') ?></textarea>
    </div>
    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Simpan Feedback</button>
  </form>

  <div class="mt-4">
    <a href="laporan.php" class="text-gray-600 hover:underline">← Kembali ke Laporan</a>
  </div>
</div>

<?php require_once '../templates/footer.php'; ?>
