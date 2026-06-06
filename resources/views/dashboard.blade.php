@extends('templates.master')

@section('title', 'Dashboard')

@section('content')
@if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm mb-4 d-flex align-items-center" role="alert">
        <i class="bi bi-exclamation-triangle-fill me-2 fs-5"></i>
        <div>
            <strong class="d-block">Akses Ditolak!</strong>
            <span class="small">{{ session('error') }}</span>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif
<div class="row g-3 mb-4">
    <div class="col-12 col-sm-6 col-xl-3">
        <div class="card border-0 shadow-sm p-3 bg-white">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <h6 class="text-muted mb-1 small text-uppercase fw-bold">Total Obat</h6>
                    <h3 class="mb-0 fw-bold text-dark">{{ $totalObat ?? 0 }}</h3>
                </div>
                <div class="bg-primary bg-opacity-10 p-3 rounded text-primary">
                    <i class="bi bi-capsule fs-3"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="col-12 col-sm-6 col-xl-3">
        <div class="card border-0 shadow-sm p-3 bg-white">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <h6 class="text-muted mb-1 small text-uppercase fw-bold">Kategori Obat</h6>
                    <h3 class="mb-0 fw-bold text-dark">{{ $totalKategori ?? 0 }}</h3>
                </div>
                <div class="bg-success bg-opacity-10 p-3 rounded text-success">
                    <i class="bi bi-tags fs-3"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="col-12 col-sm-6 col-xl-3">
        <div class="card border-0 shadow-sm p-3 bg-white">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <h6 class="text-muted mb-1 small text-uppercase fw-bold">Total Mutasi</h6>
                    <h3 class="mb-0 fw-bold text-dark">{{ $totalMutasi ?? 0 }}</h3>
                </div>
                <div class="bg-warning bg-opacity-10 p-3 rounded text-warning">
                    <i class="bi bi-arrow-left-right"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="col-12 col-sm-6 col-xl-3">
        <div class="card border-0 shadow-sm p-3 bg-white">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <h6 class="text-muted mb-1 small text-uppercase fw-bold">Total Petugas</h6>
                    <h3 class="mb-0 fw-bold text-dark">{{ $totalUser ?? 0 }}</h3>
                </div>
                <div class="bg-info bg-opacity-10 p-3 rounded text-info">
                    <i class="bi bi-people fs-3"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row g-3 mb-4">
    <div class="col-12 col-md-6">
        <div class="card border-0 shadow-sm p-3 bg-white">
            <h6 class="fw-bold text-secondary mb-3"><i class="bi bi-graph-down-arrow text-danger me-2"></i>Grafik 5 Obat Stok Terendah</h6>
            <div style="position: relative; height:250px;">
                <canvas id="chartStokTerendah"></canvas>
            </div>
        </div>
    </div>
    
    <div class="col-12 col-md-6">
        <div class="card border-0 shadow-sm p-3 bg-white">
            <h6 class="fw-bold text-secondary mb-3"><i class="bi bi-graph-up-arrow text-primary me-2"></i>Grafik 5 Obat Stok Tertinggi</h6>
            <div style="position: relative; height:250px;">
                <canvas id="chartStokTertinggi"></canvas>
            </div>
        </div>
    </div>
</div>

<div class="row g-3">
    <div class="col-12 col-xl-6">
        <div class="card border-0 shadow-sm bg-white">
            <div class="card-header bg-white py-3 border-0">
                <h6 class="mb-0 fw-bold text-danger"><i class="bi bi-exclamation-triangle-fill me-2"></i>Daftar 5 Stok Terendah</h6>
            </div>
            <div class="table-responsive p-0">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light text-secondary small">
                        <tr>
                            <th class="ps-3">Nama Obat</th>
                            <th>Stok</th>
                            <th>Status / Flag</th>
                        </tr>
                    </thead>
                    <tbody class="small">
                        @forelse($stokterendah as $obat)
                            <tr>
                                <td class="ps-3 fw-semibold text-dark">{{ $obat->nama_obat }}</td>
                                <td>{{ $obat->stok }}</td>
                                <td>
                                    @if($obat->stok == 0)
                                        <span class="badge bg-dark text-white"><i class="bi bi-x-circle-fill me-1"></i> Habis (0)</span>
                                    @elseif($obat->stok < 10)
                                        <span class="badge bg-danger"><i class="bi bi-flag-fill me-1"></i> Stok Kritis (<10)</span>
                                    @else
                                        <span class="badge bg-secondary">Aman</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="text-center p-3 text-muted">Tidak ada data obat terdeteksi</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="col-12 col-xl-6">
        <div class="card border-0 shadow-sm bg-white">
            <div class="card-header bg-white py-3 border-0">
                <h6 class="mb-0 fw-bold text-primary"><i class="bi bi-arrow-up-square-fill me-2"></i>Daftar 5 Stok Tertinggi</h6>
            </div>
            <div class="table-responsive p-0">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light text-secondary small">
                        <tr>
                            <th class="ps-3">Nama Obat</th>
                            <th>Stok</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody class="small">
                        @forelse($stoktertinggi as $obat)
                            <tr>
                                <td class="ps-3 fw-semibold text-dark">{{ $obat->nama_obat }}</td>
                                <td>{{ $obat->stok }}</td>
                                <td>
                                    <span class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-25 px-2">Stok Melimpah</span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="text-center p-3 text-muted">Tidak ada data obat terdeteksi</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Options standard untuk kedua grafik agar layout rapi dan responsive
        const chartOptions = {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: { stepSize: 1 }
                }
            },
            plugins: {
                legend: { display: false }
            }
        };

        // 1. Inisialisasi Grafik Stok Terendah
        const ctxTerendah = document.getElementById('chartStokTerendah').getContext('2d');
        new Chart(ctxTerendah, {
            type: 'bar',
            data: {
                labels: {!! json_encode($stokterendah->pluck('nama_obat')) !!},
                datasets: [{
                    data: {!! json_encode($stokterendah->pluck('stok')) !!},
                    backgroundColor: 'rgba(220, 53, 69, 0.8)', // Merah Danger Bootstrap
                    borderColor: 'rgb(220, 53, 69)',
                    borderWidth: 1,
                    borderRadius: 4
                }]
            },
            options: chartOptions
        });

        // 2. Inisialisasi Grafik Stok Tertinggi
        const ctxTertinggi = document.getElementById('chartStokTertinggi').getContext('2d');
        new Chart(ctxTertinggi, {
            type: 'bar',
            data: {
                labels: {!! json_encode($stoktertinggi->pluck('nama_obat')) !!},
                datasets: [{
                    data: {!! json_encode($stoktertinggi->pluck('stok')) !!},
                    backgroundColor: 'rgba(13, 110, 253, 0.8)', // Biru Primary Bootstrap
                    borderColor: 'rgb(13, 110, 253)',
                    borderWidth: 1,
                    borderRadius: 4
                }]
            },
            options: chartOptions
        });
    });
</script>
@endsection