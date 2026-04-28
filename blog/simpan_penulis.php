<?php
include "koneksi.php";
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama_depan = $_POST['nama_depan'];
    $nama_belakang = $_POST['nama_belakang'];
    $user_name = $_POST['user_name'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

    // 1. Set nama file default terlebih dahulu
    $nama_foto = "default.png"; 

    // 2. Cek apakah user mengunggah foto
    if (isset($_FILES['foto']) && $_FILES['foto']['error'] != 4) {
        $foto = $_FILES['foto'];

        // Validasi Ukuran (2MB)
        if ($foto['size'] > 2 * 1024 * 1024) {
            echo json_encode(['status' => 'error', 'message' => 'Ukuran foto maksimal 2MB!']);
            exit;
        }

        // Validasi Tipe
        $finfo = new finfo(FILEINFO_MIME_TYPE);
        $mime_type = $finfo->file($foto['tmp_name']);
        if (!in_array($mime_type, ['image/jpeg', 'image/png', 'image/jpg'])) {
            echo json_encode(['status' => 'error', 'message' => 'Format foto harus JPG/PNG!']);
            exit;
        }

        // Jika valid, beri nama unik dan pindahkan
        $ext = pathinfo($foto['name'], PATHINFO_EXTENSION);
        $nama_foto = time() . "_" . $user_name . "." . $ext;
        move_uploaded_file($foto['tmp_name'], "uploads_penulis/" . $nama_foto);
    }

    // 3. Simpan ke database (menggunakan $nama_foto yang bisa jadi default atau hasil upload)
    $stmt = $koneksi->prepare("INSERT INTO penulis (nama_depan, nama_belakang, user_name, password, foto) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $nama_depan, $nama_belakang, $user_name, $password, $nama_foto);

    if ($stmt->execute()) {
        echo json_encode(['status' => 'ok']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Gagal menyimpan ke database.']);
    }
}
