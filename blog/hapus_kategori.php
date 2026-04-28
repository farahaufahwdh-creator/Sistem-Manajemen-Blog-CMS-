<?php
include "koneksi.php";
header('Content-Type: application/json'); // Penting agar JS tahu ini JSON

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];

    // 1. CEK RELASI: Apakah kategori ini sedang dipakai di tabel artikel?
    $cek = $koneksi->prepare("SELECT id FROM artikel WHERE id_kategori = ?");
    $cek->bind_param("i", $id);
    $cek->execute();
    $result = $cek->get_result();

    if ($result->num_rows > 0) {
        // Jika ada artikel, kirim pesan error
        echo json_encode([
            'status' => 'error',
            'message' => 'Gagal! Kategori ini tidak bisa dihapus karena masih digunakan oleh artikel.'
        ]);
        exit;
    } else {
        // Jika aman, lakukan penghapusan
        $stmt = $koneksi->prepare("DELETE FROM kategori_artikel WHERE id = ?");
        $stmt->bind_param("i", $id);
        
        if ($stmt->execute()) {
            echo json_encode(['status' => 'deleted']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Gagal menghapus dari database.']);
        }
    }
}