<?php
// Memberitahu browser bahwa output file ini adalah JSON
header('Content-Type: application/json');
require 'koneksi.php';

// Mengambil ID dari parameter URL
$id = $_GET['id'] ?? 0;

// Gunakan $koneksi (sesuai file koneksi.php)
$stmt = $koneksi->prepare("SELECT id, nama_depan, nama_belakang, user_name, foto FROM penulis WHERE id = ?");

if ($stmt) {
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $data = $result->fetch_assoc();
    
    if ($data) {
        // Mengembalikan data penulis jika ditemukan
        echo json_encode($data);
    } else {
        // Jika ID tidak ada di database
        echo json_encode(["status" => "error", "message" => "Data tidak ditemukan"]);
    }
    
    $stmt->close();
} else {
    // Jika terjadi error pada query
    echo json_encode(["status" => "error", "message" => $koneksi->error]);
}

$koneksi->close();
?>