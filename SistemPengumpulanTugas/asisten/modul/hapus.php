<?php
require_once '../../config.php';

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: modul.php");
    exit();
}

$id = (int) $_GET['id'];

// Ambil nama file materi sebelum hapus
$stmt = $conn->prepare("SELECT file_materi FROM modul WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    header("Location: modul.php?status=notfound");
    exit();
}

$row = $result->fetch_assoc();
$fileName = $row['file_materi'];

// Hapus file dari folder jika ada
if ($fileName) {
    $filePath = "../../uploads/modul/" . $fileName;
    if (file_exists($filePath)) {
        unlink($filePath);
    }
}

// Hapus data dari tabel modul
$stmt_delete = $conn->prepare("DELETE FROM modul WHERE id = ?");
$stmt_delete->bind_param("i", $id);

if ($stmt_delete->execute()) {
    header("Location: modul.php?status=hapus");
    exit();
} else {
    header("Location: modul.php?status=gagalhapus");
    exit();
}
