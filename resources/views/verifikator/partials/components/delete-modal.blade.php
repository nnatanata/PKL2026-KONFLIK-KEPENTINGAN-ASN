<div id="deleteModal" class="delete-modal-overlay">
    <div class="delete-modal-content">
        <button type="button" class="delete-modal-close-btn" onclick="closeDeleteModal()">
            <i class="bi bi-x-lg"></i>
        </button>
        
        <div class="delete-modal-header">
            <div class="delete-modal-icon">
                <i class="bi bi-trash-fill"></i>
            </div>
            <div class="delete-modal-title">
                <h4>Hapus Laporan</h4>
            </div>
        </div>
        
        <div class="delete-modal-body">
            <p class="delete-modal-message" id="deleteMessage">
                Apakah Anda yakin ingin menghapus laporan ini? Tindakan ini tidak dapat dibatalkan.
            </p>
        </div>
        
        <div class="delete-modal-footer">
            <button type="button" class="delete-modal-btn delete-modal-btn-cancel" onclick="closeDeleteModal()">
                Batal
            </button>
            <button type="button" class="delete-modal-btn delete-modal-btn-confirm" onclick="executeDelete()">
                Hapus
            </button>
        </div>
    </div>
</div>

<form id="deleteForm" method="POST" style="display: none;">
    @csrf
    @method('DELETE')
</form>