# Sistem Manajemen Blog (CMS) - UTS Pemrograman Web

Sistem Manajemen Konten (CMS) blog berbasis web yang dibangun menggunakan PHP Native dan MySQL. Proyek ini menerapkan integrasi Fetch API (AJAX) untuk operasional CRUD yang dinamis dan responsif.

## 🚀 Fitur Utama

- **Kelola Penulis**: Manajemen data penulis lengkap dengan fitur unggah foto profil.
- **Kelola Kategori**: Pengorganisasian kategori artikel dengan proteksi integritas data.
- **Kelola Artikel**: Publikasi artikel blog yang terhubung secara relasional ke penulis dan kategori.
- **User Interface**: Menggunakan Bootstrap 5 dan notifikasi interaktif SweetAlert2.

## 🛡️ Implementasi Keamanan & Validasi

- **Prepared Statements**: Seluruh query menggunakan teknik ini untuk menangkal serangan **SQL Injection**.
- **Validasi File Server-Side**: Pengecekan ukuran maksimal **2MB** dan verifikasi MIME type file gambar menggunakan `finfo`.
- **Integritas Referensial**: Sistem mencegah penghapusan kategori yang masih memiliki artikel terkait untuk menjaga konsistensi database.
- **Proteksi Direktori**: Penggunaan `.htaccess` pada folder unggahan untuk mencegah eksekusi skrip berbahaya dari luar.

## 📁 Struktur Proyek

Sesuai dengan ketentuan tugas, seluruh file disimpan dalam folder `blog/` dengan struktur sebagai berikut:

```text
blog/
├── index.php                     # Halaman Dashboard Utama
├── koneksi.php                   # Konfigurasi Koneksi Database
│
├── ambil_penulis.php             # Fetch semua data penulis (JSON)
├── simpan_penulis.php            # Proses Insert penulis baru
├── ambil_satu_penulis.php        # Fetch data satu penulis untuk Edit
├── update_penulis.php            # Proses Update data penulis
├── hapus_penulis.php             # Proses Delete data penulis
│
├── ambil_kategori.php            # Fetch semua data kategori (JSON)
├── simpan_kategori.php           # Proses Insert kategori baru
├── ambil_satu_kategori.php       # Fetch data satu kategori untuk Edit
├── update_kategori.php           # Proses Update data kategori
├── hapus_kategori.php            # Proses Delete kategori & Cek Relasi
│
├── ambil_artikel.php             # Fetch semua data artikel (JSON)
├── simpan_artikel.php            # Proses Insert artikel baru & Validasi Gambar
├── ambil_satu_artikel.php        # Fetch data satu artikel untuk Edit
├── update_artikel.php            # Proses Update data artikel
├── hapus_artikel.php             # Proses Delete artikel & Hapus File Gambar
│
├── uploads_penulis/              # Folder Penyimpanan Foto Penulis
│   ├── .htaccess                 # Security: Deny Script Execution
│   └── default.png               # Foto profil default
│
└── uploads_artikel/              # Folder Penyimpanan Gambar Artikel
    └── .htaccess                 # Security: Deny Script Execution
