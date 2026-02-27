@extends('verifikator.layout')

@section('title', 'Dashboard Verifikator')
@section('breadcrumb')
    Halo, {{ auth()->user()->pegawai->nama ?? auth()->user()->username }} 👋
@endsection

@section('content')

<h4 class="mb-4 fw-bold">Rekap Status Pelaporan</h4>

<div class="row mb-4">
    <div class="col-md-4">
        <div class="stat-card">
            <div class="stat-label">Disetujui</div>
            <div class="stat-number text-success">{{ $disetujui }}</div>
            <small class="text-muted">Total Laporan Disetujui</small>
        </div>
    </div>
    <div class="col-md-4">
        <div class="stat-card">
            <div class="stat-label">Diproses</div>
            <div class="stat-number text-warning">{{ $diproses }}</div>
            <small class="text-muted">Total Laporan Diproses</small>
        </div>
    </div>
    <div class="col-md-4">
        <div class="stat-card">
            <div class="stat-label">Ditolak</div>
            <div class="stat-number text-danger">{{ $ditolak }}</div>
            <small class="text-muted">Total Laporan Ditolak</small>
        </div>
    </div>
</div>

<div class="d-flex justify-content-between align-items-center mb-3">
    <h5 class="fw-semibold">Statistik Konflik Kepentingan</h5>
    <select class="form-select w-auto" id="yearSelector" onchange="updateChart()">
        <option value="2023">2023</option>
        <option value="2024">2024</option>
        <option value="2025">2025</option>
        <option value="2026" selected>2026</option>
    </select>
</div>

<div class="bg-white rounded-4 shadow-sm p-4" style="min-height:400px;">
    <canvas id="conflictChart"></canvas>
</div>

@endsection

@push('scripts')
<script>
    let conflictChart = null;

    //membuat chart
    function createChart(labels, dataAktual, dataPotensial) {
        const ctx = document.getElementById('conflictChart').getContext('2d');
        
        if (conflictChart) {
            conflictChart.destroy();
        }

        conflictChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [
                    {
                        label: 'Konflik Aktual',
                        data: dataAktual,
                        borderColor: '#2563EB',
                        backgroundColor: 'rgba(37, 99, 235, 0.12)',
                        borderWidth: 3,
                        fill: true,
                        tension: 0.4,
                        pointRadius: 5,
                        pointHoverRadius: 7,
                        pointBackgroundColor: '#2563EB',
                        pointBorderColor: '#fff',
                        pointBorderWidth: 2
                    },
                    {
                        label: 'Konflik Potensial',
                        data: dataPotensial,
                        borderColor: '#059669',
                        backgroundColor: 'rgba(5, 150, 105, 0.12)',
                        borderWidth: 3,
                        fill: true,
                        tension: 0.4,
                        pointRadius: 5,
                        pointHoverRadius: 7,
                        pointBackgroundColor: '#059669',
                        pointBorderColor: '#fff',
                        pointBorderWidth: 2
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                aspectRatio: 2.5,
                animation: {
                    duration: 400,
                    easing: 'easeInOutCubic'
                },
                plugins: {
                    legend: {
                        display: true,
                        position: 'top',
                        labels: {
                            font: {
                                size: 13,
                                weight: '600'
                            },
                            padding: 15,
                            usePointStyle: true,
                            pointStyle: 'circle'
                        }
                    },
                    tooltip: {
                        backgroundColor: 'rgba(0, 0, 0, 0.8)',
                        padding: 12,
                        titleFont: {
                            size: 14,
                            weight: 'bold'
                        },
                        bodyFont: {
                            size: 13
                        },
                        displayColors: true,
                        callbacks: {
                            label: function(context) {
                                let label = context.dataset.label || '';
                                if (label) {
                                    label += ': ';
                                }
                                label += context.parsed.y + ' laporan';
                                return label;
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 1,
                            font: {
                                size: 12
                            }
                        },
                        grid: {
                            color: 'rgba(0, 0, 0, 0.05)'
                        },
                        title: {
                            display: true,
                            text: 'Jumlah Laporan',
                            font: {
                                size: 13,
                                weight: '600'
                            }
                        }
                    },
                    x: {
                        ticks: {
                            font: {
                                size: 12
                            }
                        },
                        grid: {
                            display: false
                        },
                        title: {
                            display: true,
                            text: 'Bulan',
                            font: {
                                size: 13,
                                weight: '600'
                            }
                        }
                    }
                },
                interaction: {
                    intersect: false,
                    mode: 'index'
                }
            }
        });
    }

    function updateChart() {
        const year = document.getElementById('yearSelector').value;
        
        fetch(`/api/dashboard/chart-data?tahun=${year}`, {
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            createChart(data.labels, data.aktual, data.potensial);
        })
        .catch(error => {
            console.error('Error fetching chart data:', error);
        });
    }

    function resizeChart() {
        if (conflictChart) {
            const originalDuration = conflictChart.options.animation.duration;
            conflictChart.options.animation.duration = 0;
            
            conflictChart.resize();
            
            setTimeout(function() {
                conflictChart.options.animation.duration = originalDuration;
            }, 50);
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
        updateChart();
        
        const sidebar = document.getElementById('sidebar');
        const content = document.getElementById('content');
        
        if (sidebar && content) {
            const observer = new MutationObserver(function(mutations) {
                mutations.forEach(function(mutation) {
                    if (mutation.attributeName === 'class') {
                        setTimeout(function() {
                            resizeChart();
                        }, 150);
                        
                        setTimeout(function() {
                            resizeChart();
                        }, 320);
                    }
                });
            });
            
            observer.observe(sidebar, {
                attributes: true,
                attributeFilter: ['class']
            });
            
            observer.observe(content, {
                attributes: true,
                attributeFilter: ['class']
            });
        }
        
        let resizeTimer;
        window.addEventListener('resize', function() {
            clearTimeout(resizeTimer);
            resizeTimer = setTimeout(function() {
                resizeChart();
            }, 100);
        });
    });
</script>
@endpush