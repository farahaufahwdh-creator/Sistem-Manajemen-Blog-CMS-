<?php
$host = "127.0.0.1"; 
$user = "root";
$pass = "Farahrara25."; // Pakai password ini karena port 3307 minta password
$db   = "db_blog";
$port = "3307"; // PAKSA ke 3307 karena di sanalah database db_blog kamu berada

// Membuat koneksi
$koneksi = new mysqli($host, $user, $pass, $db, $port);

// Cek koneksi
if ($koneksi->connect_error) {
    // Jika password salah, kita coba kosongkan (untuk jaga-jaga)
    $koneksi = new mysqli($host, $user, "", $db, $port);
    
    if ($koneksi->connect_error) {
        die("Koneksi gagal: " . $koneksi->connect_error);
    }
}
?>