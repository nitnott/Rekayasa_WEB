@extends('layouts.main')

@section('title', 'Data Mahasiswa')

@section('content')
<div class="mahasiswa-page">

    <div class="mahasiswa-header">
        <div>
            <span class="mahasiswa-label">DATA AKADEMIK</span>
            <h2>Data Mahasiswa</h2>
            <p>Kelola informasi mahasiswa dengan mudah.</p>
        </div>

        <button type="button" class="btn-tambah" onclick="tambahMahasiswa()">
            <span>+</span> Tambah Mahasiswa
        </button>
    </div>

    <div class="mahasiswa-info">
        <div class="info-icon">M</div>
        <div>
            <strong>Daftar Mahasiswa</strong>
            <p id="totalMahasiswa">Memuat data...</p>
        </div>
    </div>

    <div class="table-wrapper">
        <table>
            <thead>
                <tr>
                    <th>No.</th>
                    <th>NIM</th>
                    <th>Nama Mahasiswa</th>
                    <th>Jenis Kelamin</th>
                    <th>Program Studi</th>
                    <th>No. Telepon</th>
                    <th>Alamat</th>
                    <th>Aksi</th>
                </tr>
            </thead>

            <tbody id="tabelMahasiswa">
                <tr>
                    <td colspan="8" class="empty-data">Memuat data mahasiswa...</td>
                </tr>
            </tbody>
        </table>
    </div>

    <div class="table-footer">
        <span id="jumlahData">Menampilkan 0 data mahasiswa</span>
        <span>PT Teknologi Nusantara</span>
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
                        <label class="form-label">Nama Mahasiswa</label>
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
                <button type="button" class="btn btn-primary" onclick="simpanMahasiswa()">Simpan</button>
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
let modalMahasiswa;

document.addEventListener('DOMContentLoaded', function () {
    modalMahasiswa = new bootstrap.Modal(document.getElementById('modalMahasiswa'));
    tampilMahasiswa();
});

async function tampilMahasiswa() {
    try {
        const response = await fetch(apiUrl, {
            headers: { 'Accept': 'application/json' }
        });

        const result = await response.json();

        if (!response.ok) {
            throw new Error(result.message || 'Gagal mengambil data');
        }

        const tbody = document.getElementById('tabelMahasiswa');
        tbody.innerHTML = '';

        document.getElementById('totalMahasiswa').textContent =
            'Total ' + result.data.length + ' mahasiswa terdaftar';

        document.getElementById('jumlahData').textContent =
            'Menampilkan ' + result.data.length + ' data mahasiswa';

        if (result.data.length === 0) {
            tbody.innerHTML = `
                <tr>
                    <td colspan="8" class="empty-data">
                        <strong>Belum ada data mahasiswa</strong>
                        <p>Tambahkan data mahasiswa untuk mulai mengelola daftar.</p>
                    </td>
                </tr>
            `;
            return;
        }

        result.data.forEach((item, index) => {
            const row = document.createElement('tr');

            const values = [
                index + 1,
                item.nim,
                item.nama,
                item.jk === 'L' ? 'Laki-laki' : 'Perempuan',
                item.prodi,
                item.no_telp,
                item.alamat
            ];

            values.forEach((value, indexKolom) => {
                const cell = document.createElement('td');
                cell.textContent = value ?? '';

                if (indexKolom === 0) cell.className = 'nomor';
                if (indexKolom === 1) {
                    const badge = document.createElement('span');
                    badge.className = 'nim-badge';
                    badge.textContent = value;
                    cell.textContent = '';
                    cell.appendChild(badge);
                }
                if (indexKolom === 2) cell.className = 'nama-mahasiswa';

                row.appendChild(cell);
            });

            const aksi = document.createElement('td');
            const pembungkus = document.createElement('div');
            pembungkus.className = 'aksi-mahasiswa';

            const tombolEdit = document.createElement('button');
            tombolEdit.type = 'button';
            tombolEdit.className = 'btn-edit';
            tombolEdit.textContent = 'Edit';
            tombolEdit.addEventListener('click', () => editMahasiswa(item));

            const tombolHapus = document.createElement('button');
            tombolHapus.type = 'button';
            tombolHapus.className = 'btn-hapus';
            tombolHapus.textContent = 'Hapus';
            tombolHapus.addEventListener('click', () => hapusMahasiswa(item.nim));

            pembungkus.append(tombolEdit, tombolHapus);
            aksi.appendChild(pembungkus);
            row.appendChild(aksi);
            tbody.appendChild(row);
        });

    } catch (error) {
        Swal.fire('Gagal', error.message, 'error');
    }
}

function tambahMahasiswa() {
    modeEdit = false;
    nimLama = '';

    document.getElementById('formMahasiswa').reset();
    document.getElementById('nim').disabled = false;
    document.getElementById('judulModal').textContent = 'Tambah Mahasiswa';

    modalMahasiswa.show();
}

function editMahasiswa(item) {
    modeEdit = true;
    nimLama = item.nim;

    document.getElementById('nim').value = item.nim;
    document.getElementById('nim').disabled = true;
    document.getElementById('nama').value = item.nama;
    document.getElementById('jk').value = item.jk;
    document.getElementById('prodi').value = item.prodi;
    document.getElementById('no_telp').value = item.no_telp;
    document.getElementById('alamat').value = item.alamat;
    document.getElementById('judulModal').textContent = 'Edit Mahasiswa';

    modalMahasiswa.show();
}

async function simpanMahasiswa() {
    const form = document.getElementById('formMahasiswa');

    if (!form.reportValidity()) return;

    const data = {
        nim: document.getElementById('nim').value,
        nama: document.getElementById('nama').value,
        jk: document.getElementById('jk').value,
        prodi: document.getElementById('prodi').value,
        no_telp: document.getElementById('no_telp').value,
        alamat: document.getElementById('alamat').value
    };

    const url = modeEdit
        ? `${apiUrl}/${encodeURIComponent(nimLama)}`
        : apiUrl;

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

        modalMahasiswa.hide();
        await tampilMahasiswa();
        Swal.fire('Berhasil', result.message, 'success');

    } catch (error) {
        Swal.fire('Gagal', 'Terjadi kesalahan pada server.', 'error');
    }
}

async function hapusMahasiswa(nim) {
    const konfirmasi = await Swal.fire({
        title: 'Hapus data?',
        text: 'Data mahasiswa akan dihapus.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Ya, hapus',
        cancelButtonText: 'Batal'
    });

    if (!konfirmasi.isConfirmed) return;

    try {
        const response = await fetch(`${apiUrl}/${encodeURIComponent(nim)}`, {
            method: 'DELETE',
            headers: {
                'Accept': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        });

        const result = await response.json();

        if (!response.ok) {
            throw new Error(result.message || 'Data gagal dihapus');
        }

        await tampilMahasiswa();
        Swal.fire('Berhasil', result.message, 'success');

    } catch (error) {
        Swal.fire('Gagal', error.message, 'error');
    }
}
</script>
@endsection
