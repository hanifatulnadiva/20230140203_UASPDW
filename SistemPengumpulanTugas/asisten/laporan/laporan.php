<?php
$pageTitle = 'Laporan';
$activePage = 'laporan';
require_once '../templates/header.php';
require_once '../../config.php';
$tipe = 'laporan';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'asisten') {
    header("Location: ../../login.php");
    exit();
}

// Ambil filter dari URL
$search = $_GET['search'] ?? '';
$status = $_GET['status'] ?? '';
$id_modul = $_GET['id_modul'] ?? '';

// Ambil daftar modul untuk dropdown
$modulList = mysqli_query($conn, "SELECT id, judul_modul FROM modul ORDER BY judul_modul ASC");

// Query data laporan
$sql = "
    SELECT l.id_laporan, u.nama AS nama_mahasiswa, m.judul_modul,
           l.judul_laporan, l.tanggal_upload, l.status, l.file_laporan
    FROM laporan l
    JOIN users u ON l.id_user = u.id
    JOIN modul m ON l.id_modul = m.id
    WHERE u.role = 'mahasiswa'
";

// Tambahkan filter search
if (!empty($search)) {
    $search = mysqli_real_escape_string($conn, $search);
    $sql .= " AND (
        u.nama LIKE '%$search%' OR 
        m.judul_modul LIKE '%$search%'
    )";
}

// Tambahkan filter status
if ($status === 'sudah' || $status === 'belum') {
    $sql .= " AND l.status = '$status'";
}

// Tambahkan filter modul
if (!empty($id_modul)) {
    $id_modul = mysqli_real_escape_string($conn, $id_modul);
    $sql .= " AND m.id = '$id_modul'";
}

$sql .= " ORDER BY l.tanggal_upload DESC";
$result = mysqli_query($conn, $sql);

// Siapkan data untuk table.php
$columns = ['No', 'Nama Mahasiswa', 'Modul', 'Judul Laporan', 'Tanggal Upload', 'Status'];
$fields = ['no', 'nama_mahasiswa', 'judul_modul', 'judul_laporan', 'tanggal_upload', 'status'];
$data = [];

$no = 1;
while ($row = mysqli_fetch_assoc($result)) {
    $data[] = [
        'no' => $no++,
        'nama_mahasiswa' => $row['nama_mahasiswa'],
        'judul_modul' => $row['judul_modul'],
        'judul_laporan' => $row['judul_laporan'] ?: '-',
        'tanggal_upload' => $row['tanggal_upload'] ? date('d-m-Y H:i', strtotime($row['tanggal_upload'])) : '-',
        'status' => $row['status'] === 'sudah' ? '✅ Sudah' : '❌ Belum',
        'id_laporan' => $row['id_laporan'],
        'file_laporan' => $row['file_laporan'],
        'status_raw' => $row['status'] // untuk actions.php
    ];
}

// Render filter
echo '<div class="mb-4">
    <form method="GET" id="filterForm" class="flex flex-wrap gap-2 items-center">
        <input type="text" name="search" placeholder="Cari mahasiswa / modul" value="' . htmlspecialchars($search) . '" class="border p-1 px-2 rounded">

        <select name="id_modul" class="border p-1 rounded">
            <option value="">Semua Modul</option>';
            while ($modul = mysqli_fetch_assoc($modulList)) {
                $selected = ($id_modul == $modul['id']) ? 'selected' : '';
                echo '<option value="' . $modul['id'] . '" ' . $selected . '>' . htmlspecialchars($modul['judul_modul']) . '</option>';
            }
        echo '</select>

        <select name="status" class="border p-1 rounded">
            <option value="">Semua Status</option>
            <option value="sudah" ' . ($status === 'sudah' ? 'selected' : '') . '>Sudah Dikumpulkan</option>
            <option value="belum" ' . ($status === 'belum' ? 'selected' : '') . '>Belum Dikumpulkan</option>
        </select>

        <a href="laporan.php" class="text-blue-500 underline">Reset</a>
    </form>
</div>

<script>
  const form = document.getElementById("filterForm");

  form.status.addEventListener("change", function () {
    form.submit();
  });

  form.id_modul.addEventListener("change", function () {
    form.submit();
  });

  let typingTimer;
  form.search.addEventListener("keyup", function () {
    clearTimeout(typingTimer);
    typingTimer = setTimeout(() => form.submit(), 500);
  });
</script>';

require_once '../templates/table.php';
