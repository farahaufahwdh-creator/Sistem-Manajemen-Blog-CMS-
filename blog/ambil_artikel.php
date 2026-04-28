<?php
require 'koneksi.php';

// Menggunakan JOIN untuk mengambil nama penulis dan nama kategori sekaligus
$query = "SELECT a.*, 
                 p.nama_depan, p.nama_belakang, 
                 k.nama_kategori 
          FROM artikel a 
          JOIN penulis p ON a.id_penulis = p.id 
          JOIN kategori_artikel k ON a.id_kategori = k.id 
          ORDER BY a.id DESC";

// Pastikan menggunakan variabel $koneksi sesuai file koneksi.php
$result = $koneksi->query($query);

$data = [];

if ($result) {
    while ($row = $result->fetch_assoc()) {
        // Menggabungkan nama depan dan belakang untuk kemudahan di frontend
        $row['nama_penulis'] = $row['nama_depan'] . ' ' . $row['nama_belakang'];
        $data[] = $row;
    }
}

// Mengirimkan hasil dalam format JSON
header('Content-Type: application/json');
echo json_encode($data);
?>