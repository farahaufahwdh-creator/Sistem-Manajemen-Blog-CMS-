<?php
include 'koneksi.php';

// Menangkap data dari POST
$id   = $_POST['id'] ?? 0;
$nama = $_POST['nama_kategori'] ?? '';
$ket  = $_POST['keterangan'] ?? '';

if ($id > 0 && !empty($nama)) {
    // Gunakan variabel $koneksi (bukan $conn) sesuai file koneksi.php kita
    $stmt = $koneksi->prepare("UPDATE kategori_artikel SET nama_kategori = ?, keterangan = ? WHERE id = ?");
    
    if ($stmt) {
        $stmt->bind_param("ssi", $nama, $ket, $id);
        
        if ($stmt->execute()) {
            echo json_encode(["status" => "updated"]);
        } else {
            echo json_encode(["status" => "error", "message" => $stmt->error]);
        }
        $stmt->close();
    } else {
        echo json_encode(["status" => "error", "message" => $koneksi->error]);
    }
} else {
    echo json_encode(["status" => "error", "message" => "Data tidak lengkap atau ID tidak valid"]);
}
?>