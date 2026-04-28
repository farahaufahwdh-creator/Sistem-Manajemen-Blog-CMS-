<?php
header('Content-Type: application/json'); // Tambahkan agar konsisten
require 'koneksi.php';

// Menangkap ID dari POST
$id = $_POST['id'] ?? 0;

if ($id > 0) {
    // 1. Ambil info foto untuk dihapus dari folder
    // Menggunakan query langsung karena ID sudah dipastikan angka (int)
    $res = $koneksi->query("SELECT foto FROM penulis WHERE id=$id");
    $data_lama = $res->fetch_assoc();

    // 2. Proses hapus data di database menggunakan Prepared Statement
    $stmt = $koneksi->prepare("DELETE FROM penulis WHERE id = ?");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        // 3. Hapus file fisik foto jika ada dan bukan default
        if ($data_lama && !empty($data_lama['foto']) && $data_lama['foto'] != 'default.png') {
            $path = 'uploads_penulis/' . $data_lama['foto'];
            if (file_exists($path)) {
                unlink($path);
            }
        }
        // Respon 'success' sudah sesuai dengan pengecekan di index.php
        echo json_encode(['status' => 'success']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Gagal menghapus dari database.']);
    }
    $stmt->close();
} else {
    echo json_encode(['status' => 'error', 'message' => 'ID tidak valid.']);
}

$koneksi->close();
?>