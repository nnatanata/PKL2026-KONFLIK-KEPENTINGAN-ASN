<script>
    let deleteItemId = null;
    let deleteItemName = null;

    function toggleFilter() {
        const filterPanel = document.getElementById('filterPanel');
        const overlay = document.getElementById('overlay');
        
        const isActive = filterPanel.classList.toggle('active');
        overlay.classList.toggle('active', isActive);
    }

    function closeAllPanels() {
        const filterPanel = document.getElementById('filterPanel');
        const overlay = document.getElementById('overlay');
        
        if (filterPanel) {
            filterPanel.classList.remove('active');
        }
        overlay.classList.remove('active');
    }

    function confirmDelete(id, name) {
        deleteItemId = id;
        deleteItemName = name;
        
        const message = document.getElementById('deleteMessage');
        message.textContent = `Apakah Anda yakin ingin menghapus laporan dari "${name}"? Tindakan ini tidak dapat dibatalkan.`;
        
        const modal = document.getElementById('deleteModal');
        modal.classList.add('active');
    }

    function closeDeleteModal() {
        const modal = document.getElementById('deleteModal');
        modal.classList.remove('active');
        deleteItemId = null;
        deleteItemName = null;
    }

    function executeDelete() {
        if (deleteItemId) {
            const form = document.getElementById('deleteForm');
            form.action = `{{ $deleteRoute }}/${deleteItemId}`;
            form.submit();
        }
    }

    document.getElementById('deleteModal')?.addEventListener('click', (e) => {
        if (e.target.id === 'deleteModal') {
            closeDeleteModal();
        }
    });

    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape') {
            const modal = document.getElementById('deleteModal');
            if (modal && modal.classList.contains('active')) {
                closeDeleteModal();
            }
        }
    });

    const searchInput = document.getElementById('searchInput');
    let searchTimeout;

    searchInput.addEventListener('input', function() {
        clearTimeout(searchTimeout);
        searchTimeout = setTimeout(() => {
            const url = new URL(window.location.href);
            if (this.value) {
                url.searchParams.set('search', this.value);
            } else {
                url.searchParams.delete('search');
            }
            window.location.href = url.toString();
        }, 500);
    });

    document.addEventListener('click', function(event) {
        const filterBtn = document.getElementById('filterBtn');
        const filterPanel = document.getElementById('filterPanel');
        
        if (filterBtn && filterPanel && 
            !filterBtn.contains(event.target) && 
            !filterPanel.contains(event.target)) {
            filterPanel.classList.remove('active');
            document.getElementById('overlay').classList.remove('active');
        }
    });
</script>