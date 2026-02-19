<style>
    :root {
        --main-red: #b11217;
        --active-red: #c72822;
        --text-dark: #1e293b;
        --text-medium: #475569;
        --text-light: #94a3b8;
        --bg-white: #ffffff;
        --bg-light: #f8fafc;
        --border-light: #e2e8f0;
    }

    /*search dan filter*/
    .toolbar-container {
        background: white;
        border-radius: 12px;
        padding: 20px;
        margin-bottom: 20px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        display: flex;
        gap: 12px;
        align-items: center;
    }

    /*search bar*/
    .search-wrapper {
        flex: 1;
        position: relative;
    }

    .search-input {
        width: 100%;
        padding: 10px 16px 10px 40px;
        border: 1px solid #dee2e6;
        border-radius: 8px;
        font-size: 0.9rem;
    }

    .search-input:focus {
        outline: none;
        border-color: var(--main-red);
    }

    .search-icon {
        position: absolute;
        left: 14px;
        top: 50%;
        transform: translateY(-50%);
        color: #6c757d;
    }

    /*buttons */
    .btn-toolbar {
        padding: 10px 20px;
        border: 1px solid #dee2e6;
        border-radius: 8px;
        background: white;
        font-size: 0.9rem;
        cursor: pointer;
        transition: all 0.3s;
        display: flex;
        align-items: center;
        gap: 8px;
        white-space: nowrap;
        position: relative;
    }

    .btn-toolbar:hover {
        background: #f8f9fa;
        border-color: var(--main-red);
        color: var(--main-red);
    }

    .btn-toolbar i {
        font-size: 1rem;
    }

    /*filter*/
    .filter-container {
        position: relative;
    }

    .filter-panel {
        position: absolute;
        top: 100%;
        right: 0;
        margin-top: 8px;
        background: white;
        border: 1px solid #dee2e6;
        border-radius: 12px;
        padding: 20px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        z-index: 1000;
        width: 340px;
        display: none;
    }

    .filter-panel.active {
        display: block;
    }

    .filter-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
        padding-bottom: 12px;
        border-bottom: 2px solid #f0f0f0;
    }

    .filter-header h6 {
        margin: 0;
        font-weight: 600;
        font-size: 1rem;
    }

    .filter-reset {
        color: var(--main-red);
        font-size: 0.85rem;
        cursor: pointer;
        text-decoration: none;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .filter-reset:hover {
        text-decoration: none;
        color: var(--active-red);
    }

    .filter-group {
        margin-bottom: 20px;
    }

    .filter-group label {
        display: block;
        font-size: 0.85rem;
        font-weight: 600;
        color: #495057;
        margin-bottom: 8px;
    }

    .filter-input,
    .filter-select {
        width: 100%;
        padding: 10px 12px;
        border: 1px solid #dee2e6;
        border-radius: 6px;
        font-size: 0.9rem;
    }

    .filter-input:focus,
    .filter-select:focus {
        outline: none;
        border-color: var(--main-red);
    }

    .filter-actions {
        display: flex;
        gap: 10px;
        margin-top: 20px;
        padding-top: 16px;
        border-top: 1px solid #f0f0f0;
    }

    .btn-filter-action {
        flex: 1;
        padding: 10px;
        border: none;
        border-radius: 6px;
        font-size: 0.9rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s;
    }

    .btn-filter-reset {
        background: #f8f9fa;
        color: #495057;
        text-decoration: none;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .btn-filter-reset:hover {
        background: #e9ecef;
        text-decoration: none;
    }

    .btn-filter-apply {
        background: var(--main-red);
        color: white;
    }

    .btn-filter-apply:hover {
        background: var(--active-red);
    }

    /*tabel*/
    .table-container {
        background: white;
        border-radius: 12px;
        padding: 25px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.08);
    }

    .table-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
    }

    .table-title {
        margin: 0;
        font-weight: 600;
        font-size: 1.1rem;
        color: #1e293b;
    }

    .table-title i {
        color: var(--main-red);
    }

    .table {
        margin-bottom: 0;
    }

    .table thead th {
        background: #f8f9fa;
        border-bottom: 2px solid #dee2e6;
        color: #495057;
        font-weight: 600;
        padding: 15px 12px;
        font-size: 0.9rem;
        text-align: center;
        vertical-align: middle;
    }

    .table tbody td {
        padding: 14px 12px;
        vertical-align: middle;
        font-size: 0.9rem;
    }

    .table tbody tr:hover {
        background-color: #f8f9fa;
        cursor: pointer;
    }

    .badge-status {
        padding: 6px 12px;
        border-radius: 6px;
        font-size: 0.85rem;
        font-weight: 500;
        display: inline-block;
    }

    .status-disetujui {
        background: #d4edda;
        color: #155724;
    }

    .status-diproses {
        background: #fff3cd;
        color: #856404;
    }

    .status-ditolak {
        background: #f8d7da;
        color: #721c24;
    }

    .status-disetujui-inspektorat {
        background: #10b981;
        color: white;
        font-weight: 600;
    }

    .status-ditolak-inspektorat {
        background: #ef4444;
        color: white;
        font-weight: 600;
    }

    .status-badge-container {
        display: flex;
        flex-direction: column;
        gap: 6px;
        align-items: center;
    }

    .btn-action {
        padding: 6px 10px;
        font-size: 0.9rem;
        border-radius: 6px;
        margin: 0 2px;
    }

    .id-cell {
        position: relative;
        cursor: help;
    }

    .id-display {
        font-family: 'Courier New', monospace;
        color: #495057;
        font-weight: 600;
    }

    .id-tooltip {
        position: absolute;
        background: #333;
        color: white;
        padding: 6px 10px;
        border-radius: 6px;
        font-size: 0.85rem;
        white-space: nowrap;
        z-index: 1000;
        bottom: 100%;
        left: 50%;
        transform: translateX(-50%);
        margin-bottom: 5px;
        opacity: 0;
        pointer-events: none;
        transition: opacity 0.2s;
    }

    .id-tooltip::after {
        content: '';
        position: absolute;
        top: 100%;
        left: 50%;
        transform: translateX(-50%);
        border: 5px solid transparent;
        border-top-color: #333;
    }

    .id-cell:hover .id-tooltip {
        opacity: 1;
    }

    /*pagination*/
    .custom-pagination {
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 8px;
        margin-top: 20px;
        padding: 15px 0;
    }

    .custom-pagination .page-btn {
        min-width: 36px;
        height: 36px;
        display: flex;
        align-items: center;
        justify-content: center;
        border: 1px solid #dee2e6;
        background: white;
        color: #495057;
        text-decoration: none;
        border-radius: 6px;
        font-size: 0.9rem;
        font-weight: 500;
        transition: all 0.3s;
        padding: 0 12px;
    }

    .custom-pagination .page-btn:hover {
        background: #f8f9fa;
        border-color: var(--main-red);
        color: var(--main-red);
    }

    .custom-pagination .page-btn.active {
        background: var(--main-red);
        border-color: var(--main-red);
        color: white;
    }

    .custom-pagination .page-btn.disabled {
        opacity: 0.5;
        pointer-events: none;
        cursor: not-allowed;
    }

    .custom-pagination .page-dots {
        color: #6c757d;
        padding: 0 8px;
    }

    .filter-badge {
        position: absolute;
        top: -4px;
        right: -4px;
        width: 8px;
        height: 8px;
        background: var(--main-red);
        border-radius: 50%;
        pointer-events: none;
    }

    .overlay {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0,0,0,0.3);
        z-index: 999;
        display: none;
    }

    .overlay.active {
        display: block;
    }

    .delete-modal-overlay {
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

    .delete-modal-overlay.active {
        display: flex;
    }

    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }

    .delete-modal-content {
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

    .delete-modal-close-btn {
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

    .delete-modal-close-btn:hover {
        background: var(--bg-light);
        color: var(--text-dark);
    }

    .delete-modal-header {
        padding: 0;
        border: none;
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 20px;
        margin-bottom: 24px;
    }

    .delete-modal-icon {
        width: 72px;
        height: 72px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2.2rem;
        margin: 0 auto;
        background: #fee2e2;
        color: #b11217;
    }

    .delete-modal-title {
        text-align: center;
    }

    .delete-modal-title h4 {
        margin: 0 0 8px 0;
        font-size: 1.35rem;
        font-weight: 700;
        color: var(--text-dark);
    }

    .delete-modal-body {
        padding: 0 12px 28px 12px;
        text-align: center;
    }

    .delete-modal-message {
        font-size: 0.95rem;
        color: var(--text-medium);
        line-height: 1.6;
        margin: 0;
    }

    .delete-modal-footer {
        padding: 0;
        display: flex;
        gap: 12px;
        justify-content: center;
        border: none;
    }

    .delete-modal-btn {
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

    .delete-modal-btn-cancel {
        background: var(--bg-light);
        color: var(--text-dark);
        border: 1px solid var(--border-light);
    }

    .delete-modal-btn-cancel:hover {
        background: #e2e8f0;
    }

    .delete-modal-btn-confirm {
        background: #b11217;
        color: white;
    }

    .delete-modal-btn-confirm:hover {
        background: #c72822;
    }

    @media (max-width: 768px) {
        .delete-modal-btn {
            max-width: none;
        }
    }
</style>