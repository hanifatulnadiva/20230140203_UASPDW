<?php
require_once '../../config.php';

$message = '';
$success = false;

// Ambil ID
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// Ambil data user
$stmt = $conn->prepare("SELECT * FROM users WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows === 0) {
    die("Pengguna tidak ditemukan.");
}
$data = $result->fetch_assoc();

// Proses jika POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama = trim($_POST['nama']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $role = trim($_POST['role']);

    if (empty($nama) || empty($email) || empty($role)) {
        $message = "Field wajib diisi.";
    } else {
        // Cek email ganda
        $stmt = $conn->prepare("SELECT id FROM users WHERE email = ? AND id != ?");
        $stmt->bind_param("si", $email, $id);
        $stmt->execute();
        $stmt->store_result();
        if ($stmt->num_rows > 0) {
            $message = "Email sudah digunakan.";
        } else {
            if (!empty($password)) {
                $hashed = password_hash($password, PASSWORD_BCRYPT);
                $stmt = $conn->prepare("UPDATE users SET nama=?, email=?, password=?, role=? WHERE id=?");
                $stmt->bind_param("ssssi", $nama, $email, $hashed, $role, $id);
            } else {
                $stmt = $conn->prepare("UPDATE users SET nama=?, email=?, role=? WHERE id=?");
                $stmt->bind_param("sssi", $nama, $email, $role, $id);
            }

            if ($stmt->execute()) {
                header("Location: akun.php?status=update");
                exit();
            } else {
                $message = "Gagal menyimpan.";
            }
        }
    }
}

// --- baru tampilkan HTML
require_once '../templates/header.php';

// set variabel untuk form
$fields = ['nama', 'email', 'password', 'role'];
$labels = ['Nama Lengkap', 'Email', 'Password (opsional)', 'Role'];
$action = '';
$isEdit = true;
?>

<!-- Notifikasi jika gagal -->
<?php if (!empty($message)): ?>
  <div class="p-3 bg-red-100 text-red-800 rounded mb-4 max-w-md mx-auto"><?= $message ?></div>
<?php endif; ?>

<?php include '../templates/form.php'; ?>
<?php require_once '../templates/footer.php'; ?>
