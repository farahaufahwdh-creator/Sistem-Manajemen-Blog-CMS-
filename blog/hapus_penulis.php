<?php
include "koneksi.php";
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];

    // 1. Cek apakah penulis ini masih memiliki artikel
    $check = $koneksi->prepare("SELECT id FROM artikel WHERE id_penulis = ? LIMIT 1");
    $check->bind_param("i", $id);
    $check->execute();
    $resultCheck = $check->get_result();

    if ($resultCheck->num_rows > 0) {
        // Jika ada artikel, kirim pesan error
        echo json_encode([
            'status' => 'error', 
            'message' => 'Penulis tidak bisa dihapus karena masih memiliki artikel aktif!'
        ]);
        exit;
    }

    // 2. Jika tidak ada artikel, ambil nama foto untuk dihapus dari folder (opsional tapi bagus)
    $queryFoto = $koneksi->prepare("SELECT foto FROM penulis WHERE id = ?");
    $queryFoto->bind_param("i", $id);
    $queryFoto->execute();
    $resFoto = $queryFoto->get_result()->fetch_assoc();

    // 3. Proses hapus dari database
    $stmt = $koneksi->prepare("DELETE FROM penulis WHERE id = ?");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        // Hapus file fisik jika bukan default.png
        if ($resFoto['foto'] != 'default.png' && file_exists("uploads_penulis/" . $resFoto['foto'])) {
            unlink("uploads_penulis/" . $resFoto['foto']);
        }
        echo json_encode(['status' => 'success']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Gagal menghapus data dari database.']);
    }
}
