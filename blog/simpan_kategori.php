<?php
include 'koneksi.php';

// Menangkap data dari form kategori
$nama = $_POST['nama_kategori'] ?? '';
$ket  = $_POST['keterangan'] ?? '';

// Gunakan variabel $koneksi (sesuai file koneksi.php kita)
$stmt = $koneksi->prepare("INSERT INTO kategori_artikel (nama_kategori, keterangan) VALUES (?, ?)");

if ($stmt) {
    $stmt->bind_param("ss", $nama, $ket);
    
    if ($stmt->execute()) {
        echo json_encode(["status" => "ok"]);
    } else {
        echo json_encode(["status" => "error", "message" => $stmt->error]);
    }
    $stmt->close();
} else {
    echo json_encode(["status" => "error", "message" => $koneksi->error]);
}
?>