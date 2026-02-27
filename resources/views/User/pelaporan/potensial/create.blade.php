@extends('layouts.user')

@section('content')
<div class="form-section">

<h5 class="fw-bold text-maroon mb-4">
    Formulir Pelaporan Konflik Potensial
</h5>

@if ($errors->any())
<div class="alert alert-danger">
    <ul class="mb-0">
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

<form method="POST"
      action="{{ route('pelaporan.potensial.store') }}"
      enctype="multipart/form-data">
@csrf

<div class="mb-3">
    <label>Nama Pelapor</label>
    <input class="form-control" value="{{ $pengguna->pegawai->nama }}" readonly>
</div>

<div class="mb-3">
    <label>NIP Pelapor</label>
    <input class="form-control" value="{{ $pengguna->pegawai->nip }}" readonly>
</div>

<div class="mb-3">
    <label>Divisi Pelapor</label>
    <input class="form-control" value="{{ $pengguna->pegawai->divisi }}" readonly>
</div>

<hr>

<div class="mb-3 position-relative">
    <label>Nama Terduga *</label>
    <input type="text"
       id="nama-terduga"
       name="nama_terduga"
       class="form-control"
       autocomplete="off"
       required>
    <input type="hidden"
       name="pegawai_nip_terduga"
       id="nip-terduga">
    <div id="hasil-cari"
        class="list-group position-absolute w-100"
        style="z-index: 1000">
    </div>
</div>

<div class="mb-3">
    <label>NIP Terduga</label>
    <input type="text"
           id="nip-view"
           class="form-control"
           readonly>
</div>

<div class="mb-3">
    <label>Jabatan Terduga</label>
    <input type="text"
           id="jabatan-view"
           class="form-control"
           readonly>
</div>

<div class="mb-3">
    <label>Divisi Terduga</label>
    <input type="text"
           id="divisi-view"
           class="form-control"
           readonly>
</div>

<hr>

 <div class="mb-3">
    <label>Judul Laporan *</label>
    <input type="text" name="judul_potensial" class="form-control" required>
</div>

<div class="mb-3">
    <label>Dugaan Konflik *</label>
    <textarea name="dugaan_konflik" class="form-control" required></textarea>
</div>

<div class="mb-3">
    <label>Nama Anggota Keluarga dan Kerabat dengan Potensi Konflik</label>
    <textarea name="daftar_keluarga" class="form-control"></textarea>
</div>

<div class="mb-3">
    <label>Daftar Kepemilikan Saham di Perusahaan</label>
    <textarea name="kepemilikan_saham" class="form-control"></textarea>
</div>

<div class="mb-3">
    <label>Aset Investasi Lain</label>
    <textarea name="aset_investasi" class="form-control"></textarea>
</div>

<div class="mb-3">
    <label>Pekerjaan Lain</label>
    <textarea name="pekerjaan_lain" class="form-control"></textarea>
</div>

<div class="mb-3">
    <label>Jabatan Publik Lain</label>
    <textarea name="jabatan_lain" class="form-control"></textarea>
</div>

<div class="mb-3">
    <label>Keanggotaan Organisasi Kemasyarakatan</label>
    <textarea name="keanggotaan_lain" class="form-control"></textarea>
</div>

<div class="mb-3">
    <label>Organisasi Nirlaba</label>
    <textarea name="organisasi_nirlaba" class="form-control"></textarea>
</div>

<div class="mb-3">
    <label>Rencana Kerja Pasca Pensiun</label>
    <textarea name="rencana_pensiun" class="form-control"></textarea>
</div>

<div class="mb-2">
    <label>Dokumen Pendukung</label>
    <input type="file"
       name="dokumen[]"
       class="form-control"
       accept=".pdf,.docx,.jpg,.jpeg,.png"
       multiple>
</div>

<div class="text-muted mb-4">
    Dokumen pendukung dapat berupa <strong>PDF, DOCX, JPG, atau PNG</strong><br>
</div>


<button class="btn btn-danger px-4">
    Kirim
</button>

</form>
</div>
@endsection

@push('scripts')
<script>
const input = document.getElementById('nama-terduga');
const hasil = document.getElementById('hasil-cari');

input.addEventListener('keyup', async () => {
    if (input.value.length < 2) {
        hasil.innerHTML = '';
        return;
    }

    const res = await fetch(`/pegawai/search-potensial?q=${input.value}`);
    const data = await res.json();

    hasil.innerHTML = '';
    hasil.style.zIndex = 1000;

    data.forEach(p => {
        const item = document.createElement('div');
        item.className = 'list-group-item list-group-item-action';
        item.style.cursor = 'pointer';
        item.textContent = `${p.nama} (${p.nip})`;

        item.addEventListener('click', () => {
            console.log(p);
            input.value = p.nama;
            document.getElementById('nip-terduga').value = p.nip;
            document.getElementById('nip-view').value = p.nip;
            document.getElementById('jabatan-view').value = p.jabatan;
            document.getElementById('divisi-view').value = p.divisi;
            hasil.innerHTML = '';
        });

        hasil.appendChild(item);
    });
});
</script>
@endpush