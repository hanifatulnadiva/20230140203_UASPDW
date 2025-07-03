<?php
$pageTitle = 'Modul Praktikum';
$activePage = 'my_courses';
require_once 'templates/header_mahasiswa.php';
require_once '../config.php';

$id_user = $_SESSION['user_id'];
$id_praktikum = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($id_praktikum === 0) {
    echo "<p class='text-red-600'>ID praktikum tidak valid.</p>";
    exit();
}

// 🧩 Proses upload laporan
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_modul'])) {
    $id_modul = (int)$_POST['id_modul'];
    $judul_laporan = mysqli_real_escape_string($conn, $_POST['judul_laporan']);

    $uploadDir = '../uploads/laporan/';
    $fileName = basename($_FILES['file_laporan']['name']);
    $targetPath = $uploadDir . time() . '_' . $fileName;

    // Validasi ekstensi file
    $allowedExt = ['pdf', 'doc', 'docx'];
    $ext = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
    if (!in_array($ext, $allowedExt)) {
        $_SESSION['error'] = "Format file tidak diizinkan.";
        header("Location: modul.php?id=$id_praktikum");
        exit();
    }

    // Simpan file
    if (move_uploaded_file($_FILES['file_laporan']['tmp_name'], $targetPath)) {
        $finalName = basename($targetPath);

        // Simpan ke database
        $stmt = mysqli_prepare($conn, "INSERT INTO laporan (id_user, id_modul, judul_laporan, file_laporan, status, tanggal_upload) VALUES (?, ?, ?, ?, 'sudah', NOW())");
        mysqli_stmt_bind_param($stmt, "iiss", $id_user, $id_modul, $judul_laporan, $finalName);
        mysqli_stmt_execute($stmt);

        $_SESSION['success'] = "Laporan berhasil diunggah.";
    } else {
        $_SESSION['error'] = "Gagal mengunggah file.";
    }

    header("Location: modul.php?id=$id_praktikum");
    exit();
}

// 🧩 Ambil data praktikum
$praktikum = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM praktikum WHERE id = $id_praktikum"));
if (!$praktikum) {
    echo "<p class='text-red-600'>Praktikum tidak ditemukan.</p>";
    exit();
}

// 🧩 Ambil semua modul beserta laporan mahasiswa (jika ada)
$sql = "
    SELECT m.*, 
        l.file_laporan, l.status, l.nilai, l.judul_laporan
    FROM modul m
    LEFT JOIN laporan l 
        ON l.id_modul = m.id AND l.id_user = $id_user
    WHERE m.id_praktikum = $id_praktikum
    ORDER BY m.id ASC
";
$result = mysqli_query($conn, $sql);
?>

<div class="container mx-auto p-6 lg:p-8">
  <h1 class="text-2xl font-bold text-gray-800 mb-4">Modul: <?= htmlspecialchars($praktikum['nama_praktikum']) ?></h1>

  <?php if (isset($_SESSION['success'])): ?>
    <div class="mb-4 p-3 bg-green-100 text-green-700 border border-green-300 rounded">
      <?= $_SESSION['success']; unset($_SESSION['success']); ?>
    </div>
  <?php elseif (isset($_SESSION['error'])): ?>
    <div class="mb-4 p-3 bg-red-100 text-red-700 border border-red-300 rounded">
      <?= $_SESSION['error']; unset($_SESSION['error']); ?>
    </div>
  <?php endif; ?>

  <?php if (mysqli_num_rows($result) > 0): ?>
    <div class="space-y-6">
      <?php while ($row = mysqli_fetch_assoc($result)): ?>
        <div class="bg-white border rounded shadow p-4">
          <h2 class="text-lg font-semibold text-gray-700 mb-2"><?= htmlspecialchars($row['judul_modul']) ?></h2>

          <div class="mb-2">
            <span class="font-medium">Materi:</span>
            <a href="../uploads/modul/<?= $row['file_materi'] ?>" target="_blank" class="text-blue-600 underline">
              Unduh Materi
            </a>
          </div>

          <div class="mb-2">
            <span class="font-medium">Status Laporan:</span>
            <?= $row['status'] === 'sudah' ? '✅ Sudah dikumpulkan' : '❌ Belum dikumpulkan' ?>
          </div>

          <?php if ($row['status'] === 'sudah'): ?>
            <div class="mb-2">
              <span class="font-medium">Laporan:</span>
              <a href="../uploads/laporan/<?= $row['file_laporan'] ?>" class="text-green-600 underline" target="_blank">
                Lihat Laporan
              </a>
            </div>
            <div>
              <span class="font-medium">Nilai:</span>
              <?= $row['nilai'] !== null ? $row['nilai'] : '<span class="text-gray-500 italic">Belum dinilai</span>' ?>
            </div>
          <?php else: ?>
            <form method="POST" enctype="multipart/form-data" class="mt-3 space-y-2">
              <input type="hidden" name="id_modul" value="<?= $row['id'] ?>">
              <input type="text" name="judul_laporan" placeholder="Judul Laporan" required class="border px-3 py-2 w-full rounded">
              <input type="file" name="file_laporan" accept=".pdf,.doc,.docx" required class="border px-2 py-1 w-full rounded">
              <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">
                Upload Laporan
              </button>
            </form>
          <?php endif; ?>
        </div>
      <?php endwhile; ?>
    </div>
  <?php else: ?>
    <p class="text-gray-600">Belum ada modul untuk praktikum ini.</p>
  <?php endif; ?>
</div>
