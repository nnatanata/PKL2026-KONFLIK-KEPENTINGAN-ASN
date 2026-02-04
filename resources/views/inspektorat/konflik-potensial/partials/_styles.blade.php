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
        --warning-yellow: #f59e0b;
        --warning-light: #fef3c7;
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

    .current-status.verifikator-approved {
        background: var(--warning-light);
        color: #92400e;
    }

    .current-status i {
        font-size: 1.3rem;
    }

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
    }
</style>

@include('inspektorat.konflik-potensial.partials._modal-styles')
@include('inspektorat.konflik-potensial.partials._document-styles')