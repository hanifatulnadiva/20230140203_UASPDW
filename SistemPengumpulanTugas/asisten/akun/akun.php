<?php
$pageTitle = 'Akun';
$activePage = 'akun';

require_once '../templates/header.php'; 
require_once '../../config.php';

// --- Pagination setup ---
$limit = 10;
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int) $_GET['page'] : 1;
$offset = ($page - 1) * $limit;

// --- Total data ---
$totalQuery = $conn->query("SELECT COUNT(*) AS total FROM users");
$totalData = $totalQuery->fetch_assoc()['total'];
$totalPages = ceil($totalData / $limit);

// --- Ambil data pengguna sesuai halaman ---
$sql = "SELECT * FROM users ORDER BY created_at DESC LIMIT $limit OFFSET $offset";
$result = $conn->query($sql);

$users = [];
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $users[] = $row;
    }
}
?>

<!-- Notifikasi -->
<?php if (isset($_GET['status'])): ?>
  <?php
    $status = $_GET['status'];
    $messages = [
      'update' => 'Data pengguna berhasil diperbarui.',
      'tambah' => 'Pengguna berhasil ditambahkan.',
      'hapus'  => 'Pengguna berhasil dihapus.',
    ];
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
    + Tambah Mahasiswa/Asisten
  </a>
</div>

<!-- Tabel Pengguna -->
<div class="bg-white shadow rounded-lg overflow-hidden mt-4 mx-auto max-w-6xl">
  <div class="flex justify-between items-center px-6 py-4 border-b border-gray-200">
    <h3 class="text-lg font-semibold text-gray-800">Daftar Mahasiswa dan Asisten</h3>
  </div>

  <div class="overflow-x-auto">
    <table class="min-w-full divide-y divide-gray-200">
      <thead class="bg-gray-50">
        <tr>
          <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Id</th>
          <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Nama</th>
          <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Email</th>
          <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Role</th>
          <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Tanggal Buat</th>
          <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Aksi</th>
        </tr>
      </thead>
      <tbody class="bg-white divide-y divide-gray-200">
        <?php if (!empty($users)): ?>
          <?php foreach ($users as $index => $user): ?>
            <tr class="hover:bg-gray-50">
              <td class="px-6 py-4 text-sm text-gray-800"><?= $offset + $index + 1 ?></td>
              <td class="px-6 py-4 text-sm"><?= htmlspecialchars($user['nama']) ?></td>
              <td class="px-6 py-4 text-sm"><?= htmlspecialchars($user['email']) ?></td>
              <td class="px-6 py-4">
                <span class="px-2 py-1 text-xs font-medium rounded-full <?= $user['role'] === 'mahasiswa' ? 'bg-blue-100 text-blue-800' : 'bg-purple-100 text-purple-800' ?>">
                  <?= ucfirst($user['role']) ?>
                </span>
              </td>
              <td class="px-6 py-4 text-sm text-gray-500"><?= date('d M Y', strtotime($user['created_at'])) ?></td>
              <td class="px-6 py-4 text-sm text-gray-700 space-x-3">
                <a href="edit.php?id=<?= $user['id'] ?>" class="text-yellow-600 hover:text-yellow-800" title="Edit">
                  <i class="fas fa-edit"></i>
                </a>
                <a href="hapus.php?id=<?= $user['id'] ?>" onclick="return confirm('Yakin ingin menghapus pengguna ini?')" class="text-red-600 hover:text-red-800" title="Hapus">
                  <i class="fas fa-trash"></i>
                </a>
              </td>
            </tr>
          <?php endforeach; ?>
        <?php else: ?>
          <tr><td colspan="6" class="px-6 py-4 text-center text-gray-500">Tidak ada data pengguna</td></tr>
        <?php endif; ?>
      </tbody>
    </table>
  </div>

  <!-- Pagination -->
  <?php if ($totalPages > 1): ?>
    <div class="px-6 py-4 border-t border-gray-200 bg-gray-50 flex justify-center space-x-2">
      <?php for ($i = 1; $i <= $totalPages; $i++): ?>
        <a href="?page=<?= $i ?>" class="px-3 py-1 border rounded <?= $i === $page ? 'bg-blue-600 text-white' : 'bg-white text-gray-700 hover:bg-gray-100' ?>">
          <?= $i ?>
        </a>
      <?php endfor; ?>
    </div>
  <?php endif; ?>
</div>


<script>
  const notif = document.getElementById('notif');

  function hideNotif() {
    if (notif) {
      notif.style.opacity = '0';
      setTimeout(() => notif.remove(), 300);
      window.removeEventListener('scroll', hideNotif);
      document.removeEventListener('click', hideNotif);
    }
  }

  // Hilangkan notifikasi saat scroll atau klik
  window.addEventListener('scroll', hideNotif);
  document.addEventListener('click', hideNotif)
</script>

<?php require_once '../templates/footer.php'; ?>
