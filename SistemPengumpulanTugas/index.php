<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Katalog Praktikum - SIMAKSI</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
  <style>
    body {
      font-family: 'Poppins', sans-serif;
    }
    .fade-up {
      opacity: 0;
      transform: translateY(20px);
      animation: fadeUp 0.6s ease-out forwards;
    }
    @keyframes fadeUp {
      to {
        opacity: 1;
        transform: translateY(0);
      }
    }
  </style>
</head>
<body class="bg-gradient-to-br from-white to-gray-100 text-gray-800">

  <!-- Header -->
  <header class="bg-white border-b border-gray-200 py-6 shadow-sm">
    <div class="max-w-6xl mx-auto px-6 flex justify-between items-center">
      <div>
        <h1 class="text-3xl font-extrabold text-blue-700 tracking-wide">🌐 SIMAKSI</h1>
        <p class="text-sm text-gray-500">Sistem Informasi Manajemen Praktikum</p>
      </div>
      <a href="login.php" class="text-white bg-blue-600 hover:bg-blue-700 font-medium px-5 py-2 rounded-md transition shadow-sm">
        Masuk ke Sistem
      </a>
    </div>
  </header>

  <!-- Hero -->
  <section class="text-center py-12 px-4 bg-white shadow-inner">
    <h2 class="text-2xl sm:text-3xl font-semibold text-blue-700 mb-2">📚 Daftar Mata Praktikum</h2>
    <p class="text-gray-600">Berikut adalah daftar tetap mata praktikum yang tersedia.</p>
  </section>

  <!-- Kartu Praktikum -->
  <main class="max-w-6xl mx-auto px-6 py-12">
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">

      <?php
      $praktikum = [
        ['nama' => 'Praktikum PABD', 'semester' => 4, 'kode' => 'PABD401'],
        ['nama' => 'Praktikum STQA', 'semester' => 4, 'kode' => 'STQA401'],
        ['nama' => 'Praktikum PDW', 'semester' => 5, 'kode' => 'PDW501'],
        ['nama' => 'Praktikum Deploy', 'semester' => 5, 'kode' => 'DEP501'],
        ['nama' => 'Praktikum Cyber', 'semester' => 6, 'kode' => 'CYB601'],
      ];
      $delay = 0.1;
      foreach ($praktikum as $p):
      ?>
        <div class="bg-white border border-gray-200 rounded-xl p-6 shadow-md hover:shadow-lg transform hover:-translate-y-1 transition-all fade-up" style="animation-delay: <?= $delay ?>s">
          <div class="mb-4 flex justify-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 14l9-5-9-5-9 5 9 5zm0 0v6m0 0l-3-3m3 3l3-3"/>
            </svg>
          </div>
          <h3 class="text-lg font-bold text-gray-800"><?= $p['nama'] ?></h3>
          <p class="text-sm text-gray-500 mt-1">Semester: <?= $p['semester'] ?></p>
          <p class="text-xs text-gray-400 mt-1">Kode: <?= $p['kode'] ?></p>
        </div>
      <?php $delay += 0.1; endforeach; ?>
    </div>

    <div class="text-center mt-12">
      <a href="login.php" class="inline-block bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-md font-semibold transition">
        Masuk ke Sistem
      </a>
    </div>
  </main>

  <!-- Footer -->
  <footer class="text-center text-sm text-gray-500 py-6 border-t border-gray-200 bg-white">
    &copy; <?= date('Y') ?> SIMAKSI 
  </footer>
</body>
</html>
