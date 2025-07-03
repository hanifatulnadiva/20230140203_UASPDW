<?php
require_once '../../config.php';

// Validasi ID
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: akun.php");
    exit();
}

$id = (int) $_GET['id'];

// Cek apakah user ada
$stmt = $conn->prepare("SELECT id FROM users WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows === 0) {
    // User tidak ditemukan
    header("Location: akun.php?status=notfound");
    exit();
}

// Hapus data
$stmt_delete = $conn->prepare("DELETE FROM users WHERE id = ?");
$stmt_delete->bind_param("i", $id);

if ($stmt_delete->execute()) {
    header("Location: akun.php?status=hapus");
    exit();
} else {
    // Jika gagal, bisa arahkan ke error
    header("Location: akun.php?status=gagalhapus");
    exit();
}
