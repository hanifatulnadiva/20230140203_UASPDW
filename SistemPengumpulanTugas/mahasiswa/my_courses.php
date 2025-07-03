<?php
$pageTitle = 'Praktikum Saya';
$activePage = 'my_courses';
require_once 'templates/header_mahasiswa.php';
require_once '../config.php';

$userId = $_SESSION['user_id'];

// Ambil semua praktikum yang sudah diikuti mahasiswa
$sql = "
  SELECT p.*
  FROM peserta_praktikum pp
  JOIN praktikum p ON pp.id_praktikum = p.id
  WHERE pp.id_user = $userId
  ORDER BY p.nama_praktikum ASC
";
$result = mysqli_query($conn, $sql);
?>

<div class="container mx-auto p-6 lg:p-8">
  <h1 class="text-2xl font-bold text-gray-800 mb-4">Praktikum yang Anda Ikuti</h1>

  <?php if (mysqli_num_rows($result) > 0): ?>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
      <?php while ($row = mysqli_fetch_assoc($result)): ?>
        <a href="modul.php?id=<?= $row['id'] ?>" class="block bg-white rounded-lg shadow p-4 border border-gray-200 hover:shadow-lg hover:ring-2 hover:ring-blue-400 transition duration-200 text-center">
          <!-- Ikon buku -->
          <div class="flex justify-center mb-4">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 0C9.613 4 8 5.613 8 8v8c0 2.387 1.613 4 4 4s4-1.613 4-4V8c0-2.387-1.613-4-4-4z" />
            </svg>
          </div>

          <h2 class="text-lg font-semibold text-gray-700 mb-1"><?= htmlspecialchars($row['nama_praktikum']) ?></h2>
          <p class="text-sm text-gray-600">Semester: <?= $row['semester'] ?></p>
        </a>
      <?php endwhile; ?>
    </div>
  <?php else: ?>
    <div class="text-gray-600">Kamu belum terdaftar di praktikum mana pun.</div>
  <?php endif; ?>
</div>
