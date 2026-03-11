@extends('layouts.user')

@section('title', 'Panduan Pengguna SIMAKK ASN')

@section('content')
<div class="container">

    <h2 class="fw-bold mb-4" style="color: var(--brin-maroon);">Panduan</h2>

    <h5 class="fw-semibold mt-4 mb-3">Gambaran Umum SIMAKK ASN</h5>
    <div class="accordion mb-4" id="accordionUmum">
        <div class="accordion-item">
            <h2 class="accordion-header">
                <button class="accordion-button collapsed" data-bs-toggle="collapse" data-bs-target="#umum1">
                    Apa itu SIMAKK ASN?
                </button>
            </h2>
            <div id="umum1" class="accordion-collapse collapse">
                <div class="accordion-body">
                    SIMAKK ASN merupakan aplikasi yang digunakan untuk pelaporan, pencatatan,
                    dan pemantauan konflik kepentingan pada Aparatur Sipil Negara (ASN).
                    <br><br>
                    SIMAKK ASN mendukung dua jenis pelaporan:
                    <ul>
                        <li><strong>Laporan Potensial</strong>: dugaan konflik kepentingan yang berpotensi terjadi.</li>
                        <li><strong>Laporan Aktual</strong>: konflik kepentingan yang sudah terjadi.</li>
                    </ul>
                    Pengguna dapat mengajukan laporan, memantau status, serta melihat riwayat laporan yang pernah dibuat.
                </div>
            </div>
        </div>
    </div>

    <h5 class="fw-semibold mt-4 mb-3">Akses dan Akun Pengguna</h5>
    <div class="accordion mb-4" id="accordionAkun">
        <div class="accordion-item">
            <h2 class="accordion-header">
                <button class="accordion-button collapsed" data-bs-toggle="collapse" data-bs-target="#akun1">
                    Siapa saja yang dapat menggunakan SIMAKK ASN?
                </button>
            </h2>
            <div id="akun1" class="accordion-collapse collapse">
                <div class="accordion-body">
                    SIMAKK ASN dapat digunakan oleh Aparatur Sipil Negara (ASN)
                    yang telah memiliki akun terdaftar di sistem.
                </div>
            </div>
        </div>
        <div class="accordion-item">
            <h2 class="accordion-header">
                <button class="accordion-button collapsed" data-bs-toggle="collapse" data-bs-target="#akun2">
                    Apakah pengguna harus login untuk menggunakan fitur?
                </button>
            </h2>
            <div id="akun2" class="accordion-collapse collapse">
                <div class="accordion-body">
                    Ya. Seluruh fitur utama seperti membuat laporan, melihat status,
                    dan mengakses detail laporan hanya dapat digunakan setelah pengguna login.
                </div>
            </div>
        </div>
    </div>

    <h5 class="fw-semibold mt-4 mb-3">Laman Utama Pengguna</h5>
    <div class="accordion mb-4" id="accordionDashboard">
        <div class="accordion-item">
            <h2 class="accordion-header">
                <button class="accordion-button collapsed" data-bs-toggle="collapse" data-bs-target="#dash1">
                    Apa saja yang ditampilkan di halaman utama?
                </button>
            </h2>
            <div id="dash1" class="accordion-collapse collapse">
                <div class="accordion-body">
                    Halaman utama pengguna menampilkan ringkasan aktivitas pelaporan pengguna, antara lain:
                    <ul>
                        <li>Total Pelaporan</li>
                        <li>Jumlah laporan dengan status Diproses, Diterima, dan Ditolak</li>
                        <li>Status terkini laporan</li>
                        <li>Daftar laporan yang telah disubmit</li>
                        <li>Berita terbaru yang terkait dengan ASN</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <h5 class="fw-semibold mt-4 mb-3">Pelaporan Konflik</h5>
    <div class="accordion mb-4" id="accordionPelaporan">
        <div class="accordion-item">
            <h2 class="accordion-header">
                <button class="accordion-button collapsed" data-bs-toggle="collapse" data-bs-target="#lap1">
                    Data apa saja yang diisi dalam Laporan Potensial?
                </button>
            </h2>
            <div id="lap1" class="accordion-collapse collapse">
                <div class="accordion-body">
                    Laporan Potensial digunakan untuk melaporkan dugaan konflik kepentingan
                    yang belum terjadi, namun berpotensi terjadi di kemudian hari.
                    <br><br>
                    Formulir pelaporan konflik potensial mencakup:
                    <ul>
                        <li>Identitas diri pelapor</li>
                        <li>Identitas terduga konflik</li>
                        <li>Jabatan dan unit kerja</li>
                        <li>Daftar keluarga/kerabat berpotensi konflik</li>
                        <li>Kepemilikan saham, aset, atau investasi</li>
                        <li>Pekerjaan lain di luar pekerjaan pokok</li>
                        <li>Jabatan publik lain</li>
                        <li>Keanggotaan organisasi</li>
                        <li>Rencana kerja pasca pensiun</li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="accordion-item">
            <h2 class="accordion-header">
                <button class="accordion-button collapsed" data-bs-toggle="collapse" data-bs-target="#lap2">
                    Data apa saja yang diisi dalam Laporan Aktual?
                </button>
            </h2>
            <div id="lap2" class="accordion-collapse collapse">
                <div class="accordion-body">
                    Laporan Aktual digunakan untuk melaporkan konflik kepentingan
                    yang telah terjadi secara nyata.
                    <br><br>
                    Formulir pelaporan konflik aktual mencakup:
                    <ul>
                        <li>Identitas diri pelapor</li>
                        <li>Identitas pejabat yang terlibat</li>
                        <li>Sumber konflik</li>
                        <li>Kaitan konflik dengan pengambilan keputusan</li>
                        <li>Saran pengendalian konflik</li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="accordion-item">
            <h2 class="accordion-header">
                <button class="accordion-button collapsed" data-bs-toggle="collapse" data-bs-target="#lap3">
                    Apakah saat mengisi laporan wajib mengunggah dokumen?
                </button>
            </h2>
            <div id="lap3" class="accordion-collapse collapse">
                <div class="accordion-body">
                    Tidak wajib, namun sangat disarankan untuk mendukung laporan yang diajukan.
                </div>
            </div>
        </div>
        <div class="accordion-item">
            <h2 class="accordion-header">
                <button class="accordion-button collapsed" data-bs-toggle="collapse" data-bs-target="#lap4">
                    Dokumen apa saja yang dapat diunggah?
                </button>
            </h2>
            <div id="lap4" class="accordion-collapse collapse">
                <div class="accordion-body">
                    Dokumen pendukung dapat berupa file yang relevan dengan laporan, 
                    seperti surat, bukti pendukung, dan dokumen resmi lainnya dalam 
                    format PDF, PNG, JPG, dan DOCX.
                </div>
            </div>
        </div>
    </div>

    <h5 class="fw-semibold mt-4 mb-3">Status dan Detail Laporan</h5>
    <div class="accordion mb-5" id="accordionStatus">
        <div class="accordion-item">
            <h2 class="accordion-header">
                <button class="accordion-button collapsed" data-bs-toggle="collapse" data-bs-target="#status1">
                    Bagaimana cara melihat detail laporan yang sudah dibuat?
                </button>
            </h2>
            <div id="status1" class="accordion-collapse collapse">
                <div class="accordion-body">
                    Detail laporan dapat diakses melalui
                    Dashboard → Status Terbaru → Halaman Status Laporan.
                </div>
            </div>
        </div>
        <div class="accordion-item">
            <h2 class="accordion-header">
                <button class="accordion-button collapsed" data-bs-toggle="collapse" data-bs-target="#status2">
                    Apa saja status laporan yang tersedia?
                </button>
            </h2>
            <div id="status2" class="accordion-collapse collapse">
                <div class="accordion-body">
                    <ul>
                        <li><strong>Diproses</strong> : Laporan baru dikirim oleh pengguna dan ditinjau oleh verifikator dan inspektorat</li>
                        <li><strong>Diterima</strong> : Proses peninjauan telah selesai dan laporan konflik diterima oleh verifikator dan inspektorat</li>
                        <li><strong>Ditolak</strong>  : Proses peninjauan telah selesai dan laporan konflik ditolak oleh verifikator atau inspektorat</li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="accordion-item">
            <h2 class="accordion-header">
                <button class="accordion-button collapsed" data-bs-toggle="collapse" data-bs-target="#status3">
                    Apakah laporan yang sudah dikirim dapat diubah atau dihapus?
                </button>
            </h2>
            <div id="status3" class="accordion-collapse collapse">
                <div class="accordion-body">
                    Tidak. Laporan yang sudah dikirim oleh pengguna tidak dapat diubah atau dihapus oleh pengguna.
                </div>
            </div>
        </div>
    </div>

</div>
@endsection