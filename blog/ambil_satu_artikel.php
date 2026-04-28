<?php
require 'koneksi.php';

// Mengambil ID dari parameter URL (GET)
$id = $_GET['id'] ?? 0;

if ($id > 0) {
    // Pastikan menggunakan variabel $koneksi sesuai file koneksi.php
    $stmt = $koneksi->prepare("SELECT * FROM artikel WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();

    $result = $stmt->get_result();
    $data = $result->fetch_assoc();

    // Jika data ditemukan kirim JSON, jika tidak kirim pesan error
    echo json_encode($data ? $data : ["status" => "error", "message" => "Artikel tidak ditemukan"]);
    
    $stmt->close();
} else {
    echo json_encode(["status" => "error", "message" => "ID tidak valid"]);
}
?>