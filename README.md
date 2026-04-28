# Sistem Manajemen Blog (CMS) - UTS Pemrograman Web

Sistem Manajemen Konten (CMS) blog berbasis web yang dibangun menggunakan **PHP Native** dan **MySQL**. Aplikasi ini mengedepankan keamanan data, integritas relasional, dan antarmuka dinamis menggunakan **Fetch API (AJAX)** dan **SweetAlert2**.

## 🚀 Fitur Utama & Pembaruan Terbaru

- **Manajemen Penulis Terproteksi**: 
    - Penulis kini memiliki fitur **Foto Profil Opsional**. Jika user tidak mengunggah foto, sistem secara otomatis menetapkan `default.png`.
    - **Integritas Data**: Penulis tidak dapat dihapus jika masih memiliki artikel aktif di database.
- **Manajemen Kategori**: 
    - Pengorganisasian kategori yang terintegrasi dengan proteksi relasional (Restricted Delete).
- **Manajemen Artikel**: 
    - Penulisan konten dengan validasi gambar sampul maksimal 2MB.
    - Sinkronisasi data penulis dan kategori secara dinamis melalui JSON.
- **UI/UX Modern**: 
    - Notifikasi responsif menggunakan **SweetAlert2** untuk setiap aksi CRUD.
    - Navigasi Sidebar yang *seamless* (tanpa refresh halaman penuh).

## 🛡️ Implementasi Keamanan & Integritas

1.  **SQL Injection Protection**: Menggunakan **Prepared Statements** (`mysqli`) untuk semua transaksi database.
2.  **Server-Side File Validation**: Verifikasi keamanan file menggunakan library `finfo` untuk mengecek MIME type asli.
3.  **Database Constraints**: Menggunakan logika pengecekan relasi di sisi server (PHP) untuk mencegah data *orphan* (artikel tanpa penulis atau kategori).
4.  **Password Security**: Implementasi enkripsi password menggunakan algoritma **BCRYPT** (`password_hash`).

## 📁 Struktur Proyek (Final)

Seluruh file disusun secara modular dalam folder `blog/`:

```text
blog/
├── index.php                     # Dashboard Utama (Single Page Application Style)
├── koneksi.php                   # Konfigurasi Database MySQL
│
├── ambil_penulis.php             # Fetch data penulis (JSON)
├── simpan_penulis.php            # Insert penulis (Logic: Foto Default)
├── ambil_satu_penulis.php        # Fetch data satu penulis (Edit)
├── update_penulis.php            # Update data penulis
├── hapus_penulis.php             # Delete penulis (Logic: Cek Relasi Artikel)
│
├── ambil_kategori.php            # Fetch data kategori (JSON)
├── simpan_kategori.php           # Insert kategori baru
├── ambil_satu_kategori.php       # Fetch data satu kategori (Edit)
├── update_kategori.php           # Update data kategori
├── hapus_kategori.php            # Delete kategori (Logic: Cek Relasi Artikel)
│
├── ambil_artikel.php             # Fetch data artikel (JSON)
├── simpan_artikel.php            # Insert artikel & Validasi Gambar 2MB
├── ambil_satu_artikel.php        # Fetch data satu artikel (Edit)
├── update_artikel.php            # Update data artikel
├── hapus_artikel.php             # Delete artikel & cleanup file fisik
│
├── uploads_penulis/              # Folder Foto Profil (Wajib ada default.png)
└── uploads_artikel/              # Folder Gambar Sampul Artikel
