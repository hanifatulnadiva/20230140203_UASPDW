<?php
require_once '../../config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $id_praktikum = $_POST['id_praktikum'];
  $judul_modul  = $_POST['judul_modul'];

  // Handle file upload
  $fileName = $_FILES['file_materi']['name'];
  $tmpName  = $_FILES['file_materi']['tmp_name'];
  $uploadDir = '../../uploads/modul/';

  // Buat folder jika belum ada
  if (!file_exists($uploadDir)) {
    mkdir($uploadDir, 0777, true);
  }

  $filePath = $uploadDir . basename($fileName);
  if (move_uploaded_file($tmpName, $filePath)) {
    // Simpan ke database
    $stmt = $conn->prepare("INSERT INTO modul (id_praktikum, judul_modul, file_materi, created_at) VALUES (?, ?, ?, NOW())");
    $stmt->bind_param("iss", $id_praktikum, $judul_modul, $fileName);

    if ($stmt->execute()) {
      header("Location: modul.php?status=tambah");
      exit();
    } else {
      $errorMessage = "Gagal menyimpan ke database.";
    }
  } else {
    $errorMessage = "Gagal mengunggah file.";
  }
}

// Konfigurasi tampilan
$pageTitle = 'Tambah Modul';
$activePage = 'modul';
require_once '../templates/header.php';

// Ambil data praktikum untuk dropdown
$praktikumList = [];
$result = $conn->query("SELECT id, nama_praktikum FROM praktikum");
while ($row = $result->fetch_assoc()) {
  $praktikumList[] = $row;
}
?>

<?php if (isset($errorMessage)) : ?>
  <div class='text-red-600 text-center mt-4'><?= $errorMessage ?></div>
<?php endif; ?>

<form action="tambah.php" method="POST" enctype="multipart/form-data" class="max-w-xl mx-auto mt-6 space-y-4">
  <div>
    <label>Judul Modul</label>
    <input type="text" name="judul_modul" class="w-full border p-2" required>
  </div>

  <div>
    <label>Praktikum</label>
    <select name="id_praktikum" class="w-full border p-2" required>
      <option value="">-- Pilih Praktikum --</option>
      <?php foreach ($praktikumList as $praktikum) : ?>
        <option value="<?= $praktikum['id'] ?>"><?= $praktikum['nama_praktikum'] ?></option>
      <?php endforeach; ?>
    </select>
  </div>

  <div>
    <label>Upload File Materi</label>
    <input type="file" name="file_materi" class="w-full border p-2" accept=".pdf,.doc,.docx" required>
  </div>

  <div class="flex justify-between">
    <a href="modul.php" class="bg-gray-500 text-white px-4 py-2 rounded">Kembali</a>
    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Tambah</button>
  </div>
</form>

<?php require_once '../templates/footer.php'; ?>
