@extends('admin.layout')

@php
    $hideNavbar = true;
@endphp

@section('title', 'Detail Laporan Konflik Aktual')
@section('breadcrumb', '')

@push('styles')
<style>
    :root {
        --primary-red: #b11217;
        --secondary-red: #c72822;
        --light-red: #fee2e2;
        --text-dark: #1e293b;
        --text-medium: #475569;
        --text-light: #94a3b8;
        --bg-white: #ffffff;
        --bg-light: #f8fafc;
        --border-light: #e2e8f0;
        --shadow-sm: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
        --shadow-md: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        --shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
    }

    .detail-wrapper {
        background: var(--bg-light);
        min-height: 100vh;
        margin-left: -280px;
        margin-right: -30px;
        margin-top: -25px;
        padding-top: 30px;
        transition: margin-left 0.3s ease, margin-right 0.3s ease;
    }

    .content.full .detail-wrapper {
        margin-left: -100px;
        margin-right: -30px;
    }

    .tab-navigation {
        background: var(--bg-white);
        padding: 0;
        display: flex;
        justify-content: center;
        box-shadow: 0 4px 10px rgba(0,0,0,0.15);
        border-radius: 14px;
        overflow: hidden;
        margin: 0 30px 30px 310px;
        height: 60px;
        transition: margin-left 0.3s ease, margin-right 0.3s ease;
    }

    .content.full .tab-navigation {
        margin-left: 130px;
        margin-right: 30px;
    }

    .tab-nav-item {
        flex: 1;
        max-width: 300px;
        padding: 20px 30px;
        border: none;
        background: transparent;
        color: var(--text-medium);
        font-size: 0.95rem;
        font-weight: 500;
        cursor: pointer;
        position: relative;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        border-bottom: 3px solid transparent;
    }

    .tab-nav-item:hover {
        color: var(--primary-red);
        background: rgba(230, 47, 42, 0.05);
    }

    .tab-nav-item.active {
        color: var(--primary-red);
        font-weight: 600;
        border-bottom-color: var(--primary-red);
        background: rgba(230, 47, 42, 0.08);
    }

    .tab-nav-item i {
        font-size: 1.1rem;
    }

    .tab-content-wrapper {
        max-width: 1400px;
        margin: 0 auto;
        padding: 0 30px;
        margin-left: 310px;
        margin-right: 30px;
        transition: margin-left 0.3s ease, margin-right 0.3s ease;
    }

    .content.full .tab-content-wrapper {
        margin-left: 130px;
        margin-right: 30px;
    }

    .tab-pane {
        display: none;
        animation: fadeInUp 0.4s ease;
    }

    .tab-pane.active {
        display: block;
    }

    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .detail-card {
        background: var(--bg-white);
        border-radius: 12px;
        padding: 35px 40px;
        box-shadow: var(--shadow-md);
        border: 1px solid var(--border-light);
        margin-bottom: 24px;
        margin-top: 20px;
    }

    .detail-grid {
        display: grid;
        gap: 24px;
    }

    .detail-item {
        padding-bottom: 20px;
        border-bottom: 1px solid var(--border-light);
    }

    .detail-item:last-child {
        border-bottom: none;
        padding-bottom: 0;
    }

    .detail-item label {
        display: block;
        font-size: 0.875rem;
        font-weight: 600;
        color: var(--text-medium);
        margin-bottom: 8px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .detail-item .value {
        font-size: 1rem;
        color: var(--text-dark);
        line-height: 1.6;
        font-weight: 400;
    }

    .section-header {
        margin: 40px 0 24px 0;
        padding-bottom: 12px;
        border-bottom: 2px solid var(--primary-red);
    }

    .section-header:first-child {
        margin-top: 0;
    }

    .section-header h3 {
        font-size: 1.25rem;
        font-weight: 700;
        color: var(--text-dark);
        margin: 0;
    }

    .document-list {
        display: grid;
        gap: 16px;
    }

    .document-item {
        background: var(--bg-white);
        border: 1px solid var(--border-light);
        border-radius: 10px;
        padding: 20px 24px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        transition: all 0.3s ease;
        box-shadow: var(--shadow-sm);
    }

    .document-item:hover {
        box-shadow: var(--shadow-md);
        border-color: var(--primary-red);
        transform: translateY(-2px);
    }

    .document-info {
        flex: 1;
    }

    .document-info label {
        display: block;
        font-size: 0.8rem;
        font-weight: 600;
        color: var(--text-medium);
        margin-bottom: 6px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .document-info .filename {
        font-size: 0.95rem;
        color: var(--text-dark);
        font-weight: 500;
    }

    .btn-download {
        background: var(--primary-red);
        color: white;
        border: none;
        width: 40px;
        height: 40px;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.3s ease;
        box-shadow: var(--shadow-sm);
    }

    .btn-download:hover {
        background: var(--secondary-red);
        transform: scale(1.05);
        box-shadow: var(--shadow-md);
    }

    .btn-download i {
        font-size: 1.1rem;
    }

    .form-group {
        margin-bottom: 28px;
    }

    .form-group label {
        display: block;
        font-size: 0.875rem;
        font-weight: 600;
        color: var(--text-medium);
        margin-bottom: 10px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .form-select-modern {
        width: 100%;
        padding: 12px 16px;
        border: 1px solid var(--border-light);
        border-radius: 8px;
        font-size: 0.95rem;
        background: var(--bg-white);
        color: var(--text-dark);
        transition: all 0.3s ease;
        box-shadow: var(--shadow-sm);
    }

    .form-select-modern:focus {
        outline: none;
        border-color: var(--primary-red);
        box-shadow: 0 0 0 3px rgba(230, 47, 42, 0.1);
    }

    .form-textarea-modern {
        width: 100%;
        padding: 14px 16px;
        border: 1px solid var(--border-light);
        border-radius: 8px;
        font-size: 0.95rem;
        background: var(--bg-white);
        color: var(--text-dark);
        resize: vertical;
        font-family: inherit;
        line-height: 1.6;
        transition: all 0.3s ease;
        box-shadow: var(--shadow-sm);
    }

    .form-textarea-modern:focus {
        outline: none;
        border-color: var(--primary-red);
        box-shadow: 0 0 0 3px rgba(230, 47, 42, 0.1);
    }

    .btn-save-modern {
        background: var(--primary-red);
        color: white;
        border: none;
        padding: 12px 32px;
        border-radius: 8px;
        font-size: 0.95rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        box-shadow: var(--shadow-md);
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }

    .btn-save-modern:hover {
        background: var(--secondary-red);
        transform: translateY(-2px);
        box-shadow: var(--shadow-lg);
    }

    .btn-save-modern i {
        font-size: 1rem;
    }

    .btn-back-modern {
        background: var(--bg-white);
        color: var(--text-dark);
        border: 1px solid var(--border-light);
        padding: 10px 24px;
        border-radius: 8px;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        font-size: 0.9rem;
        font-weight: 500;
        transition: all 0.3s ease;
        margin-bottom: 20px;
        margin-top: 20px;
        box-shadow: var(--shadow-sm);
    }

    .btn-back-modern:hover {
        background: var(--bg-light);
        border-color: var(--primary-red);
        color: var(--primary-red);
        transform: translateX(-4px);
        box-shadow: var(--shadow-md);
    }

    .document-list {
        display: grid;
        gap: 16px;
        margin-top: 20px;
    }

    .empty-state {
        text-align: center;
        padding: 80px 40px;
        background: var(--bg-white);
        border-radius: 12px;
        border: 1px solid var(--border-light);
        box-shadow: var(--shadow-sm);
    }

    .empty-state i {
        font-size: 4rem;
        color: var(--text-light);
        margin-bottom: 20px;
    }

    .empty-state h5 {
        color: var(--text-dark);
        font-weight: 600;
        margin-bottom: 8px;
    }

    .empty-state p {
        color: var(--text-medium);
        font-size: 0.95rem;
    }

    .alert {
        border-radius: 10px;
        border: none;
        padding: 16px 20px;
        margin-bottom: 24px;
        box-shadow: var(--shadow-sm);
    }

    .tab-content-wrapper::-webkit-scrollbar {
        width: 8px;
    }

    .tab-content-wrapper::-webkit-scrollbar-track {
        background: var(--bg-light);
    }

    .tab-content-wrapper::-webkit-scrollbar-thumb {
        background: var(--text-light);
        border-radius: 4px;
    }

    .tab-content-wrapper::-webkit-scrollbar-thumb:hover {
        background: var(--text-medium);
    }

    @media (max-width: 768px) {
        .detail-wrapper {
            margin-left: 0;
            margin-right: 0;
            padding-top: 20px;
        }

        .tab-navigation {
            margin: 0 20px 20px 20px;
        }

        .content.full .tab-navigation {
            margin-left: 20px;
        }

        .tab-content-wrapper {
            padding: 0 20px;
            margin-left: 20px;
        }

        .content.full .tab-content-wrapper {
            margin-left: 20px;
        }

        .detail-card {
            padding: 24px 20px;
        }

        .tab-nav-item {
            padding: 16px 20px;
            font-size: 0.875rem;
        }
    }
</style>
@endpush

@section('content')

<div class="detail-wrapper">
    <div class="tab-navigation">
        <button class="tab-nav-item active" onclick="switchTab('detail')">
            Detail Laporan
        </button>
        <button class="tab-nav-item" onclick="switchTab('dokumen')">
            Dokumen
        </button>
        <button class="tab-nav-item" onclick="switchTab('verifikasi')">
            Verifikasi
        </button>
    </div>

    <div class="tab-content-wrapper">
        <a href="{{ route('konflik-aktual.index') }}" class="btn-back-modern">
            <i class="bi bi-arrow-left"></i>
            Kembali ke Daftar
        </a>

        @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        @endif

        @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="bi bi-exclamation-triangle me-2"></i>{{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        @endif

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

        <div id="dokumen-tab" class="tab-pane">
            @if($dokumen->count() > 0)
                <div class="document-list">
                    @foreach($dokumen as $doc)
                    <div class="document-item">
                        <div class="document-info">
                            <label>Nama File</label>
                            <div class="filename">{{ $doc->nama_file_aktual }}</div>
                        </div>
                        <button class="btn-download" title="Download">
                            <i class="bi bi-download"></i>
                        </button>
                    </div>
                    @endforeach
                </div>
            @else
                <div class="empty-state">
                    <i class="bi bi-inbox"></i>
                    <h5>Tidak Ada Dokumen</h5>
                    <p>Belum ada dokumen pendukung yang diunggah untuk laporan ini.</p>
                </div>
            @endif
        </div>

        <div id="verifikasi-tab" class="tab-pane">
            <div class="detail-card">
                <form action="{{ route('konflik-aktual.verifikasi.update', $laporan->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="form-group">
                        <label>Setujui / Tolak</label>
                        <select class="form-select-modern" name="status" required>
                            <option value="">-- Pilih Status --</option>
                            <option value="Disetujui" {{ $laporan->status_verifikasi == 'Disetujui' ? 'selected' : '' }}>Setujui</option>
                            <option value="Ditolak" {{ $laporan->status_verifikasi == 'Ditolak' ? 'selected' : '' }}>Tolak</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Komentar</label>
                        <textarea class="form-textarea-modern" name="komentar" rows="8" required placeholder="Masukkan komentar atau rekomendasi verifikasi...">{{ $laporan->komentar_verifikasi }}</textarea>
                    </div>

                    <div class="text-end">
                        <button type="submit" class="btn-save-modern">
                            <i class="bi bi-save"></i>
                            Kirim
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
function switchTab(tabName) {
    document.querySelectorAll('.tab-pane').forEach(pane => {
        pane.classList.remove('active');
    });
    
    document.querySelectorAll('.tab-nav-item').forEach(btn => {
        btn.classList.remove('active');
    });
    
    document.getElementById(tabName + '-tab').classList.add('active');
    
    event.target.closest('.tab-nav-item').classList.add('active');
    
    window.scrollTo({ top: 0, behavior: 'smooth' });
}
</script>
@endpush
