<div class="flex space-x-2">
  <?php if (isset($tipe) && $tipe === 'laporan'): ?>
    <!-- Tombol Unduh -->
    <?php if (!empty($row['file_laporan'])): ?>
      <a href="../../uploads/laporan/<?= rawurlencode($row['file_laporan']) ?>" 
        class="inline-block text-green-600 hover:text-green-800 mr-2" 
        title="Unduh File" download >
        <i class="fas fa-download"></i>
      </a>

    <?php else: ?>
      <span class="text-gray-400" title="Tidak ada file"><i class="fas fa-file"></i></span>
    <?php endif; ?>

    <!-- Tombol Feedback -->
    <?php if ($row['status_raw'] === 'sudah'): ?>
      <a href="detail.php?id=<?= $row['id_laporan'] ?>" 
         class="inline-block text-yellow-600 hover:text-yellow-800" 
         title="Beri Feedback">
        <i class="fas fa-comment-dots"></i>
      </a>
    <?php endif; ?>

  <?php else: ?>
    <!-- Default: Edit & Hapus -->
    <a href="edit.php?id=<?= $row['id'] ?>" 
       class="inline-block text-yellow-600 hover:text-yellow-800 mr-2" 
       title="Edit">
      <i class="fas fa-edit"></i>
    </a>
    <a href="hapus.php?id=<?= $row['id'] ?>" 
       onclick="return confirm('Yakin ingin hapus?')" 
       class="inline-block text-red-600 hover:text-red-800" 
       title="Hapus">
      <i class="fas fa-trash"></i>
    </a>
  <?php endif; ?>
</div>
