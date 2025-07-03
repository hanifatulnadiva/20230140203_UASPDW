<?php
require_once 'config.php';
$sql = "SELECT * FROM praktikum ORDER BY nama_praktikum ASC";
$result = mysqli_query($conn, $sql);
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Katalog Praktikum</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
  <style>
    body {
      font-family: 'Poppins', sans-serif;
      background-color: #EEEFE0;
    }
    .bg-kampus {
      background-color: #819A91;
    }
    .text-kampus {
      color: #819A91;
    }
    .btn-kampus {
      background-color: #A7C1A8;
    }
    .card-kampus {
      background-color: #D1D8BE;
    }
  </style>
</head>
<body class="text-gray-800">

  <!-- Header -->
<header class="bg-kampus text-white py-4 shadow-md">
  <div class="max-w-7xl mx-auto px-6 flex items-center justify-between">
    
    <!-- Kiri: Logo & Judul -->
    <div>
      <h1 class="text-2xl font-bold">🌐 Sistem Informasi Praktikum</h1>
      <p class="text-sm opacity-90">Fakultas Teknologi Informasi - Universitas Contoh</p>
    </div>
    
    <!-- Kanan: Tombol Login -->
    <div>
      <a href="login.php" class="btn-kampus text-white px-5 py-2 rounded font-semibold transition hover:opacity-90">
        Masuk ke Sistem
      </a>
    </div>

  </div>
</header>



  <!-- Konten -->
  <main class="container mx-auto px-6 py-10">
    <h2 class="text-2xl font-semibold text-kampus mb-6 text-center">📚 Daftar Mata Praktikum</h2>

    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
      <?php while ($row = mysqli_fetch_assoc($result)): ?>
        <div class="card-kampus rounded-lg shadow-md hover:shadow-lg transition border border-gray-300 p-5 text-center">
          <div class="mb-4 flex justify-center">
            <!-- Icon akademik -->
            <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-kampus" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5zm0 0v6m0 0l-3-3m3 3l3-3" />
            </svg>
          </div>
          <h3 class="text-lg font-bold"><?= htmlspecialchars($row['nama_praktikum']) ?></h3>
          <p class="text-sm">Semester: <?= htmlspecialchars($row['semester']) ?></p>
          <p class="text-sm mt-1 text-gray-700">Kode: <?= htmlspecialchars($row['kode_praktikum'] ?? '-') ?></p>
        </div>
      <?php endwhile; ?>
    </div>

    <div class="mt-10 text-center">
      <a href="login.php" class="inline-block btn-kampus text-white px-6 py-2 rounded font-semibold transition hover:opacity-90">
        Masuk ke Sistem
      </a>
    </div>
  </main>

  <footer class="bg-gray-300 mt-10 py-4 text-center text-sm text-gray-600">
    &copy; <?= date('Y') ?> Sistem Praktikum • Universitas Contoh
  </footer>
</body>
</html>
