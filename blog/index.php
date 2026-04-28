<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Manajemen Blog (CMS)</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        body { background-color: #f8f9fa; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; overflow-x: hidden; }
        .top-header { background-color: #343a40; color: white; padding: 15px 25px; border-bottom: 3px solid #28a745; }
        .top-header h1 { margin: 0; font-size: 22px; font-weight: bold; }
        .top-header p { margin: 0; color: #adb5bd; font-size: 13px; }
        .sidebar { background-color: #ffffff; min-height: calc(100vh - 85px); border-right: 1px solid #dee2e6; padding: 0; }
        .sidebar .nav-label { padding: 20px 20px 10px; font-size: 11px; font-weight: bold; color: #6c757d; text-transform: uppercase; letter-spacing: 1px; }
        .sidebar .nav-link { color: #333; padding: 12px 25px; font-size: 14px; border-left: 4px solid transparent; display: flex; align-items: center; text-decoration: none; transition: 0.2s; }
        .sidebar .nav-link i { width: 25px; font-size: 16px; margin-right: 10px; color: #6c757d; }
        .sidebar .nav-link:hover { background-color: #f8f9fa; color: #28a745; }
        .sidebar .nav-link.active { background-color: #f1f3f5; color: #28a745; border-left-color: #28a745; font-weight: 600; }
        .sidebar .nav-link.active i { color: #28a745; }
        .content-area { padding: 30px; }
        .section-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; border-bottom: 1px solid #dee2e6; padding-bottom: 15px; }
        .section-header h2 { font-size: 20px; font-weight: bold; color: #333; margin: 0; }
        .table-card { background: white; border-radius: 5px; border: 1px solid #dee2e6; box-shadow: 0 2px 4px rgba(0,0,0,0.05); }
        .table th { border-bottom: 1px solid #dee2e6; padding: 12px; font-size: 13px; color: #495057; }
        .table td { padding: 12px; vertical-align: middle; font-size: 14px; border-bottom: 1px solid #f1f3f5; }
        .img-thumb { width: 45px; height: 45px; border-radius: 4px; object-fit: cover; border: 1px solid #ddd; }
    </style>
</head>
<body>

<header class="top-header">
    <div class="container-fluid">
        <h1>Sistem Manajemen Blog (CMS)</h1>
        <p>Aplikasi Pengelolaan Konten Blog</p>
    </div>
</header>

<div class="container-fluid">
    <div class="row">
        <nav class="col-md-3 col-lg-2 sidebar">
            <div class="nav-label">Menu Navigasi</div>
            <div class="nav flex-column">
                <a class="nav-link active" id="tab-penulis" href="javascript:void(0)" onclick="showSection('penulis')">
                    <i class="fas fa-user-edit"></i> Kelola Penulis
                </a>
                <a class="nav-link" id="tab-artikel" href="javascript:void(0)" onclick="showSection('artikel')">
                    <i class="fas fa-newspaper"></i> Kelola Artikel
                </a>
                <a class="nav-link" id="tab-kategori" href="javascript:void(0)" onclick="showSection('kategori')">
                    <i class="fas fa-list"></i> Kelola Kategori
                </a>
            </div>
        </nav>

        <main class="col-md-9 col-lg-10 content-area">
            
            <div id="sec-penulis" class="content-section">
                <div class="section-header">
                    <h2>Data Penulis</h2>
                    <button class="btn btn-success btn-sm" onclick="modalTambahPenulis()">
                        <i class="fas fa-plus"></i> Tambah Penulis
                    </button>
                </div>
                <div class="table-card">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th width="60">Foto</th>
                                <th>Nama Lengkap</th>
                                <th>Username</th>
                                <th width="120">Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="list-penulis"></tbody>
                    </table>
                </div>
            </div>

            <div id="sec-artikel" class="content-section d-none">
                <div class="section-header">
                    <h2>Data Artikel</h2>
                    <button class="btn btn-success btn-sm" onclick="modalTambahArtikel()">
                        <i class="fas fa-plus"></i> Tambah Artikel
                    </button>
                </div>
                <div class="table-card">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th width="60">Gambar</th>
                                <th>Judul Artikel</th>
                                <th>Kategori</th>
                                <th>Penulis</th>
                                <th>Waktu Update</th>
                                <th width="120">Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="list-artikel"></tbody>
                    </table>
                </div>
            </div>

            <div id="sec-kategori" class="content-section d-none">
                <div class="section-header">
                    <h2>Data Kategori</h2>
                    <button class="btn btn-success btn-sm" onclick="modalTambahKategori()">
                        <i class="fas fa-plus"></i> Tambah Kategori
                    </button>
                </div>
                <div class="table-card">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th>Nama Kategori</th>
                                <th>Keterangan</th>
                                <th width="120">Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="list-kategori"></tbody>
                    </table>
                </div>
            </div>
        </main>
    </div>
</div>

<div class="modal fade" id="modal-penulis" tabindex="-1">
    <div class="modal-dialog">
        <form id="f-penulis" enctype="multipart/form-data">
            <div class="modal-content">
                <div class="modal-header"><h5 id="judul-modal-penulis">Input Data Penulis</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
                <div class="modal-body">
                    <input type="hidden" name="id" id="p-id">
                    <div class="row mb-3">
                        <div class="col-6"><label class="small fw-bold">Nama Depan</label><input type="text" class="form-control" name="nama_depan" id="p-nd" required></div>
                        <div class="col-6"><label class="small fw-bold">Nama Belakang</label><input type="text" class="form-control" name="nama_belakang" id="p-nb" required></div>
                    </div>
                    <div class="mb-3"><label class="small fw-bold">Username</label><input type="text" class="form-control" name="user_name" id="p-un" required></div>
                    <div class="mb-3">
                        <label class="small fw-bold">Password</label>
                        <input type="password" class="form-control" name="password" id="p-pass">
                        <small class="text-muted" id="pass-help">*Kosongkan jika tidak ingin mengubah password</small>
                    </div>
                    <div class="mb-3">
                        <label class="small fw-bold">Foto Profil</label>
                        <input type="file" class="form-control" name="foto" id="p-foto">
                        <small class="text-muted">*Kosongkan untuk menggunakan default.png</small>
                    </div>
                </div>
                <div class="modal-footer"><button type="submit" class="btn btn-success w-100">Simpan Data</button></div>
            </div>
        </form>
    </div>
</div>

<div class="modal fade" id="modal-kategori" tabindex="-1">
    <div class="modal-dialog">
        <form id="f-kategori">
            <div class="modal-content">
                <div class="modal-header"><h5 id="judul-modal-kategori">Input Data Kategori</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
                <div class="modal-body">
                    <input type="hidden" name="id" id="k-id">
                    <div class="mb-3"><label class="small fw-bold">Nama Kategori</label><input type="text" class="form-control" name="nama_kategori" id="k-nama" required></div>
                    <div class="mb-3"><label class="small fw-bold">Keterangan</label><textarea class="form-control" name="keterangan" id="k-ket" rows="3"></textarea></div>
                </div>
                <div class="modal-footer"><button type="submit" class="btn btn-success w-100">Simpan Kategori</button></div>
            </div>
        </form>
    </div>
</div>

<div class="modal fade" id="modal-artikel" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <form id="f-artikel" enctype="multipart/form-data">
            <div class="modal-content">
                <div class="modal-header"><h5 id="judul-modal-artikel">Input Artikel</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
                <div class="modal-body">
                    <input type="hidden" name="id" id="art-id">
                    <div class="mb-3">
                        <label class="small fw-bold">Judul Artikel</label>
                        <input type="text" class="form-control" name="judul" id="art-judul" required>
                    </div>
                    <div class="row mb-3">
                        <div class="col-6">
                            <label class="small fw-bold">Penulis</label>
                            <select class="form-select" name="id_penulis" id="art-penulis" required></select>
                        </div>
                        <div class="col-6">
                            <label class="small fw-bold">Kategori</label>
                            <select class="form-select" name="id_kategori" id="art-kategori" required></select>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="small fw-bold">Isi Artikel</label>
                        <textarea class="form-control" name="isi" id="art-isi" rows="5" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="small fw-bold">Gambar Sampul</label>
                        <input type="file" class="form-control" name="gambar" id="art-gambar">
                        <small class="text-muted">*Maksimal 2MB (JPG/PNG)</small>
                    </div>
                </div>
                <div class="modal-footer"><button type="submit" class="btn btn-success w-100">Simpan Artikel</button></div>
            </div>
        </form>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    const modalP = new bootstrap.Modal(document.getElementById('modal-penulis'));
    const modalK = new bootstrap.Modal(document.getElementById('modal-kategori'));
    const modalA = new bootstrap.Modal(document.getElementById('modal-artikel'));

    function showSection(target) {
        document.querySelectorAll('.content-section').forEach(s => s.classList.add('d-none'));
        document.querySelectorAll('.nav-link').forEach(l => l.classList.remove('active'));
        document.getElementById('sec-' + target).classList.remove('d-none');
        document.getElementById('tab-' + target).classList.add('active');
        
        if(target === 'penulis') fetchPenulis();
        if(target === 'kategori') fetchKategori();
        if(target === 'artikel') { fetchArtikel(); loadDropdowns(); }
    }

    async function loadDropdowns() {
        const resP = await fetch('ambil_penulis.php');
        const dataP = await resP.json();
        let optP = '<option value="">Pilih Penulis</option>';
        dataP.forEach(p => optP += `<option value="${p.id}">${p.nama_depan} ${p.nama_belakang}</option>`);
        document.getElementById('art-penulis').innerHTML = optP;

        const resK = await fetch('ambil_kategori.php');
        const dataK = await resK.json();
        let optK = '<option value="">Pilih Kategori</option>';
        dataK.forEach(k => optK += `<option value="${k.id}">${k.nama_kategori}</option>`);
        document.getElementById('art-kategori').innerHTML = optK;
    }

    // --- CRUD PENULIS ---
    async function fetchPenulis() {
        const res = await fetch('ambil_penulis.php');
        const data = await res.json();
        let html = '';
        data.forEach(p => {
            html += `<tr>
                <td><img src="uploads_penulis/${p.foto}" class="img-thumb" onerror="this.src='uploads_penulis/default.png'"></td>
                <td>${p.nama_depan} ${p.nama_belakang}</td>
                <td><span class="text-success fw-bold">${p.user_name}</span></td>
                <td>
                    <button class="btn btn-warning btn-sm text-white" onclick="editPenulis(${p.id})"><i class="fas fa-edit"></i></button>
                    <button class="btn btn-danger btn-sm" onclick="hapusPenulis(${p.id})"><i class="fas fa-trash"></i></button>
                </td>
            </tr>`;
        });
        document.getElementById('list-penulis').innerHTML = html || '<tr><td colspan="4" class="text-center">Kosong</td></tr>';
    }

    function modalTambahPenulis() {
        document.getElementById('f-penulis').reset();
        document.getElementById('p-id').value = '';
        document.getElementById('pass-help').classList.add('d-none');
        modalP.show();
    }

    async function editPenulis(id) {
        const data = await (await fetch(`ambil_satu_penulis.php?id=${id}`)).json();
        if(data.id) {
            document.getElementById('p-id').value = data.id;
            document.getElementById('p-nd').value = data.nama_depan;
            document.getElementById('p-nb').value = data.nama_belakang;
            document.getElementById('p-un').value = data.user_name;
            document.getElementById('pass-help').classList.remove('d-none');
            modalP.show();
        }
    }

    document.getElementById('f-penulis').onsubmit = async function(e) {
        e.preventDefault();
        const id = document.getElementById('p-id').value;
        const url = id ? 'update_penulis.php' : 'simpan_penulis.php';
        const res = await fetch(url, { method: 'POST', body: new FormData(this) });
        const result = await res.json();
        if(result.status === 'ok' || result.status === 'updated') {
            Swal.fire('Berhasil!', 'Data penulis diproses.', 'success');
            modalP.hide(); fetchPenulis();
        } else {
            Swal.fire('Gagal!', result.message, 'error');
        }
    };

    async function hapusPenulis(id) {
    const confirm = await Swal.fire({ 
        title: 'Hapus Penulis?', 
        text: "Data yang dihapus tidak bisa dikembalikan!",
        icon: 'warning', 
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#6e7881',
        confirmButtonText: 'Ya, Hapus!'
    });

    if (confirm.isConfirmed) {
        const fd = new FormData(); 
        fd.append('id', id);
        
        const res = await fetch('hapus_penulis.php', { method: 'POST', body: fd });
        const result = await res.json();

        if (result.status === 'success') { 
            fetchPenulis(); 
            Swal.fire('Terhapus!', 'Data penulis telah dihapus.', 'success'); 
        } else {
            // Ini akan memunculkan pesan "Penulis tidak bisa dihapus..." dari PHP
            Swal.fire('Gagal!', result.message, 'error');
        }
    }
}

    // --- CRUD KATEGORI ---
    async function fetchKategori() {
        const res = await fetch('ambil_kategori.php');
        const data = await res.json();
        let html = '';
        data.forEach(k => {
            html += `<tr>
                <td><span class="fw-bold">${k.nama_kategori}</span></td>
                <td>${k.keterangan}</td>
                <td>
                    <button class="btn btn-warning btn-sm text-white" onclick="editKategori(${k.id})"><i class="fas fa-edit"></i></button>
                    <button class="btn btn-danger btn-sm" onclick="hapusKategori(${k.id})"><i class="fas fa-trash"></i></button>
                </td>
            </tr>`;
        });
        document.getElementById('list-kategori').innerHTML = html || '<tr><td colspan="3" class="text-center">Kosong</td></tr>';
    }

    function modalTambahKategori() { document.getElementById('f-kategori').reset(); document.getElementById('k-id').value = ''; modalK.show(); }

    async function editKategori(id) {
        const data = await (await fetch(`ambil_satu_kategori.php?id=${id}`)).json();
        if(data.id) {
            document.getElementById('k-id').value = data.id;
            document.getElementById('k-nama').value = data.nama_kategori;
            document.getElementById('k-ket').value = data.keterangan;
            modalK.show();
        }
    }

    document.getElementById('f-kategori').onsubmit = async function(e) {
        e.preventDefault();
        const id = document.getElementById('k-id').value;
        const url = id ? 'update_kategori.php' : 'simpan_kategori.php';
        const res = await fetch(url, { method: 'POST', body: new FormData(this) });
        const result = await res.json();
        if(result.status === 'ok' || result.status === 'updated') {
            Swal.fire('Berhasil!', 'Data kategori disimpan.', 'success');
            modalK.hide(); fetchKategori();
        }
    };

    async function hapusKategori(id) {
        if ((await Swal.fire({ title: 'Hapus Kategori?', icon: 'warning', showCancelButton: true })).isConfirmed) {
            const fd = new FormData(); fd.append('id', id);
            const res = await fetch('hapus_kategori.php', { method: 'POST', body: fd });
            const result = await res.json();
            if(result.status === 'deleted') { fetchKategori(); Swal.fire('Dihapus!', '', 'success'); }
            else { Swal.fire('Gagal!', result.message, 'error'); }
        }
    }

    // --- CRUD ARTIKEL ---
    async function fetchArtikel() {
        const res = await fetch('ambil_artikel.php');
        const data = await res.json();
        let html = '';
        data.forEach(a => {
            html += `<tr>
                <td><img src="uploads_artikel/${a.gambar}" class="img-thumb" onerror="this.src='https://placehold.co/45x45?text=No+Img'"></td>
                <td class="fw-bold">${a.judul}</td>
                <td><span class="badge bg-primary">${a.nama_kategori}</span></td>
                <td>${a.nama_depan} ${a.nama_belakang}</td>
                <td class="small">${a.hari_tanggal}</td>
                <td>
                    <button class="btn btn-warning btn-sm text-white" onclick="editArtikel(${a.id})"><i class="fas fa-edit"></i></button>
                    <button class="btn btn-danger btn-sm" onclick="hapusArtikel(${a.id})"><i class="fas fa-trash"></i></button>
                </td>
            </tr>`;
        });
        document.getElementById('list-artikel').innerHTML = html || '<tr><td colspan="6" class="text-center">Kosong</td></tr>';
    }

    function modalTambahArtikel() { document.getElementById('f-artikel').reset(); document.getElementById('art-id').value = ''; modalA.show(); }

    async function editArtikel(id) {
        const data = await (await fetch(`ambil_satu_artikel.php?id=${id}`)).json();
        if(data.id) {
            document.getElementById('art-id').value = data.id;
            document.getElementById('art-judul').value = data.judul;
            document.getElementById('art-penulis').value = data.id_penulis;
            document.getElementById('art-kategori').value = data.id_kategori;
            document.getElementById('art-isi').value = data.isi;
            modalA.show();
        }
    }

    document.getElementById('f-artikel').onsubmit = async function(e) {
        e.preventDefault();
        const id = document.getElementById('art-id').value;
        const url = id ? 'update_artikel.php' : 'simpan_artikel.php';
        const res = await fetch(url, { method: 'POST', body: new FormData(this) });
        const result = await res.json();
        if(result.status === 'success' || result.status === 'updated') {
            Swal.fire('Berhasil!', 'Artikel disimpan.', 'success');
            modalA.hide(); fetchArtikel();
        } else {
            Swal.fire('Gagal!', result.msg || 'Terjadi kesalahan', 'error');
        }
    };

    async function hapusArtikel(id) {
        if ((await Swal.fire({ title: 'Hapus Artikel?', icon: 'warning', showCancelButton: true })).isConfirmed) {
            const fd = new FormData(); fd.append('id', id);
            const res = await fetch('hapus_artikel.php', { method: 'POST', body: fd });
            const result = await res.json();
            if(result.status === 'success') { fetchArtikel(); Swal.fire('Dihapus!', '', 'success'); }
        }
    }

    window.onload = fetchPenulis;
</script>
</body>
</html>
