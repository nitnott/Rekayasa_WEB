@extends('layouts.main')

@section('title', 'Data Mahasiswa AJAX')

@section('content')
<div class="container mt-4">
    <h2>Data Mahasiswa</h2>
    <p>Kelola data mahasiswa menggunakan AJAX.</p>

    <button class="btn btn-primary mb-3" onclick="tambahData()">
        Tambah Mahasiswa
    </button>

    <div class="table-responsive">
        <table class="table table-bordered table-striped">
            <thead class="table-dark">
                <tr>
                    <th>NIM</th>
                    <th>Nama</th>
                    <th>Jenis Kelamin</th>
                    <th>Prodi</th>
                    <th>No. Telepon</th>
                    <th>Alamat</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody id="tabelMahasiswa"></tbody>
        </table>
    </div>
</div>

<div class="modal fade" id="modalMahasiswa" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="judulModal">Tambah Mahasiswa</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <form id="formMahasiswa">
                    <div class="mb-3">
                        <label class="form-label">NIM</label>
                        <input type="text" id="nim" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Nama</label>
                        <input type="text" id="nama" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Jenis Kelamin</label>
                        <select id="jk" class="form-select" required>
                            <option value="">Pilih Jenis Kelamin</option>
                            <option value="L">Laki-laki</option>
                            <option value="P">Perempuan</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Program Studi</label>
                        <input type="text" id="prodi" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">No. Telepon</label>
                        <input type="text" id="no_telp" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Alamat</label>
                        <textarea id="alamat" class="form-control" required></textarea>
                    </div>
                </form>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-primary" onclick="simpanData()">Simpan</button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
const apiUrl = '/api/mahasiswa';
let modeEdit = false;
let nimLama = '';
let modal;

document.addEventListener('DOMContentLoaded', function () {
    modal = new bootstrap.Modal(document.getElementById('modalMahasiswa'));
    tampilData();
});

async function tampilData() {
    const response = await fetch(apiUrl, {
        headers: { 'Accept': 'application/json' }
    });

    const result = await response.json();
    const tbody = document.getElementById('tabelMahasiswa');
    tbody.innerHTML = '';

    result.data.forEach(item => {
        const row = document.createElement('tr');

        const values = [
            item.nim,
            item.nama,
            item.jk === 'L' ? 'Laki-laki' : 'Perempuan',
            item.prodi,
            item.no_telp,
            item.alamat
        ];

        values.forEach(value => {
            const cell = document.createElement('td');
            cell.textContent = value ?? '';
            row.appendChild(cell);
        });

        const aksi = document.createElement('td');
        aksi.innerHTML = `
            <button class="btn btn-warning btn-sm" onclick="editData('${encodeURIComponent(item.nim)}')">Edit</button>
            <button class="btn btn-danger btn-sm" onclick="hapusData('${encodeURIComponent(item.nim)}')">Hapus</button>
        `;
        row.appendChild(aksi);
        tbody.appendChild(row);
    });
}

function tambahData() {
    modeEdit = false;
    nimLama = '';
    document.getElementById('formMahasiswa').reset();
    document.getElementById('nim').disabled = false;
    document.getElementById('judulModal').textContent = 'Tambah Mahasiswa';
    modal.show();
}

async function editData(nim) {
    nim = decodeURIComponent(nim);

    const response = await fetch(apiUrl, {
        headers: { 'Accept': 'application/json' }
    });
    const result = await response.json();
    const item = result.data.find(data => data.nim === nim);

    if (!item) return;

    modeEdit = true;
    nimLama = nim;

    document.getElementById('nim').value = item.nim;
    document.getElementById('nim').disabled = true;
    document.getElementById('nama').value = item.nama;
    document.getElementById('jk').value = item.jk;
    document.getElementById('prodi').value = item.prodi;
    document.getElementById('no_telp').value = item.no_telp;
    document.getElementById('alamat').value = item.alamat;
    document.getElementById('judulModal').textContent = 'Edit Mahasiswa';

    modal.show();
}

async function simpanData() {
    const data = {
        nim: document.getElementById('nim').value,
        nama: document.getElementById('nama').value,
        jk: document.getElementById('jk').value,
        prodi: document.getElementById('prodi').value,
        no_telp: document.getElementById('no_telp').value,
        alamat: document.getElementById('alamat').value
    };

    const url = modeEdit ? `${apiUrl}/${encodeURIComponent(nimLama)}` : apiUrl;
    const method = modeEdit ? 'PUT' : 'POST';

    try {
        const response = await fetch(url, {
            method: method,
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify(data)
        });

        const result = await response.json();

        if (!response.ok) {
            const pesan = result.errors
                ? Object.values(result.errors).flat().join('\n')
                : result.message || 'Data gagal disimpan';

            Swal.fire('Gagal', pesan, 'error');
            return;
        }

        modal.hide();
        await tampilData();
        Swal.fire('Berhasil', result.message, 'success');
    } catch (error) {
        Swal.fire('Gagal', 'Terjadi kesalahan pada server.', 'error');
    }
}

async function hapusData(nim) {
    nim = decodeURIComponent(nim);

    const konfirmasi = await Swal.fire({
        title: 'Hapus data?',
        text: 'Data mahasiswa akan dihapus.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Ya, hapus',
        cancelButtonText: 'Batal'
    });

    if (!konfirmasi.isConfirmed) return;

    const response = await fetch(`${apiUrl}/${encodeURIComponent(nim)}`, {
        method: 'DELETE',
        headers: {
            'Accept': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        }
    });

    const result = await response.json();

    if (response.ok) {
        await tampilData();
        Swal.fire('Berhasil', result.message, 'success');
    } else {
        Swal.fire('Gagal', result.message || 'Data gagal dihapus', 'error');
    }
}
</script>
@endsection
