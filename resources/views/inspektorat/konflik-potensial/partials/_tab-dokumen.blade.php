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
                        <div class="filename">{{ $doc->nama_file_potensial }}</div>
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
                            onclick="viewDocument({{ $doc->id }}, '{{ $doc->nama_file_potensial }}', '{{ $doc->tipe_doc }}')"
                            title="Lihat Dokumen">
                        <i class="bi bi-eye"></i>
                        <span>Lihat</span>
                    </button>
                    <a href="{{ route('inspektorat.dokumen-potensial.download', $doc->id) }}" 
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