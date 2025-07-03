<?php
$pageTitle = 'Dashboard';
$activePage = 'dashboard';
require_once 'templates/header.php';
require_once '../config.php';

// Jumlah modul diajarkan
$modulCount = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM modul"))['total'];

// Jumlah laporan masuk
$laporanMasuk = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM laporan"))['total'];

// Laporan belum dinilai
$laporanBelumDinilai = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM laporan WHERE nilai IS NULL"))['total'];

// Aktivitas laporan terbaru
$aktivitasSql = "
    SELECT u.nama, m.judul_modul, l.tanggal_upload 
    FROM laporan l
    JOIN users u ON l.id_user = u.id
    JOIN modul m ON l.id_modul = m.id
    ORDER BY l.tanggal_upload DESC
    LIMIT 5
";
$aktivitasResult = mysqli_query($conn, $aktivitasSql);
?>

<!-- Statistik -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
    <!-- Modul -->
    <div class="bg-white p-6 rounded-lg shadow-md flex items-center space-x-4">
        <div class="bg-blue-100 p-3 rounded-full">
            <svg class="w-6 h-6 text-blue-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75..."/>
            </svg>
        </div>
        <div>
            <p class="text-sm text-gray-500">Total Modul Diajarkan</p>
            <p class="text-2xl font-bold text-gray-800"><?= $modulCount ?></p>
        </div>
    </div>

    <!-- Laporan Masuk -->
    <div class="bg-white p-6 rounded-lg shadow-md flex items-center space-x-4">
        <div class="bg-green-100 p-3 rounded-full">
            <svg class="w-6 h-6 text-green-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15..."/>
            </svg>
        </div>
        <div>
            <p class="text-sm text-gray-500">Total Laporan Masuk</p>
            <p class="text-2xl font-bold text-gray-800"><?= $laporanMasuk ?></p>
        </div>
    </div>

    <!-- Belum Dinilai -->
    <div class="bg-white p-6 rounded-lg shadow-md flex items-center space-x-4">
        <div class="bg-yellow-100 p-3 rounded-full">
            <svg class="w-6 h-6 text-yellow-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5..."/>
            </svg>
        </div>
        <div>
            <p class="text-sm text-gray-500">Laporan Belum Dinilai</p>
            <p class="text-2xl font-bold text-gray-800"><?= $laporanBelumDinilai ?></p>
        </div>
    </div>
</div>

<!-- Aktivitas -->
<div class="bg-white p-6 rounded-lg shadow-md mt-8">
    <h3 class="text-xl font-bold text-gray-800 mb-4">Aktivitas Laporan Terbaru</h3>
    <div class="space-y-4">
        <?php while ($row = mysqli_fetch_assoc($aktivitasResult)): ?>
            <?php 
              $inisial = strtoupper(substr($row['nama'], 0, 1));
              $waktu = date('d M Y, H:i', strtotime($row['tanggal_upload']));
            ?>
            <div class="flex items-center">
                <div class="w-10 h-10 rounded-full bg-gray-200 flex items-center justify-center mr-4 font-bold text-gray-500">
                    <?= $inisial ?>
                </div>
                <div>
                    <p class="text-gray-800">
                        <strong><?= htmlspecialchars($row['nama']) ?></strong> mengumpulkan laporan untuk <strong><?= htmlspecialchars($row['judul_modul']) ?></strong>
                    </p>
                    <p class="text-sm text-gray-500"><?= $waktu ?></p>
                </div>
            </div>
        <?php endwhile; ?>
    </div>
</div>

<?php require_once 'templates/footer.php'; ?>
