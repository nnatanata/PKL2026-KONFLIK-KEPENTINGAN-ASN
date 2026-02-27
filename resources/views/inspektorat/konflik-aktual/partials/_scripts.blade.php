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
    } else if (tabName === 'status') {
        navItems[3].classList.add('active');
    }
    
    window.scrollTo({ top: 0, behavior: 'smooth' });
}

function showModal(config) {
    const modal = document.getElementById('confirmModal');
    const modalIcon = document.getElementById('modalIcon');
    const modalIconSymbol = document.getElementById('modalIconSymbol');
    const modalTitle = document.getElementById('modalTitle');
    const modalMessage = document.getElementById('modalMessage');
    const confirmBtn = document.getElementById('modalConfirmBtn');
    
    modalIcon.className = 'modal-icon';
    modalIconSymbol.className = 'bi';
    confirmBtn.className = 'modal-btn modal-btn-confirm';
    
    modalIcon.classList.add(config.iconClass);
    modalIconSymbol.classList.add(config.iconSymbol);
    modalTitle.textContent = config.title;
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
    const iconEl = document.getElementById('successAlertIcon');
    const iconSymbol = document.getElementById('successAlertIconSymbol');

    alert.classList.remove('reject');
    iconEl.classList.remove('reject');
    iconSymbol.className = 'bi bi-check-circle-fill';

    if (type === 'rejected') {
        alert.classList.add('reject');
        iconEl.classList.add('reject');
        iconSymbol.className = 'bi bi-x-circle-fill';
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
        message: `Apakah Anda yakin ingin ${status === 'Disetujui' ? 'menyetujui' : 'menolak'} laporan ini?`,
        iconClass: status === 'Disetujui' ? 'approve' : 'reject',
        iconSymbol: status === 'Disetujui' ? 'bi-check-circle-fill' : 'bi-x-circle-fill',
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
        message: 'Apakah Anda yakin ingin mengirim komentar ini? Komentar akan disimpan dan dapat dilihat oleh pihak terkait.',
        iconClass: 'comment',
        iconSymbol: 'bi-chat-dots-fill',
        confirmClass: '',
        onConfirm: () => {
            document.getElementById('komentarForm').submit();
            closeModal();
        }
    };
    
    showModal(config);
}

function handleRekomendasiSubmit() {
    const rekomendasiText = document.getElementById('rekomendasiText').value.trim();
    
    if (!rekomendasiText) {
        alert('Harap isi rekomendasi terlebih dahulu.');
        return;
    }
    
    const config = {
        title: 'Kirim Rekomendasi',
        message: 'Apakah Anda yakin ingin mengirim rekomendasi ini? Rekomendasi akan disimpan dan dapat dilihat oleh pihak terkait.',
        iconClass: 'comment',
        iconSymbol: 'bi-chat-dots-fill',
        confirmClass: '',
        onConfirm: () => {
            document.getElementById('rekomendasiForm').submit();
            closeModal();
        }
    };
    
    showModal(config);
}

function viewDocument(docId, filename, fileType) {
    const modal = document.getElementById('documentViewerModal');
    const modalTitle = document.getElementById('docModalTitle');
    const viewerContent = document.getElementById('documentViewerContent');
    const downloadBtn = document.getElementById('downloadFromModal');
    
    modalTitle.textContent = filename;
    downloadBtn.href = `/inspektorat/dokumen-aktual/${docId}/download`;
    
    viewerContent.innerHTML = `
        <div class="loading-spinner">
            <i class="bi bi-hourglass-split"></i>
            <p>Memuat dokumen...</p>
        </div>
    `;
    
    modal.classList.add('active');
    
    const viewUrl = `/inspektorat/dokumen-aktual/${docId}/view`;
    const extension = fileType.toLowerCase();
    
    setTimeout(() => {
        if (extension === 'pdf' || extension === 'docx') {
            viewerContent.innerHTML = `<iframe src="${viewUrl}" frameborder="0"></iframe>`;
        } else if (['jpg', 'jpeg', 'png'].includes(extension)) {
            viewerContent.innerHTML = `<img src="${viewUrl}" alt="${filename}">`;
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
    @if(session('success'))
        switchTab('verifikasi');
        showSuccessAlert('{{ session('success') }}', '{{ session('type', 'approved') }}');
    @endif
});

document.getElementById('confirmModal').addEventListener('click', (e) => {
    if (e.target.id === 'confirmModal') {
        closeModal();
    }
});

document.getElementById('documentViewerModal')?.addEventListener('click', (e) => {
    if (e.target.id === 'documentViewerModal') {
        closeDocumentViewer();
    }
});

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