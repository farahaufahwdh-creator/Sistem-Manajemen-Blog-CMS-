<?php
require 'koneksi.php';

// Menangkap ID dari POST
$id = $_POST['id'] ?? 0;

if ($id > 0) {
    // 1. Ambil nama file gambar terlebih dahulu sebelum datanya dihapus
    $stmtImg = $koneksi->prepare("SELECT gambar FROM artikel WHERE id = ?");
    $stmtImg->bind_param("i", $id);
    $stmtImg->execute();
    $res = $stmtImg->get_result();
    $data = $res->fetch_assoc();

    // 2. Hapus data dari database
    $stmtDel = $koneksi->prepare("DELETE FROM artikel WHERE id = ?");
    $stmtDel->bind_param("i", $id);

    if ($stmtDel->execute()) {
        // 3. Jika berhasil hapus dari DB, hapus juga file fisiknya di server
        if (!empty($data['gambar'])) {
            $path = 'uploads_artikel/' . $data['gambar'];
            if (file_exists($path)) {
                unlink($path);
            }
        }
        echo json_encode(['status' => 'success']);
    } else {
        echo json_encode(['status' => 'error', 'msg' => 'Gagal menghapus data dari database.']);
    }

    $stmtImg->close();
    $stmtDel->close();
} else {
    echo json_encode(['status' => 'error', 'msg' => 'ID tidak valid.']);
}
?>