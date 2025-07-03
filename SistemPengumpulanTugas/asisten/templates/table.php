<table class="min-w-full divide-y divide-gray-200">
  <thead class="bg-gray-50">
    <tr>
      <?php foreach ($columns as $col): ?>
        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase"><?= $col ?></th>
      <?php endforeach; ?>
      <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Aksi</th>
    </tr>
  </thead>
  <tbody class="bg-white divide-y divide-gray-200">
    <?php if (!empty($data)): ?>
      <?php foreach ($data as $row): ?>
        <tr class="hover:bg-gray-50">
          <?php foreach ($fields as $field): ?>
            <td class="px-6 py-4 text-sm text-gray-800"><?= htmlspecialchars($row[$field]) ?></td>
          <?php endforeach; ?>
          <td class="px-6 py-4 text-sm text-gray-700 space-x-3">
            <?php include 'actions.php'; ?>
          </td>
        </tr>
      <?php endforeach; ?>
    <?php else: ?>
      <tr><td colspan="<?= count($fields) + 1 ?>" class="px-6 py-4 text-center text-gray-500">Tidak ada data</td></tr>
    <?php endif; ?>
  </tbody>
</table>
