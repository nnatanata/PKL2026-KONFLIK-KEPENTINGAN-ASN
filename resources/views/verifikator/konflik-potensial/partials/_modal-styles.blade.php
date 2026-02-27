@push('styles')
<style>
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
        padding: 40px 32px 32px 32px;
        max-width: 480px;
        width: 90%;
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.2);
        animation: slideUp 0.3s ease;
        overflow: hidden;
        text-align: center;
        position: relative;
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

    .modal-close-btn {
        position: absolute;
        top: 16px;
        right: 16px;
        width: 32px;
        height: 32px;
        border: none;
        background: transparent;
        color: var(--text-medium);
        cursor: pointer;
        border-radius: 6px;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.2s ease;
        font-size: 1.2rem;
    }

    .modal-close-btn:hover {
        background: var(--bg-light);
        color: var(--text-dark);
    }

    .modal-header {
        padding: 0;
        border: none;
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 20px;
        margin-bottom: 24px;
    }

    .modal-icon {
        width: 72px;
        height: 72px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2.2rem;
        margin: 0 auto;
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
        text-align: center;
    }

    .modal-title h4 {
        margin: 0 0 8px 0;
        font-size: 1.35rem;
        font-weight: 700;
        color: var(--text-dark);
    }

    .modal-title p {
        margin: 0;
        font-size: 0.9rem;
        color: var(--text-medium);
        display: none;
    }

    .modal-body {
        padding: 0 12px 28px 12px;
        text-align: center;
    }

    .modal-message {
        font-size: 0.95rem;
        color: var(--text-medium);
        line-height: 1.6;
        margin: 0;
    }

    .modal-footer {
        padding: 0;
        display: flex;
        gap: 12px;
        justify-content: center;
        border: none;
    }

    .modal-btn {
        padding: 12px 32px;
        border-radius: 8px;
        border: none;
        font-size: 0.95rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        flex: 1;
        max-width: 180px;
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
</style>
@endpush