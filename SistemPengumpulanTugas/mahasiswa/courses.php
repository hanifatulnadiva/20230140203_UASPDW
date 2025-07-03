<?php
$pageTitle = 'Cari Praktikum';
$activePage = 'courses';
require_once 'templates/header_mahasiswa.php';
require_once '../config.php';

$userId = $_SESSION['user_id'];

// Proses pendaftaran jika ada form POST
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_praktikum'])) {
    $idPraktikum = $_POST['id_praktikum'];

    $stmt = mysqli_prepare($conn, "INSERT IGNORE INTO peserta_praktikum (id_user, id_praktikum, tanggal_daftar) VALUES (?, ?, NOW())");
    mysqli_stmt_bind_param($stmt, "ii", $userId, $idPraktikum);
    mysqli_stmt_execute($stmt);

    $_SESSION['success'] = 'Berhasil mendaftar praktikum.';
    header("Location: courses.php");
    exit();
}

// Ambil semua praktikum + status apakah sudah terdaftar
$sql = "
  SELECT p.*, 
    (SELECT COUNT(*) FROM peserta_praktikum pp 
     WHERE pp.id_user = $userId AND pp.id_praktikum = p.id) AS sudah_daftar
  FROM praktikum p
  ORDER BY p.nama_praktikum ASC
";
$result = mysqli_query($conn, $sql);
?>

<div class="container mx-auto p-6 lg:p-8">
  <h1 class="text-2xl font-bold text-gray-800 mb-4">Daftar Praktikum</h1>

  <?php if (isset($_SESSION['success'])): ?>
    <div class="mb-4 p-4 rounded bg-green-100 text-green-700 border border-green-300">
      <?= $_SESSION['success'] ?>
    </div>
    <?php unset($_SESSION['success']); ?>
  <?php endif; ?>

  <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
    <?php while ($row = mysqli_fetch_assoc($result)): ?>
      <div class="bg-white rounded-lg shadow p-4 border border-gray-200 text-center">
        <!-- Ikon buku -->
        <div class="flex justify-center mb-4">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 0C9.613 4 8 5.613 8 8v8c0 2.387 1.613 4 4 4s4-1.613 4-4V8c0-2.387-1.613-4-4-4z" />
          </svg>
        </div>

        <h2 class="text-lg font-semibold text-gray-700 mb-1"><?= htmlspecialchars($row['nama_praktikum']) ?></h2>
        <p class="text-sm text-gray-600 mb-2">Semester: <?= $row['semester'] ?></p>

        <?php if ($row['sudah_daftar'] > 0): ?>
          <button class="bg-gray-300 text-gray-600 px-4 py-2 rounded cursor-not-allowed" disabled>
            Sudah Terdaftar
          </button>
        <?php else: ?>
          <form method="POST" onsubmit="return confirmDaftar(this);">
            <input type="hidden" name="id_praktikum" value="<?= $row['id'] ?>">
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">
              Daftar
            </button>
          </form>
        <?php endif; ?>
      </div>
    <?php endwhile; ?>
  </div>
</div>

<!-- JavaScript konfirmasi -->
<script>
function confirmDaftar(form) {
  return confirm("Apakah kamu yakin ingin mendaftar praktikum ini?");
}
</script>
