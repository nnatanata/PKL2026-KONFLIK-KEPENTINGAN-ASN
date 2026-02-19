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