<?php
require_once '../../config.php';

// Validasi ID
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
  header("Location: modul.php");
  exit();
}

$id = (int)$_GET['id'];

// Ambil data modul berdasarkan ID
$stmt = $conn->prepare("SELECT * FROM modul WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows === 0) {
  header("Location: modul.php?status=notfound");
  exit();
}
$modul = $result->fetch_assoc();

// Ambil semua data praktikum
$praktikumList = [];
$result = $conn->query("SELECT id, nama_praktikum FROM praktikum");
while ($row = $result->fetch_assoc()) {
  $praktikumList[] = $row;
}

$errorMessage = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $id_praktikum = $_POST['id_praktikum'];
  $judul_modul  = $_POST['judul_modul'];
  $file_materi  = $modul['file_materi'];

  // Jika file baru diunggah
  if (isset($_FILES['file_materi']) && $_FILES['file_materi']['error'] === UPLOAD_ERR_OK) {
    $fileName = $_FILES['file_materi']['name'];
    $tmpName = $_FILES['file_materi']['tmp_name'];
    $uploadDir = '../../uploads/modul/';

    // Buat folder jika belum ada
    if (!file_exists($uploadDir)) {
      mkdir($uploadDir, 0777, true);
    }

    $filePath = $uploadDir . basename($fileName);
    if (move_uploaded_file($tmpName, $filePath)) {
      // Hapus file lama jika ada
      if (!empty($file_materi) && file_exists($uploadDir . $file_materi)) {
        unlink($uploadDir . $file_materi);
      }
      $file_materi = $fileName;
    } else {
      $errorMessage = "Gagal mengunggah file baru.";
    }
  }

  // Update data
  if (!$errorMessage) {
    $stmtUpdate = $conn->prepare("UPDATE modul SET id_praktikum = ?, judul_modul = ?, file_materi = ? WHERE id = ?");
    $stmtUpdate->bind_param("issi", $id_praktikum, $judul_modul, $file_materi, $id);

    if ($stmtUpdate->execute()) {
      header("Location: modul.php?status=update");
      exit();
    } else {
      $errorMessage = "Gagal menyimpan perubahan.";
    }
  }
}

// Tampilan
$pageTitle = 'Edit Modul';
$activePage = 'modul';
require_once '../templates/header.php';
?>

<?php if ($errorMessage): ?>
  <div class='text-red-600 text-center mt-4'><?= $errorMessage ?></div>
<?php endif; ?>

<form action="edit.php?id=<?= $id ?>" method="POST" enctype="multipart/form-data" class="max-w-xl mx-auto mt-6 space-y-4">
  <div>
    <label>Judul Modul</label>
    <input type="text" name="judul_modul" value="<?= htmlspecialchars($modul['judul_modul']) ?>" class="w-full border p-2" required>
  </div>

  <div>
    <label>Praktikum</label>
    <select name="id_praktikum" class="w-full border p-2" required>
      <option value="">-- Pilih Praktikum --</option>
      <?php foreach ($praktikumList as $praktikum): ?>
        <option value="<?= $praktikum['id'] ?>" <?= $praktikum['id'] == $modul['id_praktikum'] ? 'selected' : '' ?>>
          <?= $praktikum['nama_praktikum'] ?>
        </option>
      <?php endforeach; ?>
    </select>
  </div>

  <div>
    <label>Ganti File Materi (Opsional)</label>
    <input type="file" name="file_materi" class="w-full border p-2" accept=".pdf,.doc,.docx">
    <?php if (!empty($modul['file_materi'])): ?>
      <p class="text-sm text-gray-500 mt-1">File saat ini: <strong><?= $modul['file_materi'] ?></strong></p>
    <?php endif; ?>
  </div>

  <div class="flex justify-between">
    <a href="modul.php" class="bg-gray-500 text-white px-4 py-2 rounded">Batal</a>
    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Update</button>
  </div>
</form>

<?php require_once '../templates/footer.php'; ?>
