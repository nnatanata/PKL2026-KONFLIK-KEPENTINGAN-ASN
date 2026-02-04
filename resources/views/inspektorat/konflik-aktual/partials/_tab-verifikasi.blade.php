<div id="verifikasi-tab" class="tab-pane">
    <div class="detail-card">
        <!--status verifikasi inspektorat-->
        <div class="verification-section">
            <div class="section-header">
                <h3>Verifikasi Inspektorat</h3>
            </div>
            
            <div class="verification-buttons">
                <button type="button" 
                        class="btn-verify btn-approve" 
                        onclick="handleVerification('Disetujui')"
                        {{ $laporan->status_aktual == 'Disetujui Inspektorat' ? 'disabled' : '' }}>
                    <i class="bi bi-check-circle-fill"></i>
                    <span>Setujui Laporan</span>
                </button>
                
                <button type="button" 
                        class="btn-verify btn-reject" 
                        onclick="handleVerification('Ditolak')"
                        {{ $laporan->status_aktual == 'Ditolak Inspektorat' ? 'disabled' : '' }}>
                    <i class="bi bi-x-circle-fill"></i>
                    <span>Tolak Laporan</span>
                </button>
            </div>

            @if($laporan->status_aktual == 'Disetujui Inspektorat' || $laporan->status_aktual == 'Ditolak Inspektorat')
            <div class="current-status {{ $laporan->status_aktual == 'Ditolak Inspektorat' ? 'rejected' : '' }}">
                <i class="bi {{ $laporan->status_aktual == 'Ditolak Inspektorat' ? 'bi-x-circle-fill' : 'bi-check-circle-fill' }}"></i>
                <span>Status Inspektorat: <strong>{{ $laporan->status_aktual }}</strong></span>
            </div>
            @endif
        </div>

        <!--komentar-->
        <form id="komentarForm" action="{{ route('inspektorat.konflik-aktual.komentar.update', $laporan->id) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="section-header">
                <h3>Komentar Verifikasi</h3>
            </div>

            <div class="form-group">
                <label>Komentar</label>
                <textarea class="form-textarea-modern" name="komentar" id="komentarText" rows="8" placeholder="Masukkan komentar...">{{ $laporan->komentar_inspektorat ?? '' }}</textarea>
            </div>

            <div class="text-end">
                <button type="button" class="btn-save-modern" onclick="handleKomentarSubmit()">
                    <i class="bi bi-send"></i>
                    Kirim Komentar
                </button>
            </div>
        </form>

        <form id="rekomendasiForm" action="{{ route('inspektorat.konflik-aktual.rekomendasi.update', $laporan->id) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="section-header">
                <h3>Rekomendasi</h3>
            </div>

            <div class="form-group">
                <label>Rekomendasi</label>
                <textarea class="form-textarea-modern" name="rekomendasi" id="rekomendasiText" rows="8" placeholder="Masukkan rekomendasi tindak lanjut...">{{ $laporan->rekomendasi_inspektorat ?? '' }}</textarea>
            </div>

            <div class="text-end">
                <button type="button" class="btn-save-modern" onclick="handleRekomendasiSubmit()">
                    <i class="bi bi-send"></i>
                    Kirim Rekomendasi
                </button>
            </div>
        </form>

        <form id="statusForm" action="{{ route('inspektorat.konflik-aktual.verifikasi.update', $laporan->id) }}" method="POST" style="display: none;">
            @csrf
            @method('PUT')
            <input type="hidden" name="status" id="statusInput">
        </form>
    </div>
</div>