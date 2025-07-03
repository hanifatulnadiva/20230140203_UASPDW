<?php
require_once '../../config.php';

$message = '';
$success = false;

// Proses form sebelum ada output HTML
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama     = trim($_POST['nama']);
    $email    = trim($_POST['email']);
    $password = trim($_POST['password']);
    $role     = trim($_POST['role']);

    if (empty($nama) || empty($email) || empty($password) || empty($role)) {
        $message = "Semua field harus diisi!";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $message = "Format email tidak valid!";
    } elseif (!in_array($role, ['mahasiswa', 'asisten'])) {
        $message = "Peran tidak valid!";
    } else {
        // Cek email duplikat
        $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $message = "Email sudah terdaftar.";
        } else {
            $hashed_password = password_hash($password, PASSWORD_BCRYPT);
            $stmt = $conn->prepare("INSERT INTO users (nama, email, password, role) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("ssss", $nama, $email, $hashed_password, $role);

            if ($stmt->execute()) {
                // ✅ Redirect sebelum HTML dikirim
                header("Location: akun.php?status=tambah");
                exit();
            } else {
                $message = "Gagal menyimpan data.";
            }
        }
    }
}

// Setelah semua proses → baru tampilkan form dan HTML
require_once '../templates/header.php';

$fields = ['nama', 'email', 'password', 'role'];
$labels = ['Nama Lengkap', 'Email', 'Password', 'Role'];
$data = [];
$action = ''; // karena submit ke halaman yang sama
$isEdit = false;
?>

<div class="max-w-md mx-auto mt-6">
  <?php if (!empty($message)): ?>
    <div class="p-3 bg-red-100 text-red-800 rounded mb-4"><?= $message ?></div>
  <?php endif; ?>
  
  <?php include '../templates/form.php'; ?>
</div>

<?php require_once '../templates/footer.php'; ?>
