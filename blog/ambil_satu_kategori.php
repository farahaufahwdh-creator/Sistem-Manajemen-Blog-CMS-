<?php
include 'koneksi.php';

// Mengambil ID, bisa dari GET atau POST untuk fleksibilitas
$id = $_REQUEST['id'] ?? 0;

if ($id > 0) {
    // Gunakan variabel $koneksi sesuai file koneksi.php
    $stmt = $koneksi->prepare("SELECT * FROM kategori_artikel WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();

    $result = $stmt->get_result();
    $data = $result->fetch_assoc();

    // Jika data ditemukan, kirim datanya. Jika tidak, kirim pesan error.
    echo json_encode($data ? $data : ["status" => "error", "message" => "Data tidak ditemukan"]);
    
    $stmt->close();
} else {
    echo json_encode(["status" => "error", "message" => "ID tidak valid"]);
}
?>