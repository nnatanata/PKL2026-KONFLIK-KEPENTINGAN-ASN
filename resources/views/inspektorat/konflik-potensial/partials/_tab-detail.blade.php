<div id="detail-tab" class="tab-pane active">
    <div class="detail-card">
        <div class="detail-grid">
            <div class="detail-item">
                <label>Tanggal Masuk</label>
                <div class="value">{{ \Carbon\Carbon::parse($laporan->tanggal_potensial)->format('d F Y') }}</div>
            </div>
            
            <div class="detail-item">
                <label>Waktu Masuk</label>
                <div class="value">{{ \Carbon\Carbon::parse($laporan->created_at)->format('H:i:s') }} WIB</div>
            </div>
        </div>

        <div class="section-header">
            <h3>Informasi Pelapor</h3>
        </div>
        
        <div class="detail-grid">
            <div class="detail-item">
                <label>Nama Pelapor</label>
                <div class="value">{{ $laporan->nama_pelapor }}</div>
            </div>

            <div class="detail-item">
                <label>NIP Pelapor</label>
                <div class="value">{{ $laporan->nip_pelapor }}</div>
            </div>

            <div class="detail-item">
                <label>Jabatan Pelapor</label>
                <div class="value">{{ $laporan->jabatan_pelapor ?? '-' }}</div>
            </div>

            <div class="detail-item">
                <label>Divisi Pelapor</label>
                <div class="value">{{ $laporan->divisi_pelapor }}</div>
            </div>
        </div>

        <div class="section-header">
            <h3>Informasi Terduga</h3>
        </div>

        <div class="detail-grid">
            <div class="detail-item">
                <label>Nama Terduga</label>
                <div class="value">{{ $laporan->nama_terduga_lengkap ?? $laporan->nama_terduga }}</div>
            </div>

            <div class="detail-item">
                <label>NIP Terduga</label>
                <div class="value">{{ $laporan->nip_terduga ?? '-' }}</div>
            </div>

            <div class="detail-item">
                <label>Jabatan Terduga</label>
                <div class="value">{{ $laporan->jabatan_terduga ?? '-' }}</div>
            </div>

            <div class="detail-item">
                <label>Divisi Terduga</label>
                <div class="value">{{ $laporan->divisi_terduga ?? '-' }}</div>
            </div>
        </div>

        <div class="section-header">
            <h3>Detail Konflik Potensial</h3>
        </div>

        <div class="detail-grid">
            <div class="detail-item">
                <label>Dugaan Konflik</label>
                <div class="value">{{ $laporan->dugaan_konflik ?? '-' }}</div>
            </div>

            <div class="detail-item">
                <label>Daftar Keluarga</label>
                <div class="value">{{ $laporan->daftar_keluarga ?? '-' }}</div>
            </div>

            <div class="detail-item">
                <label>Kepemilikan Saham</label>
                <div class="value">{{ $laporan->kepemilikan_saham ?? '-' }}</div>
            </div>

            <div class="detail-item">
                <label>Aset & Investasi</label>
                <div class="value">{{ $laporan->aset_investasi ?? '-' }}</div>
            </div>

            <div class="detail-item">
                <label>Pekerjaan Lain</label>
                <div class="value">{{ $laporan->pekerjaan_lain ?? '-' }}</div>
            </div>

            <div class="detail-item">
                <label>Jabatan Lain</label>
                <div class="value">{{ $laporan->jabatan_lain ?? '-' }}</div>
            </div>

            <div class="detail-item">
                <label>Keanggotaan Lain</label>
                <div class="value">{{ $laporan->keanggotaan_lain ?? '-' }}</div>
            </div>

            <div class="detail-item">
                <label>Organisasi Nirlaba</label>
                <div class="value">{{ $laporan->organisasi_nirlaba ?? '-' }}</div>
            </div>

            <div class="detail-item">
                <label>Rencana Pensiun</label>
                <div class="value">{{ $laporan->rencana_pensiun ?? '-' }}</div>
            </div>
        </div>
    </div>
</div>