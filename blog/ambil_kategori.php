<?php
include 'koneksi.php';

// Gunakan variabel $koneksi agar sesuai dengan file koneksi.php
$query = "SELECT * FROM kategori_artikel";
$result = mysqli_query($koneksi, $query);

$data = [];

// Cek apakah query berhasil
if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $data[] = $row;
    }
}

// Mengembalikan data dalam format JSON
echo json_encode($data);
?>