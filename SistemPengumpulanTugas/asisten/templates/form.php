<form action="<?= $action ?>" method="post" class="bg-white p-6 rounded shadow max-w-md mx-auto mt-8">
  <?php foreach ($fields as $key => $field): ?>
    <div class="mb-4">
      <label for="<?= $field ?>" class="block text-sm font-medium text-gray-700 mb-1">
        <?= $labels[$key] ?? ucfirst($field) ?>
      </label>

      <?php if ($field === 'role'): ?>
        <select 
          name="role" 
          id="role" 
          class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring focus:ring-blue-200"
          required
        >
          <option value="">-- Pilih Role --</option>
          <option value="mahasiswa" <?= ($isEdit && $data['role'] === 'mahasiswa') ? 'selected' : '' ?>>Mahasiswa</option>
          <option value="asisten" <?= ($isEdit && $data['role'] === 'asisten') ? 'selected' : '' ?>>Asisten</option>
        </select>

      <?php elseif ($field === 'password'): ?>
        <input 
          type="password" 
          name="password" 
          id="password"
          class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring focus:ring-blue-200"
          <?= $isEdit ? '' : 'required' ?>
        >

      <?php else: ?>
        <input 
          type="text" 
          name="<?= $field ?>" 
          id="<?= $field ?>" 
          value="<?= $isEdit && isset($data[$field]) ? htmlspecialchars($data[$field]) : '' ?>"
          class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring focus:ring-blue-200"
          required
        >
      <?php endif; ?>
    </div>
  <?php endforeach; ?>

  <div class="flex justify-between items-center mt-6">
  <button 
    type="submit"
    onclick="return confirm('Apakah Anda yakin ingin menyimpan data ini?')"
    class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700"
  >
    <?= $isEdit ? 'Update' : 'Simpan' ?>
  </button>
  <a href="<?= $backUrl ?>" class="text-gray-600 hover:underline">Batal</a>
</div>
</form>
