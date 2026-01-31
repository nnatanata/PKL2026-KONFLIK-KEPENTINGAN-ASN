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
        --success-green: #10b981;
        --success-light: #d1fae5;
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

    .doc-count-badge {
        background: var(--primary-red);
        color: white;
        font-size: 0.75rem;
        font-weight: 700;
        padding: 2px 8px;
        border-radius: 10px;
        margin-left: 6px;
        min-width: 22px;
        text-align: center;
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

    /*verification buttons styles*/
    .verification-section {
        margin-bottom: 40px;
    }

    .verification-buttons {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
        margin-top: 24px;
    }

    .btn-verify {
        padding: 18px 32px;
        border-radius: 12px;
        border: 2px solid;
        font-size: 1rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 12px;
        box-shadow: var(--shadow-sm);
    }

    .btn-verify i {
        font-size: 1.4rem;
    }

    .btn-approve {
        background: var(--success-green);
        border-color: var(--success-green);
        color: white;
    }

    .btn-approve:hover:not(:disabled) {
        background: #059669;
        border-color: #059669;
        transform: translateY(-2px);
        box-shadow: var(--shadow-lg);
    }

    .btn-reject {
        background: var(--primary-red);
        border-color: var(--primary-red);
        color: white;
    }

    .btn-reject:hover:not(:disabled) {
        background: var(--secondary-red);
        border-color: var(--secondary-red);
        transform: translateY(-2px);
        box-shadow: var(--shadow-lg);
    }

    .btn-verify:disabled {
        opacity: 0.5;
        cursor: not-allowed;
    }

    .current-status {
        margin-top: 20px;
        padding: 16px 20px;
        background: var(--success-light);
        border-radius: 10px;
        display: flex;
        align-items: center;
        gap: 12px;
        color: var(--success-green);
        font-weight: 500;
    }

    .current-status.rejected {
        background: var(--light-red);
        color: var(--primary-red);
    }

    .current-status i {
        font-size: 1.3rem;
    }

    /*modal styles*/
    .modal-overlay {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0, 0, 0, 0.6);
        display: none;
        align-items: center;
        justify-content: center;
        z-index: 9999;
        animation: fadeIn 0.2s ease;
    }

    .modal-overlay.active {
        display: flex;
    }

    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }

    .modal-content {
        background: var(--bg-white);
        border-radius: 16px;
        padding: 0;
        max-width: 480px;
        width: 90%;
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.2);
        animation: slideUp 0.3s ease;
        overflow: hidden;
    }

    @keyframes slideUp {
        from {
            opacity: 0;
            transform: translateY(30px) scale(0.95);
        }
        to {
            opacity: 1;
            transform: translateY(0) scale(1);
        }
    }

    .modal-header {
        padding: 28px 32px;
        border-bottom: 1px solid var(--border-light);
        display: flex;
        align-items: center;
        gap: 16px;
    }

    .modal-icon {
        width: 56px;
        height: 56px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.8rem;
    }

    .modal-icon.approve {
        background: var(--success-light);
        color: var(--success-green);
    }

    .modal-icon.reject {
        background: var(--light-red);
        color: var(--primary-red);
    }

    .modal-icon.comment {
        background: #dbeafe;
        color: #3b82f6;
    }

    .modal-title {
        flex: 1;
    }

    .modal-title h4 {
        margin: 0 0 4px 0;
        font-size: 1.25rem;
        font-weight: 700;
        color: var(--text-dark);
    }

    .modal-title p {
        margin: 0;
        font-size: 0.9rem;
        color: var(--text-medium);
    }

    .modal-body {
        padding: 32px;
    }

    .modal-message {
        font-size: 1rem;
        color: var(--text-dark);
        line-height: 1.6;
        margin: 0;
    }

    .modal-footer {
        padding: 20px 32px 32px 32px;
        display: flex;
        gap: 12px;
        justify-content: flex-end;
    }

    .modal-btn {
        padding: 12px 28px;
        border-radius: 8px;
        border: none;
        font-size: 0.95rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .modal-btn-cancel {
        background: var(--bg-light);
        color: var(--text-dark);
        border: 1px solid var(--border-light);
    }

    .modal-btn-cancel:hover {
        background: #e2e8f0;
    }

    .modal-btn-confirm {
        background: var(--primary-red);
        color: white;
    }

    .modal-btn-confirm:hover {
        background: var(--secondary-red);
    }

    .modal-btn-confirm.approve {
        background: var(--success-green);
    }

    .modal-btn-confirm.approve:hover {
        background: #059669;
    }

    /*success alert styles*/
    .success-alert {
        position: fixed;
        top: 30px;
        right: 30px;
        background: var(--bg-white);
        border-left: 4px solid var(--success-green);
        border-radius: 10px;
        padding: 20px 24px;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
        display: none;
        align-items: center;
        gap: 16px;
        z-index: 10000;
        min-width: 320px;
        animation: slideInRight 0.3s ease;
    }

    .success-alert.show {
        display: flex;
    }

    .success-alert.reject {
        border-left-color: var(--primary-red);
    }

    @keyframes slideInRight {
        from {
            opacity: 0;
            transform: translateX(100px);
        }
        to {
            opacity: 1;
            transform: translateX(0);
        }
    }

    .success-alert-icon {
        width: 44px;
        height: 44px;
        background: var(--success-light);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--success-green);
        font-size: 1.4rem;
        flex-shrink: 0;
    }

    .success-alert-icon.reject {
        background: var(--light-red);
        color: var(--primary-red);
    }

    .success-alert-content {
        flex: 1;
    }

    .success-alert-content h5 {
        margin: 0 0 4px 0;
        font-size: 1rem;
        font-weight: 700;
        color: var(--text-dark);
    }

    .success-alert-content p {
        margin: 0;
        font-size: 0.875rem;
        color: var(--text-medium);
    }

    /*document list styles*/
    .document-list {
        display: grid;
        gap: 16px;
        margin-top: 20px;
    }

    .document-item {
        background: var(--bg-white);
        border: 1px solid var(--border-light);
        border-radius: 12px;
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

    .document-info-wrapper {
        display: flex;
        align-items: center;
        gap: 16px;
        flex: 1;
    }

    .document-icon {
        width: 50px;
        height: 50px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: var(--bg-light);
        border-radius: 10px;
        flex-shrink: 0;
    }

    .document-icon i {
        font-size: 1.8rem;
    }

    .document-info {
        flex: 1;
    }

    .document-info .filename {
        font-size: 0.95rem;
        color: var(--text-dark);
        font-weight: 600;
        margin-bottom: 6px;
        display: block;
    }

    .file-meta {
        display: flex;
        align-items: center;
        gap: 12px;
        font-size: 0.85rem;
    }

    .file-type-badge {
        padding: 3px 10px;
        border-radius: 4px;
        font-weight: 600;
        font-size: 0.75rem;
        text-transform: uppercase;
    }

    .file-type-badge.pdf {
        background: #ffe5e5;
        color: #dc3545;
    }

    .file-type-badge.jpg,
    .file-type-badge.jpeg,
    .file-type-badge.png {
        background: #e7f3ff;
        color: #0d6efd;
    }

    .file-type-badge.docx {
        background: #e5f2ff;
        color: #0066cc;
    }

    .file-date {
        color: var(--text-medium);
        display: flex;
        align-items: center;
        gap: 4px;
    }

    .file-date i {
        font-size: 0.9rem;
    }

    .document-actions {
        display: flex;
        gap: 10px;
    }

    .btn-doc-action {
        padding: 10px 18px;
        border-radius: 8px;
        border: none;
        font-size: 0.9rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        gap: 8px;
        text-decoration: none;
        box-shadow: var(--shadow-sm);
    }

    .btn-doc-action i {
        font-size: 1rem;
    }

    .btn-view {
        background: #0d6efd;
        color: white;
    }

    .btn-view:hover {
        background: #0b5ed7;
        transform: translateY(-2px);
        box-shadow: var(--shadow-md);
        color: white;
    }

    .btn-download {
        background: var(--primary-red);
        color: white;
    }

    .btn-download:hover {
        background: var(--secondary-red);
        transform: translateY(-2px);
        box-shadow: var(--shadow-md);
        color: white;
    }

    /*document viewer modal*/
    .doc-modal-overlay {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0, 0, 0, 0.75);
        display: none;
        align-items: center;
        justify-content: center;
        z-index: 10000;
        animation: fadeIn 0.3s ease;
        padding: 20px;
    }

    .doc-modal-overlay.active {
        display: flex;
    }

    .doc-modal-content {
        background: var(--bg-white);
        border-radius: 16px;
        max-width: 1100px;
        width: 100%;
        max-height: 90vh;
        display: flex;
        flex-direction: column;
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
        animation: slideUp 0.3s ease;
    }

    .doc-modal-header {
        padding: 20px 28px;
        border-bottom: 1px solid var(--border-light);
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-shrink: 0;
    }

    .doc-modal-title {
        display: flex;
        align-items: center;
        gap: 12px;
        font-size: 1.1rem;
        font-weight: 700;
        color: var(--text-dark);
    }

    .doc-modal-title i {
        color: var(--primary-red);
        font-size: 1.3rem;
    }

    .btn-close-modal {
        width: 36px;
        height: 36px;
        border-radius: 8px;
        border: none;
        background: var(--bg-light);
        color: var(--text-dark);
        cursor: pointer;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .btn-close-modal:hover {
        background: var(--primary-red);
        color: white;
    }

    .btn-close-modal i {
        font-size: 1.1rem;
    }

    .doc-modal-body {
        padding: 28px;
        flex: 1;
        overflow: auto;
        background: var(--bg-light);
    }

    .document-viewer-content {
        background: white;
        border-radius: 12px;
        min-height: 500px;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: var(--shadow-sm);
    }

    .document-viewer-content iframe {
        width: 100%;
        height: 600px;
        border: none;
        border-radius: 12px;
    }

    .document-viewer-content img {
        max-width: 100%;
        height: auto;
        border-radius: 12px;
        box-shadow: var(--shadow-md);
    }

    .loading-spinner {
        text-align: center;
        color: var(--text-medium);
    }

    .loading-spinner i {
        font-size: 3rem;
        margin-bottom: 16px;
        animation: spin 2s linear infinite;
    }

    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }

    .loading-spinner p {
        font-size: 1rem;
        margin: 0;
    }

    .doc-modal-footer {
        padding: 20px 28px;
        border-top: 1px solid var(--border-light);
        display: flex;
        gap: 12px;
        justify-content: flex-end;
        flex-shrink: 0;
    }

    .btn-modal-action {
        padding: 12px 24px;
        border-radius: 8px;
        border: none;
        font-size: 0.95rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        gap: 8px;
        text-decoration: none;
    }

    .btn-modal-close {
        background: var(--bg-light);
        color: var(--text-dark);
        border: 1px solid var(--border-light);
    }

    .btn-modal-close:hover {
        background: #e2e8f0;
    }

    .btn-modal-download {
        background: var(--primary-red);
        color: white;
    }

    .btn-modal-download:hover {
        background: var(--secondary-red);
        color: white;
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

    @media (max-width: 768px) {
        .verification-buttons {
            grid-template-columns: 1fr;
        }

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

        .success-alert {
            right: 20px;
            left: 20px;
            min-width: auto;
        }

        .document-item {
            flex-direction: column;
            gap: 16px;
        }

        .document-info-wrapper {
            width: 100%;
        }

        .document-actions {
            width: 100%;
            justify-content: stretch;
        }

        .btn-doc-action {
            flex: 1;
            justify-content: center;
        }

        .doc-modal-content {
            max-width: 100%;
            max-height: 100vh;
            border-radius: 0;
        }

        .document-viewer-content iframe {
            height: 400px;
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
            @if($dokumen->count() > 0)
            <span class="doc-count-badge">{{ $dokumen->count() }}</span>
            @endif
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

        <!--success alert-->
        <div id="successAlert" class="success-alert">
            <div class="success-alert-icon">
                <i class="bi bi-check-circle-fill"></i>
            </div>
            <div class="success-alert-content">
                <h5>Berhasil!</h5>
                <p id="successMessage"></p>
            </div>
        </div>

        {{--tab detail laporan--}}
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

        {{--tab dokumen--}}
        <div id="dokumen-tab" class="tab-pane">
            @if($dokumen->count() > 0)
                <div class="document-list">
                    @foreach($dokumen as $doc)
                    <div class="document-item">
                        <div class="document-info-wrapper">
                            <div class="document-icon">
                                @php
                                    $extension = strtolower($doc->tipe_doc);
                                    $iconClass = 'bi-file-earmark';
                                    $iconColor = '#6c757d';
                                    
                                    switch($extension) {
                                        case 'pdf':
                                            $iconClass = 'bi-file-earmark-pdf';
                                            $iconColor = '#dc3545';
                                            break;
                                        case 'jpg':
                                        case 'jpeg':
                                        case 'png':
                                            $iconClass = 'bi-file-earmark-image';
                                            $iconColor = '#0d6efd';
                                            break;
                                        case 'docx':
                                            $iconClass = 'bi-file-earmark-word';
                                            $iconColor = '#0066cc';
                                            break;
                                    }
                                @endphp
                                <i class="bi {{ $iconClass }}" style="color: {{ $iconColor }}"></i>
                            </div>
                            <div class="document-info">
                                <div class="filename">{{ $doc->nama_file_aktual }}</div>
                                <div class="file-meta">
                                    <span class="file-type-badge {{ $extension }}">{{ strtoupper($doc->tipe_doc) }}</span>
                                    <span class="file-date">
                                        <i class="bi bi-clock"></i>
                                        @php

                                            if (is_string($doc->created_at)) {
                                                echo \Carbon\Carbon::parse($doc->created_at)->format('d M Y, H:i');
                                            } else {
                                                echo $doc->created_at->format('d M Y, H:i');
                                            }
                                        @endphp
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="document-actions">
                            <button class="btn-doc-action btn-view" 
                                    onclick="viewDocument({{ $doc->id }}, '{{ $doc->nama_file_aktual }}', '{{ $doc->tipe_doc }}')"
                                    title="Lihat Dokumen">
                                <i class="bi bi-eye"></i>
                                <span>Lihat</span>
                            </button>
                            <a href="{{ route('dokumen-aktual.download', $doc->id) }}" 
                               class="btn-doc-action btn-download" 
                               title="Download Dokumen">
                                <i class="bi bi-download"></i>
                                <span>Download</span>
                            </a>
                        </div>
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

        {{--tab verifikasi--}}
        <div id="verifikasi-tab" class="tab-pane">
            <div class="detail-card">
                <!--status verifikasi-->
                <div class="verification-section">
                    <div class="section-header">
                        <h3>Status Verifikasi</h3>
                    </div>
                    
                    <div class="verification-buttons">
                        <button type="button" class="btn-verify btn-approve" onclick="handleVerification('Disetujui')" {{ $laporan->status_verifikasi == 'Disetujui' ? 'disabled' : '' }}>
                            <i class="bi bi-check-circle"></i>
                            <span>Setujui Laporan</span>
                        </button>
                        <button type="button" class="btn-verify btn-reject" onclick="handleVerification('Ditolak')" {{ $laporan->status_verifikasi == 'Ditolak' ? 'disabled' : '' }}>
                            <i class="bi bi-x-circle"></i>
                            <span>Tolak Laporan</span>
                        </button>
                    </div>

                    @if($laporan->status_verifikasi)
                    <div class="current-status {{ $laporan->status_verifikasi == 'Ditolak' ? 'rejected' : '' }}">
                        <i class="bi {{ $laporan->status_verifikasi == 'Ditolak' ? 'bi-x-circle-fill' : 'bi-check-circle-fill' }}"></i>
                        <span>Status saat ini: <strong>{{ $laporan->status_verifikasi }}</strong></span>
                    </div>
                    @endif
                </div>

                <!--komentar-->
                <form id="komentarForm" action="{{ route('konflik-aktual.komentar.update', $laporan->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="section-header">
                        <h3>Komentar Verifikasi</h3>
                    </div>

                    <div class="form-group">
                        <label>Komentar</label>
                        <textarea class="form-textarea-modern" name="komentar" id="komentarText" rows="8" placeholder="Masukkan komentar atau rekomendasi verifikasi...">{{ $laporan->komentar_verifikasi }}</textarea>
                    </div>

                    <div class="text-end">
                        <button type="button" class="btn-save-modern" onclick="handleKomentarSubmit()">
                            <i class="bi bi-send"></i>
                            Kirim Komentar
                        </button>
                    </div>
                </form>

                <form id="statusForm" action="{{ route('konflik-aktual.verifikasi.update', $laporan->id) }}" method="POST" style="display: none;">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="status" id="statusInput">
                </form>
            </div>
        </div>
    </div>
</div>

<div id="confirmModal" class="modal-overlay">
    <div class="modal-content">
        <div class="modal-header">
            <div class="modal-icon" id="modalIcon">
                <i class="bi" id="modalIconSymbol"></i>
            </div>
            <div class="modal-title">
                <h4 id="modalTitle"></h4>
                <p id="modalSubtitle"></p>
            </div>
        </div>
        <div class="modal-body">
            <p class="modal-message" id="modalMessage"></p>
        </div>
        <div class="modal-footer">
            <button type="button" class="modal-btn modal-btn-cancel" onclick="closeModal()">
                Batal
            </button>
            <button type="button" class="modal-btn modal-btn-confirm" id="modalConfirmBtn">
                Ya, Lanjutkan
            </button>
        </div>
    </div>
</div>

<div id="documentViewerModal" class="doc-modal-overlay">
    <div class="doc-modal-content">
        <div class="doc-modal-header">
            <div class="doc-modal-title">
                <i class="bi bi-file-earmark-text"></i>
                <span id="docModalTitle">Preview Dokumen</span>
            </div>
            <button class="btn-close-modal" onclick="closeDocumentViewer()">
                <i class="bi bi-x-lg"></i>
            </button>
        </div>
        <div class="doc-modal-body">
            <div id="documentViewerContent" class="document-viewer-content">
                <div class="loading-spinner">
                    <i class="bi bi-hourglass-split"></i>
                    <p>Memuat dokumen...</p>
                </div>
            </div>
        </div>
        <div class="doc-modal-footer">
            <button class="btn-modal-action btn-modal-close" onclick="closeDocumentViewer()">
                <i class="bi bi-x-circle"></i>
                Tutup
            </button>
            <a id="downloadFromModal" href="#" class="btn-modal-action btn-modal-download">
                <i class="bi bi-download"></i>
                Download
            </a>
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
    
    const navItems = document.querySelectorAll('.tab-nav-item');
    if (tabName === 'detail') {
        navItems[0].classList.add('active');
    } else if (tabName === 'dokumen') {
        navItems[1].classList.add('active');
    } else if (tabName === 'verifikasi') {
        navItems[2].classList.add('active');
    }
    
    window.scrollTo({ top: 0, behavior: 'smooth' });
}

function showModal(config) {
    const modal = document.getElementById('confirmModal');
    const modalIcon = document.getElementById('modalIcon');
    const modalIconSymbol = document.getElementById('modalIconSymbol');
    const modalTitle = document.getElementById('modalTitle');
    const modalSubtitle = document.getElementById('modalSubtitle');
    const modalMessage = document.getElementById('modalMessage');
    const confirmBtn = document.getElementById('modalConfirmBtn');
    
    modalIcon.className = 'modal-icon';
    modalIconSymbol.className = 'bi';
    confirmBtn.className = 'modal-btn modal-btn-confirm';
    
    modalIcon.classList.add(config.iconClass);
    modalIconSymbol.classList.add(config.iconSymbol);
    modalTitle.textContent = config.title;
    modalSubtitle.textContent = config.subtitle;
    modalMessage.textContent = config.message;
    
    if (config.confirmClass) {
        confirmBtn.classList.add(config.confirmClass);
    }
    
    confirmBtn.onclick = config.onConfirm;
    
    modal.classList.add('active');
}

function closeModal() {
    document.getElementById('confirmModal').classList.remove('active');
}

function showSuccessAlert(message, type = 'approved') {
    const alert = document.getElementById('successAlert');
    const messageEl = document.getElementById('successMessage');
    const iconEl = document.querySelector('.success-alert-icon');
    
    alert.classList.remove('reject');
    iconEl.classList.remove('reject');
    
    if (type === 'rejected') {
        alert.classList.add('reject');
        iconEl.classList.add('reject');
    }
    
    messageEl.textContent = message;
    alert.classList.add('show');
    
    setTimeout(() => {
        alert.classList.remove('show');
    }, 3000);
}

function handleVerification(status) {
    const config = {
        title: status === 'Disetujui' ? 'Setujui Laporan' : 'Tolak Laporan',
        subtitle: 'Konfirmasi Verifikasi',
        message: `Apakah Anda yakin ingin ${status === 'Disetujui' ? 'menyetujui' : 'menolak'} laporan ini?`,
        iconClass: status === 'Disetujui' ? 'approve' : 'reject',
        iconSymbol: status === 'Disetujui' ? 'bi-check-circle' : 'bi-x-circle',
        confirmClass: status === 'Disetujui' ? 'approve' : '',
        onConfirm: () => {
            document.getElementById('statusInput').value = status;
            document.getElementById('statusForm').submit();
            closeModal();
        }
    };
    
    showModal(config);
}

function handleKomentarSubmit() {
    const komentarText = document.getElementById('komentarText').value.trim();
    
    if (!komentarText) {
        alert('Harap isi komentar terlebih dahulu.');
        return;
    }
    
    const config = {
        title: 'Kirim Komentar',
        subtitle: 'Konfirmasi Pengiriman',
        message: 'Apakah Anda yakin ingin mengirim komentar ini? Komentar akan disimpan dan dapat dilihat oleh pihak terkait.',
        iconClass: 'comment',
        iconSymbol: 'bi-chat-dots',
        confirmClass: '',
        onConfirm: () => {
            document.getElementById('komentarForm').submit();
            closeModal();
        }
    };
    
    showModal(config);
}

//lihat dokumen
function viewDocument(docId, filename, fileType) {
    const modal = document.getElementById('documentViewerModal');
    const modalTitle = document.getElementById('docModalTitle');
    const viewerContent = document.getElementById('documentViewerContent');
    const downloadBtn = document.getElementById('downloadFromModal');
    
    modalTitle.textContent = filename;
    
    downloadBtn.href = `/dokumen-aktual/${docId}/download`;
    
    viewerContent.innerHTML = `
        <div class="loading-spinner">
            <i class="bi bi-hourglass-split"></i>
            <p>Memuat dokumen...</p>
        </div>
    `;
    
    modal.classList.add('active');
    
    const viewUrl = `/dokumen-aktual/${docId}/view`;
    const extension = fileType.toLowerCase();
    
    setTimeout(() => {
        if (extension === 'pdf' || extension === 'docx') {
            viewerContent.innerHTML = `
                <iframe src="${viewUrl}" frameborder="0"></iframe>
            `;
        } else if (['jpg', 'jpeg', 'png'].includes(extension)) {
            viewerContent.innerHTML = `
                <img src="${viewUrl}" alt="${filename}">
            `;
        } else {
            viewerContent.innerHTML = `
                <div class="loading-spinner">
                    <i class="bi bi-file-earmark"></i>
                    <p>Preview tidak tersedia untuk tipe file ini.</p>
                    <p style="margin-top: 12px;">
                        <a href="${viewUrl}" class="btn-doc-action btn-download" download>
                            <i class="bi bi-download"></i>
                            <span>Download File</span>
                        </a>
                    </p>
                </div>
            `;
        }
    }, 500);
}

function closeDocumentViewer() {
    const modal = document.getElementById('documentViewerModal');
    modal.classList.remove('active');
    
    setTimeout(() => {
        document.getElementById('documentViewerContent').innerHTML = `
            <div class="loading-spinner">
                <i class="bi bi-hourglass-split"></i>
                <p>Memuat dokumen...</p>
            </div>
        `;
    }, 300);
}

window.addEventListener('DOMContentLoaded', () => {
    const urlParams = new URLSearchParams(window.location.search);
    const success = urlParams.get('success');
    const type = urlParams.get('type');
    
    if (success) {
        switchTab('verifikasi');
        
        showSuccessAlert(decodeURIComponent(success), type || 'approved');
        
        const newUrl = window.location.pathname;
        window.history.replaceState({}, document.title, newUrl);
    }
});

//tutup modal klo klik di luar area
document.getElementById('confirmModal').addEventListener('click', (e) => {
    if (e.target.id === 'confirmModal') {
        closeModal();
    }
});

//tutup dokumen klo klik di luar area
document.getElementById('documentViewerModal')?.addEventListener('click', (e) => {
    if (e.target.id === 'documentViewerModal') {
        closeDocumentViewer();
    }
});

//keluar klo klik esc key
document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape') {
        const confirmModal = document.getElementById('confirmModal');
        const docModal = document.getElementById('documentViewerModal');
        
        if (confirmModal && confirmModal.classList.contains('active')) {
            closeModal();
        }
        
        if (docModal && docModal.classList.contains('active')) {
            closeDocumentViewer();
        }
    }
});
</script>
@endpush