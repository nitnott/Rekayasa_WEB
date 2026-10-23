
<form
    action="{{ $mode === 'edit'
        ? route('mahasiswa.update', $mahasiswa->nim)
        : route('mahasiswa.store') }}"
    method="POST">

    @csrf

    @if($mode === 'edit')
        @method('PUT')
    @endif

    <p>
        <label>NIM</label><br>
        <input type="text" name="nim"
               value="{{ old('nim', $mahasiswa->nim ?? '') }}"
               required>
        @error('nim')
            <br><span style="color:red;">{{ $message }}</span>
        @enderror
    </p>

    <p>
        <label>Nama</label><br>
        <input type="text" name="nama"
               value="{{ old('nama', $mahasiswa->nama ?? '') }}"
               required>
        @error('nama')
            <br><span style="color:red;">{{ $message }}</span>
        @enderror
    </p>

    <p>
        <label>Jenis Kelamin</label><br>
        <select name="jk" required>
            <option value="">-- Pilih Jenis Kelamin --</option>
            <option value="Laki-laki"
                {{ old('jk', $mahasiswa->jk ?? '') == 'Laki-laki' ? 'selected' : '' }}>
                Laki-laki
            </option>
            <option value="Perempuan"
                {{ old('jk', $mahasiswa->jk ?? '') == 'Perempuan' ? 'selected' : '' }}>
                Perempuan
            </option>
        </select>
        @error('jk')
            <br><span style="color:red;">{{ $message }}</span>
        @enderror
    </p>

    <p>
        <label>Program Studi</label><br>
        <input type="text" name="prodi"
               value="{{ old('prodi', $mahasiswa->prodi ?? '') }}"
               required>
        @error('prodi')
            <br><span style="color:red;">{{ $message }}</span>
        @enderror
    </p>

    <p>
        <label>No. Telepon</label><br>
        <input type="text" name="no_telp"
               value="{{ old('no_telp', $mahasiswa->no_telp ?? '') }}"
               required>
        @error('no_telp')
            <br><span style="color:red;">{{ $message }}</span>
        @enderror
    </p>

    <p>
        <label>Alamat</label><br>
        <textarea name="alamat" required>{{ old('alamat', $mahasiswa->alamat ?? '') }}</textarea>
        @error('alamat')
            <br><span style="color:red;">{{ $message }}</span>
        @enderror
    </p>

    <button type="submit">
        {{ $mode === 'edit' ? 'Simpan Perubahan' : 'Tambah Data' }}
    </button>

    <a href="{{ route('mahasiswa.index') }}">Kembali</a>
</form>
