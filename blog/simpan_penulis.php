<?php
include "koneksi.php";

// Beritahu browser bahwa kita mengirim JSON
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama_depan = $_POST['nama_depan'];
    $nama_belakang = $_POST['nama_belakang'];
    $user_name = $_POST['user_name'];
    
    // Hash password untuk keamanan
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
    
    // Cek apakah ada file foto
    if (!isset($_FILES['foto']) || $_FILES['foto']['error'] == 4) {
        echo json_encode(['status' => 'error', 'message' => 'Foto wajib diunggah!']);
        exit;
    }

    $foto = $_FILES['foto'];

    // 1. Validasi Ukuran (2MB)
    if ($foto['size'] > 2 * 1024 * 1024) {
        echo json_encode(['status' => 'error', 'message' => 'Ukuran foto maksimal 2MB!']);
        exit;
    }

    // 2. Validasi Tipe (finfo)
    $finfo = new finfo(FILEINFO_MIME_TYPE);
    $mime_type = $finfo->file($foto['tmp_name']);
    $allowed_types = ['image/jpeg', 'image/png', 'image/jpg'];

    if (!in_array($mime_type, $allowed_types)) {
        echo json_encode(['status' => 'error', 'message' => 'Hanya file JPG/PNG yang diperbolehkan!']);
        exit;
    }

    // 3. Proses Simpan File
    $ext = pathinfo($foto['name'], PATHINFO_EXTENSION);
    $nama_foto = time() . "_" . $user_name . "." . $ext;
    
    if (move_uploaded_file($foto['tmp_name'], "uploads_penulis/" . $nama_foto)) {
        // 4. Prepared Statement
        $stmt = $koneksi->prepare("INSERT INTO penulis (nama_depan, nama_belakang, user_name, password, foto) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $nama_depan, $nama_belakang, $user_name, $password, $nama_foto);

        if ($stmt->execute()) {
            // Mengirim status 'ok' agar dibaca oleh index.php baris 190
            echo json_encode(['status' => 'ok']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Gagal menyimpan ke database.']);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Gagal mengunggah foto ke server.']);
    }
}