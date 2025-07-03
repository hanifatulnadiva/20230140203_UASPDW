<?php
// 1. Definisi Variabel untuk Template
$pageTitle = 'Praktikum';
$activePage = 'praktikum';

// 2. Panggil Header
require_once '../templates/header.php'; 
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Kelola Mata Praktikum</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
  <div class="max-w-6xl mx-auto p-4">
    <h1 class="text-3xl font-bold text-center text-blue-800 mb-6">Kelola Mata Praktikum</h1>

    <!-- Form Tambah Praktikum -->
    <div class="bg-white shadow-md rounded p-6 mb-8">
      <h2 class="text-xl font-semibold mb-4">Tambah Praktikum</h2>
      <form action="add.php" method="POST" class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div>
          <label class="block mb-1 text-gray-600">Nama Praktikum</label>
          <input type="text" name="nama_praktikum" class="w-full border rounded px-3 py-2" required />
        </div>
        <div>
          <label class="block mb-1 text-gray-600">Semester</label>
          <input type="text" name="semester" class="w-full border rounded px-3 py-2" />
        </div>
        <div>
          <label class="block mb-1 text-gray-600">Dosen Pengampu</label>
          <input type="text" name="dosen_pengampu" class="w-full border rounded px-3 py-2" />
        </div>
        <div class="md:col-span-2">
          <label class="block mb-1 text-gray-600">Deskripsi</label>
          <textarea name="deskripsi" class="w-full border rounded px-3 py-2" rows="3"></textarea>
        </div>
        <div class="md:col-span-2 text-right">
          <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition">Tambah</button>
        </div>
      </form>
    </div>

    <!-- Tabel Praktikum -->
    <div class="bg-white shadow-md rounded p-6">
      <h2 class="text-xl font-semibold mb-4">Daftar Mata Praktikum</h2>
      <div class="overflow-x-auto">
        <table class="min-w-full text-left border">
          <thead>
            <tr class="bg-blue-200">
              <th class="px-4 py-2 border">No</th>
              <th class="px-4 py-2 border">Nama Praktikum</th>
              <th class="px-4 py-2 border">Semester</th>
              <th class="px-4 py-2 border">Dosen Pengampu</th>
              <th class="px-4 py-2 border">Aksi</th>
            </tr>
          </thead>
          <tbody>
            <!-- Contoh Baris Data -->
            <tr class="hover:bg-gray-100">
              <td class="px-4 py-2 border">1</td>
              <td class="px-4 py-2 border">Pemrograman Web</td>
              <td class="px-4 py-2 border">Ganjil</td>
              <td class="px-4 py-2 border">Pak Budi</td>
              <td class="px-4 py-2 border">
                <a href="edit.php?id=1" class="text-yellow-600 hover:underline mr-2">Edit</a>
                <a href="delete.php?id=1" class="text-red-600 hover:underline">Hapus</a>
              </td>
            </tr>
            <!-- Ulangi baris ini menggunakan loop PHP untuk data asli -->
          </tbody>
        </table>
      </div>
    </div>
  </div>
</body>
</html>

<?php
// 3. Panggil Footer
require_once 'templates/footer.php';
?>