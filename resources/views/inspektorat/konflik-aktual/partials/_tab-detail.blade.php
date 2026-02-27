<div id="detail-tab" class="tab-pane active">
    <div class="detail-card">
        <div class="detail-grid">
            <div class="detail-item">
                <label>Tanggal Masuk</label>
                <div class="value">{{ \Carbon\Carbon::parse($laporan->tanggal_aktual)->format('d F Y') }}</div>
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
            <h3>Informasi Pelaku</h3>
        </div>

        <div class="detail-grid">
            <div class="detail-item">
                <label>Nama Pelaku</label>
                <div class="value">{{ $laporan->nama_pelaku }}</div>
            </div>

            <div class="detail-item">
                <label>NIP Pelaku</label>
                <div class="value">{{ $laporan->nip_pelaku ?? '-' }}</div>
            </div>

            <div class="detail-item">
                <label>Divisi Pelaku</label>
                <div class="value">{{ $laporan->divisi_pelaku }}</div>
            </div>

            <div class="detail-item">
                <label>Jabatan Pelaku</label>
                <div class="value">{{ $laporan->jabatan_pelaku ?? '-' }}</div>
            </div>
        </div>

        <div class="section-header">
            <h3>Detail Konflik</h3>
        </div>

        <div class="detail-grid">
            <div class="detail-item">
                <label>Sumber Konflik</label>
                <div class="value">{{ $laporan->sumber_konflik }}</div>
            </div>

            <div class="detail-item">
                <label>Kaitan Konflik</label>
                <div class="value">{{ $laporan->kaitan_konflik }}</div>
            </div>

            <div class="detail-item">
                <label>Saran Pengendalian</label>
                <div class="value">{{ $laporan->saran_pengendalian ?? '-' }}</div>
            </div>
        </div>
    </div>
</div>