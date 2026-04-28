<?php
include "koneksi.php";
date_default_timezone_set('Asia/Jakarta');
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_penulis = $_POST['id_penulis'];
    $id_kategori = $_POST['id_kategori'];
    $judul = $_POST['judul'];
    $isi = $_POST['isi'];
    $gambar = $_FILES['gambar'];

    // 1. Validasi Ukuran (2MB)
    if ($gambar['size'] > 2 * 1024 * 1024) {
        echo json_encode(['status' => 'error', 'msg' => 'Gambar terlalu besar! Maksimal 2MB.']);
        exit;
    }

    // 2. Validasi Tipe File
    $finfo = new finfo(FILEINFO_MIME_TYPE);
    $mime = $finfo->file($gambar['tmp_name']);
    if (!in_array($mime, ['image/jpeg', 'image/png'])) {
        echo json_encode(['status' => 'error', 'msg' => 'Hanya file JPG/PNG yang diizinkan!']);
        exit;
    }

    // 3. Proses Upload & Insert
    $nama_gambar = time() . "_" . $gambar['name'];
    if (move_uploaded_file($gambar['tmp_name'], "uploads_artikel/" . $nama_gambar)) {
        
        $daftar_hari = ["Minggu", "Senin", "Selasa", "Rabu", "Kamis", "Jumat", "Sabtu"];
        $hari = $daftar_hari[date('w')];
        $tgl_indo = $hari . ", " . date('d F Y | H:i');

        $stmt = $koneksi->prepare("INSERT INTO artikel (id_penulis, id_kategori, judul, isi, gambar, hari_tanggal) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("iissss", $id_penulis, $id_kategori, $judul, $isi, $nama_gambar, $tgl_indo);
        
        if ($stmt->execute()) {
            echo json_encode(['status' => 'success']);
        } else {
            echo json_encode(['status' => 'error', 'msg' => 'Gagal simpan ke database.']);
        }
    }
}