<div id="confirmModal" class="modal-overlay">
    <div class="modal-content">
        <button type="button" class="modal-close-btn" onclick="closeModal()">
            <i class="bi bi-x-lg"></i>
        </button>
        
        <div class="modal-header">
            <div class="modal-icon" id="modalIcon">
                <i class="bi" id="modalIconSymbol"></i>
            </div>
            <div class="modal-title">
                <h4 id="modalTitle"></h4>
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
                Konfirmasi
            </button>
        </div>
    </div>
</div>