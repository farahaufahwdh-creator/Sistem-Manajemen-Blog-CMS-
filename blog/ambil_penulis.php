<?php
require 'koneksi.php';

// Ubah $conn menjadi $koneksi supaya cocok dengan file koneksi.php
$result = $koneksi->query("SELECT * FROM penulis ORDER BY id DESC");

$data = [];
while ($row = $result->fetch_assoc()) {
    $data[] = $row;
}

echo json_encode($data);
?>