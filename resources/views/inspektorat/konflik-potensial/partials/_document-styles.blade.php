<style>
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
        border: none;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        position: relative;
    }

    .doc-modal-title {
        display: flex;
        align-items: center;
        gap: 12px;
        font-size: 1.1rem;
        font-weight: 700;
        color: var(--text-dark);
        text-align: center;
    }

    .doc-modal-title i {
        color: var(--primary-red);
        font-size: 1.3rem;
    }

    .btn-close-modal {
        position: absolute;
        right: 20px;
        top: 20px;
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
        border: none;
        display: flex;
        gap: 12px;
        justify-content: center;
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

    @media (max-width: 768px) {
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