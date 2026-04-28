<?php
require 'koneksi.php';

$id          = $_POST['id'] ?? 0;
$judul       = htmlspecialchars($_POST['judul'] ?? '');
$id_penulis  = $_POST['id_penulis'] ?? 0;
$id_kategori = $_POST['id_kategori'] ?? 0;
$isi         = htmlspecialchars($_POST['isi'] ?? '');

if ($id > 0) {
    // 1. Ambil nama gambar lama dari database
    // Gunakan prepared statement agar lebih aman
    $stmtOld = $koneksi->prepare("SELECT gambar FROM artikel WHERE id = ?");
    $stmtOld->bind_param("i", $id);
    $stmtOld->execute();
    $res = $stmtOld->get_result();
    $old = $res->fetch_assoc();
    $gambar = $old['gambar']; // Default gunakan gambar lama

    // 2. Logika jika ada unggahan gambar baru
    if (isset($_FILES['gambar']) && $_FILES['gambar']['error'] === 0) {
        if ($_FILES['gambar']['size'] <= 2097152) { // Maks 2MB
            $finfo = new finfo(FILEINFO_MIME_TYPE);
            $mime  = $finfo->file($_FILES['gambar']['tmp_name']);
            
            if (in_array($mime, ['image/jpeg', 'image/png'])) {
                $ext = pathinfo($_FILES['gambar']['name'], PATHINFO_EXTENSION);
                $new_filename = uniqid() . '.' . $ext;
                
                if (move_uploaded_file($_FILES['gambar']['tmp_name'], 'uploads_artikel/' . $new_filename)) {
                    $gambar = $new_filename; // Update variabel gambar ke nama baru
                    
                    // Hapus file gambar lama dari folder jika ada
                    if (!empty($old['gambar']) && file_exists('uploads_artikel/' . $old['gambar'])) {
                        unlink('uploads_artikel/' . $old['gambar']);
                    }
                }
            }
        }
    }

    // 3. Update data ke database
    $stmt = $koneksi->prepare("UPDATE artikel SET id_penulis=?, id_kategori=?, judul=?, isi=?, gambar=? WHERE id=?");
    $stmt->bind_param("iisssi", $id_penulis, $id_kategori, $judul, $isi, $gambar, $id);

    if ($stmt->execute()) {
        echo json_encode(['status' => 'success']);
    } else {
        echo json_encode(['status' => 'error', 'msg' => $stmt->error]);
    }
    
    $stmt->close();
} else {
    echo json_encode(['status' => 'error', 'msg' => 'ID tidak valid']);
}
?>