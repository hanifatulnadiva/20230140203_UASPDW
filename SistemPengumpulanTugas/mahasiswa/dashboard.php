<?php
$pageTitle = 'Dashboard';
$activePage = 'dashboard';
require_once 'templates/header_mahasiswa.php';
require_once '../config.php';

$id_user = $_SESSION['user_id'];

// Jumlah praktikum yang diikuti
$praktikumCount = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM peserta_praktikum WHERE id_user = $id_user"))['total'];

// Jumlah tugas selesai
$tugasSelesai = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM laporan WHERE id_user = $id_user AND status = 'sudah'"))['total'];

// Jumlah tugas menunggu
$tugasMenunggu = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM laporan WHERE id_user = $id_user AND status = 'belum'"))['total'];

// Notifikasi laporan terbaru
$notifQuery = "
  SELECT l.*, m.judul_modul 
  FROM laporan l
  JOIN modul m ON l.id_modul = m.id
  WHERE l.id_user = $id_user
  ORDER BY l.tanggal_upload DESC
  LIMIT 3
";
$notifResult = mysqli_query($conn, $notifQuery);

// Data grafik global status tugas per modul
$chartSql = "
  SELECT m.judul_modul,
         IFNULL(l.status, 'belum') AS status
  FROM peserta_praktikum pp
  JOIN praktikum p ON pp.id_praktikum = p.id
  JOIN modul m ON m.id_praktikum = p.id
  LEFT JOIN laporan l ON l.id_modul = m.id AND l.id_user = $id_user
  WHERE pp.id_user = $id_user
  GROUP BY m.id
";
$chartData = mysqli_query($conn, $chartSql);
$labels = $sudah = $belum = [];

while ($row = mysqli_fetch_assoc($chartData)) {
    $labels[] = $row['judul_modul'];
    $sudah[] = $row['status'] === 'sudah' ? 1 : 0;
    $belum[] = $row['status'] === 'belum' ? 1 : 0;
}
?>

<div class="bg-gradient-to-r from-blue-500 to-cyan-400 text-white p-8 rounded-xl shadow-lg mb-8">
    <h1 class="text-3xl font-bold">Selamat Datang, <?= htmlspecialchars($_SESSION['nama']) ?>!</h1>
    <p class="mt-2 opacity-90">Terus semangat dalam menyelesaikan semua modul praktikummu.</p>
</div>

<!-- Kartu Statistik -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
    <div class="bg-white p-6 rounded-xl shadow-md flex flex-col items-center justify-center">
        <div class="text-5xl font-extrabold text-blue-600"><?= $praktikumCount ?></div>
        <div class="mt-2 text-lg text-gray-600">Praktikum Diikuti</div>
    </div>
    <div class="bg-white p-6 rounded-xl shadow-md flex flex-col items-center justify-center">
        <div class="text-5xl font-extrabold text-green-500"><?= $tugasSelesai ?></div>
        <div class="mt-2 text-lg text-gray-600">Tugas Selesai</div>
    </div>
    <div class="bg-white p-6 rounded-xl shadow-md flex flex-col items-center justify-center">
        <div class="text-5xl font-extrabold text-yellow-500"><?= $tugasMenunggu ?></div>
        <div class="mt-2 text-lg text-gray-600">Tugas Menunggu</div>
    </div>
</div>

<!-- Grafik Global -->
<div class="bg-white p-6 rounded-xl shadow-md mb-8">
    <h3 class="text-2xl font-bold text-gray-800 mb-4">📊 Status Tugas per Modul</h3>
    <canvas id="grafikGlobal" height="100"></canvas>
</div>

<!-- Notifikasi Terbaru -->
<div class="bg-white p-6 rounded-xl shadow-md">
    <h3 class="text-2xl font-bold text-gray-800 mb-4">🔔 Notifikasi Terbaru</h3>
    <ul class="space-y-4">
        <?php while ($notif = mysqli_fetch_assoc($notifResult)): ?>
            <li class="flex items-start p-3 border-b border-gray-100 last:border-b-0">
                <span class="text-xl mr-4">
                    <?= $notif['status'] === 'sudah' ? '✅' : '⏳' ?>
                </span>
                <div>
                    <?= $notif['status'] === 'sudah' ? 'Nilai untuk' : 'Belum mengumpulkan' ?>
                    <a href="modul.php?id=<?= $notif['id_modul'] ?>" class="font-semibold text-blue-600 hover:underline">
                        <?= htmlspecialchars($notif['judul_modul']) ?>
                    </a>
                    <?= $notif['status'] === 'sudah' && $notif['nilai'] !== null ? ' telah dinilai: <b>' . $notif['nilai'] . '</b>' : '' ?>.
                </div>
            </li>
        <?php endwhile; ?>
    </ul>
</div>

<?php require_once 'templates/footer_mahasiswa.php'; ?>

<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
const ctx = document.getElementById('grafikGlobal').getContext('2d');
new Chart(ctx, {
    type: 'bar',
    data: {
        labels: <?= json_encode($labels) ?>,
        datasets: [
            {
                label: 'Sudah Dikerjakan',
                data: <?= json_encode($sudah) ?>,
                backgroundColor: '#4ade80' // green
            },
            {
                label: 'Belum Dikerjakan',
                data: <?= json_encode($belum) ?>,
                backgroundColor: '#f87171' // red
            }
        ]
    },
    options: {
        responsive: true,
        plugins: {
            title: { display: true, text: 'Status Tugas Seluruh Modul' },
            legend: { position: 'top' }
        },
        scales: {
            x: { stacked: true },
            y: { stacked: true, beginAtZero: true }
        }
    }
});
</script>
