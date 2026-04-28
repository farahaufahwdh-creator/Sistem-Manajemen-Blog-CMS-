<?php
header('Content-Type: application/json'); // Penting agar JavaScript tahu ini JSON
require 'koneksi.php';

// Menangkap data dari form
$id = $_POST['id'] ?? 0;
$nama_depan = htmlspecialchars($_POST['nama_depan']);
$nama_belakang = htmlspecialchars($_POST['nama_belakang']);
$user_name = htmlspecialchars($_POST['user_name']);

// 1. Ambil Data Lama (untuk Password dan Foto cadangan)
$res = $koneksi->query("SELECT password, foto FROM penulis WHERE id=$id");
if ($res->num_rows === 0) {
    echo json_encode(['status' => 'error', 'message' => 'Data penulis tidak ditemukan']);
    exit;
}
$old = $res->fetch_assoc();

// 2. Logika Password
// Jika input password tidak kosong, hash password baru. Jika kosong, pakai yang lama.
$password = !empty($_POST['password']) ? password_hash($_POST['password'], PASSWORD_BCRYPT) : $old['password'];

// 3. Logika Foto
$foto = $old['foto'];

if (isset($_FILES['foto']) && $_FILES['foto']['error'] === 0) {
    $allowed_types = ['image/jpeg', 'image/jpg', 'image/png'];
    $file_size = $_FILES['foto']['size'];
    $tmp_name = $_FILES['foto']['tmp_name'];
    
    // Validasi tipe file (pakai mime content type lebih aman)
    $finfo = new finfo(FILEINFO_MIME_TYPE);
    $mime = $finfo->file($tmp_name);

    if (in_array($mime, $allowed_types) && $file_size <= 2097152) { // Max 2MB
        $ext = pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION);
        $nama_foto_baru = uniqid() . '.' . $ext;
        $folder = 'uploads_penulis/';

        // Buat folder jika belum ada
        if (!file_exists($folder)) {
            mkdir($folder, 0777, true);
        }

        if (move_uploaded_file($tmp_name, $folder . $nama_foto_baru)) {
            // Hapus foto lama jika ada dan bukan file default
            if ($old['foto'] && $old['foto'] != 'default.png' && file_exists($folder . $old['foto'])) {
                unlink($folder . $old['foto']);
            }
            $foto = $nama_foto_baru;
        }
    }
}

// 4. Proses Update ke Database
$stmt = $koneksi->prepare("UPDATE penulis SET nama_depan=?, nama_belakang=?, user_name=?, password=?, foto=? WHERE id=?");
$stmt->bind_param("sssssi", $nama_depan, $nama_belakang, $user_name, $password, $foto, $id);

if ($stmt->execute()) {
    // Sesuaikan dengan pengecekan di index.php (status: ok atau updated)
    echo json_encode(['status' => 'updated']); 
} else {
    echo json_encode(['status' => 'error', 'message' => $stmt->error]);
}

$stmt->close();
$koneksi->close();
?>