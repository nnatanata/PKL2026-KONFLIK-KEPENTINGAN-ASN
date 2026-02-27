<div id="verifikasi-tab" class="tab-pane">
    <div class="detail-card">
        @php
            $isLockedByInspektorat = in_array($laporan->status_inspektorat, ['Disetujui Inspektorat', 'Ditolak Inspektorat']);
        @endphp

        @if($isLockedByInspektorat)
        <div class="alert alert-warning" style="background: #fff3cd; border-left: 4px solid #ffc107; padding: 16px; border-radius: 8px; margin-bottom: 24px;">
            <div style="display: flex; align-items: center; gap: 12px;">
                <i class="bi bi-lock-fill" style="font-size: 1.5rem; color: #856404;"></i>
                <div>
                    <strong style="color: #856404;">Laporan Terkunci</strong>
                    <p style="margin: 4px 0 0 0; color: #856404; font-size: 0.9rem;">
                        Laporan ini sudah diverifikasi oleh Inspektorat dengan status: <strong>{{ $laporan->status_inspektorat }}</strong>. 
                        Anda tidak dapat mengubah status verifikasi atau komentar.
                    </p>
                </div>
            </div>
        </div>
        @endif

        <div class="verification-section">
            <div class="section-header">
                <h3>Status Verifikasi</h3>
            </div>
            
            <div class="verification-buttons">
                <button type="button" 
                        class="btn-verify btn-approve" 
                        onclick="handleVerification('Disetujui')" 
                        {{ ($laporan->status_verifikasi == 'Disetujui' || $isLockedByInspektorat) ? 'disabled' : '' }}>
                    <span>Setujui Laporan</span>
                </button>
                <button type="button" 
                        class="btn-verify btn-reject" 
                        onclick="handleVerification('Ditolak')" 
                        {{ ($laporan->status_verifikasi == 'Ditolak' || $isLockedByInspektorat) ? 'disabled' : '' }}>
                    <span>Tolak Laporan</span>
                </button>
            </div>

            @if($laporan->status_verifikasi)
            <div class="current-status {{ $laporan->status_verifikasi == 'Ditolak' ? 'rejected' : ($laporan->status_verifikasi == 'Diproses' ? 'processing' : '') }}">
                <i class="bi {{ $laporan->status_verifikasi == 'Ditolak' ? 'bi-x-circle-fill' : ($laporan->status_verifikasi == 'Diproses' ? 'bi-clock-fill' : 'bi-check-circle-fill') }}"></i>
                <span>Status saat ini: <strong>{{ $laporan->status_verifikasi }}</strong></span>
            </div>
            @endif

            @if($laporan->status_inspektorat)
            <div class="current-status {{ str_contains($laporan->status_inspektorat, 'Ditolak') ? 'rejected' : '' }}" style="margin-top: 12px;">
                <i class="bi {{ str_contains($laporan->status_inspektorat, 'Ditolak') ? 'bi-x-circle-fill' : 'bi-check-circle-fill' }}"></i>
                <span>Status Inspektorat: <strong>{{ $laporan->status_inspektorat }}</strong></span>
            </div>
            @endif
        </div>

        <form id="komentarForm" action="{{ route('konflik-potensial.komentar.update', $laporan->id) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="section-header">
                <h3>Komentar Verifikasi</h3>
            </div>

            <div class="form-group">
                <label>Komentar</label>
                <textarea class="form-textarea-modern" 
                          name="komentar" 
                          id="komentarText" 
                          rows="8" 
                          placeholder="Masukkan komentar..."
                          {{ $isLockedByInspektorat ? 'readonly' : '' }}>{{ $laporan->komentar_verifikasi }}</textarea>
            </div>

            <div class="text-end">
                <button type="button" 
                        class="btn-save-modern" 
                        onclick="handleKomentarSubmit()"
                        {{ $isLockedByInspektorat ? 'disabled' : '' }}>
                    <i class="bi bi-send"></i>
                    Kirim Komentar
                </button>
            </div>
        </form>

        <form id="statusForm" action="{{ route('konflik-potensial.verifikasi.update', $laporan->id) }}" method="POST" style="display: none;">
            @csrf
            @method('PUT')
            <input type="hidden" name="status" id="statusInput">
        </form>
    </div>
</div>

<style>
    .current-status {
        background: #d4edda;
        color: #155724;
        padding: 12px 16px;
        border-radius: 8px;
        display: flex;
        align-items: center;
        gap: 10px;
        margin-top: 16px;
        border-left: 4px solid #28a745;
    }

    .current-status i {
        font-size: 1.2rem;
    }

    .current-status.rejected {
        background: #f8d7da;
        color: #721c24;
        border-left-color: #dc3545;
    }

    .current-status.processing {
        background: #fff3cd;
        color: #856404;
        border-left-color: #ffc107;
    }
</style>