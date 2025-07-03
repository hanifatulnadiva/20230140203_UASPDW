<a href="<?= $baseUrl ?>/detail.php?id=<?= $row['id'] ?>" class="text-blue-600 hover:text-blue-800"><i class="fas fa-eye"></i></a>
<a href="<?= $baseUrl ?>/edit.php?id=<?= $row['id'] ?>" class="text-yellow-600 hover:text-yellow-800"><i class="fas fa-edit"></i></a>
<a href="<?= $baseUrl ?>/hapus.php?id=<?= $row['id'] ?>" onclick="return confirm('Yakin ingin hapus?')" class="text-red-600 hover:text-red-800"><i class="fas fa-trash"></i></a>
