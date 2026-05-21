@extends("layouts-admin.main")

@section('content')

<style>
    :root {
        --tblr-font-sans-serif: 'Inter', system-ui, sans-serif;
    }

    .navbar-brand-image {
        height: 2rem;
    }

    .stat-card-icon {
        width: 48px;
        height: 48px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 10px;
        font-size: 22px;
    }

    .badge-status {
        font-size: 11px;
        padding: 3px 8px;
        border-radius: 6px;
        font-weight: 500;
    }

    .product-avatar {
        width: 36px;
        height: 36px;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 13px;
        font-weight: 600;
    }

    .service-card {
        border: 1px solid #e6e7e9;
        border-radius: 10px;
        padding: 12px 14px;
        display: flex;
        align-items: center;
        gap: 12px;
        background: #fff;
    }

    .service-icon {
        width: 38px;
        height: 38px;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 18px;
    }
</style>
{{-- ═══════════════════════════════════════════════════════════
     STAT CARDS
════════════════════════════════════════════════════════════ --}}
<div class="row row-deck row-cards mb-4">

    {{-- Total Pengguna --}}
    <div class="col-sm-6 col-xl-3">
        <div class="card">
            <div class="card-body">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <div class="subheader text-muted">Total Pengguna</div>
                    <div class="stat-card-icon bg-blue-lt text-blue">
                        <i class="ti ti-users"></i>
                    </div>
                </div>
                <div class="h1 mb-1">{{ number_format($totalUsers) }}</div>
                <div class="d-flex gap-2 mt-2">
                    <span class="badge bg-green-lt text-green">{{ $userActive }} Aktif</span>
                    <span class="badge bg-warning-lt text-warning">{{ $userInactive }} Nonaktif</span>
                    @if($userBlocked > 0)
                    <span class="badge bg-danger-lt text-danger">{{ $userBlocked }} Blokir</span>
                    @endif
                </div>
                <div class="progress progress-sm mt-2">
                    @php $pct = $totalUsers > 0 ? round(($userActive / $totalUsers) * 100) : 0; @endphp
                    <div class="progress-bar bg-blue" style="width:{{ $pct }}%"
                        title="{{ $pct }}% aktif"></div>
                </div>
            </div>
        </div>
    </div>

    {{-- Total Produk --}}
    <div class="col-sm-6 col-xl-3">
        <div class="card">
            <div class="card-body">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <div class="subheader text-muted">Total Produk</div>
                    <div class="stat-card-icon bg-green-lt text-green">
                        <i class="ti ti-package"></i>
                    </div>
                </div>
                <div class="h1 mb-1">{{ number_format($totalProducts) }}</div>
                <div class="text-muted mt-2" style="font-size:12px;">Tersedia di katalog</div>
                <div class="progress progress-sm mt-2">
                    <div class="progress-bar bg-green" style="width:100%"></div>
                </div>
            </div>
        </div>
    </div>

    {{-- Total Transaksi --}}
    <div class="col-sm-6 col-xl-3">
        <div class="card">
            <div class="card-body">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <div class="subheader text-muted">Total Transaksi</div>
                    <div class="stat-card-icon bg-warning-lt text-warning">
                        <i class="ti ti-receipt"></i>
                    </div>
                </div>
                <div class="h1 mb-1">{{ number_format($totalTransactions) }}</div>
                <div class="d-flex gap-2 mt-2">
                    <span class="badge bg-warning-lt text-warning">{{ $txPending }} Pending</span>
                    <span class="badge bg-success-lt text-success">{{ $txDone }} Selesai</span>
                </div>
                <div class="progress progress-sm mt-2">
                    @php $donePct = $totalTransactions > 0 ? round(($txDone / $totalTransactions) * 100) : 0; @endphp
                    <div class="progress-bar bg-warning" style="width:{{ $donePct }}%"></div>
                </div>
            </div>
        </div>
    </div>

    {{-- Total Revenue --}}
    <div class="col-sm-6 col-xl-3">
        <div class="card">
            <div class="card-body">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <div class="subheader text-muted">Total Pendapatan</div>
                    <div class="stat-card-icon bg-teal-lt text-teal">
                        <i class="ti ti-cash"></i>
                    </div>
                </div>
                <div class="h1 mb-1" style="font-size:1.4rem;">
                    Rp {{ number_format($totalRevenue, 0, ',', '.') }}
                </div>
                <div class="text-muted mt-2" style="font-size:12px;">Dari {{ $txDone }} transaksi selesai</div>
                <div class="progress progress-sm mt-2">
                    <div class="progress-bar bg-teal" style="width:{{ $txDone > 0 ? 80 : 0 }}%"></div>
                </div>
            </div>
        </div>
    </div>

</div>

{{-- ═══════════════════════════════════════════════════════════
     CHARTS ROW
════════════════════════════════════════════════════════════ --}}
<div class="row row-deck row-cards mb-4">

    {{-- Bar chart: tren bulanan --}}
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="ti ti-chart-bar me-2 text-muted"></i>
                    Tren Transaksi 6 Bulan Terakhir
                </h3>
                <div class="card-options">
                    <span class="text-muted" style="font-size:12px;">Per status</span>
                </div>
            </div>
            <div class="card-body">
                <canvas id="transactionChart" height="100"></canvas>
            </div>
        </div>
    </div>

    {{-- Donut chart: status distribusi --}}
    <div class="col-lg-4">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="ti ti-chart-donut me-2 text-muted"></i>
                    Distribusi Status
                </h3>
            </div>
            <div class="card-body d-flex align-items-center justify-content-center" style="min-height:180px;">
                <canvas id="donutChart" style="max-height:180px; max-width:180px;"></canvas>
            </div>
            <div class="card-footer d-flex justify-content-around py-2">
                <div class="text-center">
                    <div class="text-muted" style="font-size:10px; font-weight:600; letter-spacing:.5px;">PENDING</div>
                    <div class="fw-bold text-warning">{{ $txPending }}</div>
                </div>
                <div class="text-center">
                    <div class="text-muted" style="font-size:10px; font-weight:600; letter-spacing:.5px;">PROCESS</div>
                    <div class="fw-bold text-blue">{{ $txProcess }}</div>
                </div>
                <div class="text-center">
                    <div class="text-muted" style="font-size:10px; font-weight:600; letter-spacing:.5px;">SHIPPING</div>
                    <div class="fw-bold text-azure">{{ $txShipping }}</div>
                </div>
                <div class="text-center">
                    <div class="text-muted" style="font-size:10px; font-weight:600; letter-spacing:.5px;">DONE</div>
                    <div class="fw-bold text-green">{{ $txDone }}</div>
                </div>
            </div>
        </div>
    </div>

</div>

{{-- ═══════════════════════════════════════════════════════════
     RECENT TRANSACTIONS + TOP PRODUCTS
════════════════════════════════════════════════════════════ --}}
<div class="row row-deck row-cards mb-4">

    {{-- Transaksi terbaru --}}
    <div class="col-lg-7">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="ti ti-list-details me-2 text-muted"></i>
                    Transaksi Terbaru
                </h3>
                <div class="card-options">
                    <a href="#" class="btn btn-sm btn-outline-primary">Lihat semua</a>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table table-vcenter table-hover card-table">
                    <thead>
                        <tr>
                            <th style="width:120px;">Invoice</th>
                            <th>Pelanggan</th>
                            <th>Grand Total</th>
                            <th>Status</th>
                            <th style="width:80px;">Tanggal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recentTransactions as $tx)
                        <tr>
                            <td>
                                <span class="text-muted fw-mono" style="font-size:12px;">
                                    {{ $tx->invoice ?? '-' }}
                                </span>
                            </td>
                            <td>
                                <div style="font-size:13px; font-weight:500;">{{ $tx->name ?? '-' }}</div>
                                @if($tx->city)
                                <div class="text-muted" style="font-size:11px;">{{ $tx->city }}</div>
                                @endif
                            </td>
                            <td>
                                <span style="font-size:13px;">
                                    Rp {{ number_format($tx->grand_total, 0, ',', '.') }}
                                </span>
                            </td>
                            <td>
                                @php
                                $statusMap = [
                                'PENDING' => 'warning',
                                'PROCESS' => 'blue',
                                'SHIPPING' => 'azure',
                                'DONE' => 'success',
                                ];
                                $color = $statusMap[$tx->status] ?? 'secondary';
                                @endphp
                                <span class="badge bg-{{ $color }}-lt text-{{ $color }}" style="font-size:11px;">
                                    {{ $tx->status }}
                                </span>
                            </td>
                            <td class="text-muted" style="font-size:11px;">
                                {{ $tx->created_at->format('d/m/Y') }}
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted py-4">
                                <i class="ti ti-inbox me-2"></i>Belum ada transaksi
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- Top produk --}}
    <div class="col-lg-5">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="ti ti-trophy me-2 text-muted"></i>
                    Produk Terlaris
                </h3>
            </div>
            <div class="card-body p-0">
                <div class="list-group list-group-flush">
                    @forelse($topProducts as $i => $product)
                    @php
                    $colors = ['blue','green','red','yellow','purple'];
                    $c = $colors[$i % count($colors)];
                    @endphp
                    <div class="list-group-item">
                        <div class="row align-items-center g-2">
                            <div class="col-auto">
                                <div class="product-avatar bg-{{ $c }}-lt text-{{ $c }}">
                                    {{ $i + 1 }}
                                </div>
                            </div>
                            <div class="col">
                                <div class="text-body" style="font-size:13px; font-weight:500; white-space:nowrap; overflow:hidden; text-overflow:ellipsis; max-width:160px;">
                                    {{ $product->name ?? '-' }}
                                </div>
                                <div class="text-muted d-flex align-items-center gap-1" style="font-size:11px;">
                                    <span>{{ $product->category ?? '-' }}</span>
                                    @if($product->rating)
                                    <span>·</span>
                                    <span>⭐ {{ number_format($product->rating, 1) }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-auto text-end">
                                <div style="font-size:12px; font-weight:600; color:#206bc4;">
                                    {{ number_format($product->sold ?? 0) }}
                                </div>
                                <div class="text-muted" style="font-size:10px;">terjual</div>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="list-group-item text-center text-muted py-4">
                        <i class="ti ti-package me-2"></i>Belum ada produk
                    </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

</div>

{{-- ═══════════════════════════════════════════════════════════
     USER STATUS + SERVICES
════════════════════════════════════════════════════════════ --}}
<div class="row row-deck row-cards">

    {{-- User status detail --}}
    <div class="col-lg-4">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="ti ti-users me-2 text-muted"></i>
                    Status Pengguna
                </h3>
            </div>
            <div class="card-body">
                @php
                $statusItems = [
                ['label' => 'ACTIVE', 'count' => $userActive, 'color' => 'green', 'icon' => 'ti-circle-check'],
                ['label' => 'INACTIVE', 'count' => $userInactive, 'color' => 'warning', 'icon' => 'ti-circle-minus'],
                ['label' => 'BLOCKED', 'count' => $userBlocked, 'color' => 'red', 'icon' => 'ti-circle-x'],
                ];
                @endphp
                @foreach($statusItems as $item)
                <div class="d-flex align-items-center mb-3">
                    <div class="me-3">
                        <i class="ti {{ $item['icon'] }} text-{{ $item['color'] }}" style="font-size:18px;"></i>
                    </div>
                    <div class="flex-grow-1">
                        <div class="d-flex justify-content-between mb-1">
                            <span style="font-size:12px; font-weight:500;">{{ $item['label'] }}</span>
                            <span style="font-size:12px;" class="text-muted">{{ $item['count'] }}</span>
                        </div>
                        <div class="progress" style="height:6px; border-radius:4px;">
                            @php $w = $totalUsers > 0 ? round(($item['count'] / $totalUsers) * 100) : 0; @endphp
                            <div class="progress-bar bg-{{ $item['color'] }}" style="width:{{ $w }}%"></div>
                        </div>
                    </div>
                </div>
                @endforeach

                <div class="border-top pt-3 mt-2">
                    <div class="row text-center">
                        <div class="col">
                            <div class="h3 mb-0">{{ $totalUsers }}</div>
                            <div class="text-muted" style="font-size:11px;">Total</div>
                        </div>
                        <div class="col">
                            <div class="h3 mb-0 text-green">{{ $userActive }}</div>
                            <div class="text-muted" style="font-size:11px;">Aktif</div>
                        </div>
                        <div class="col">
                            @php $adminCount = \App\Models\User::where('is_admin', 1)->count(); @endphp
                            <div class="h3 mb-0 text-blue">{{ $adminCount }}</div>
                            <div class="text-muted" style="font-size:11px;">Admin</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Services grid --}}
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="ti ti-tool me-2 text-muted"></i>
                    Layanan Aktif
                </h3>
                <div class="card-options">
                    <span class="badge bg-green-lt text-green">{{ $totalServices }} layanan</span>
                </div>
            </div>
            <div class="card-body">
                @if($services->isEmpty())
                <div class="text-center text-muted py-4">
                    <i class="ti ti-tool" style="font-size:32px; opacity:.3;"></i>
                    <p class="mt-2">Belum ada layanan aktif</p>
                </div>
                @else
                <div class="row g-2">
                    @php
                    $serviceIcons = ['🔧','🛠','📦','📋','🖥️','📡','🔌','⚙️'];
                    $serviceColors = ['blue','green','red','yellow','purple','teal','orange','cyan'];
                    @endphp
                    @foreach($services as $i => $service)
                    @php $c = $serviceColors[$i % count($serviceColors)]; @endphp
                    <div class="col-sm-6">
                        <div class="service-card">
                            <div class="service-icon bg-{{ $c }}-lt">
                                @if($service->icon)
                                <i class="ti {{ $service->icon }}" style="font-size:18px;"></i>
                                @else
                                <i class="ti ti-tool" style="font-size:18px;"></i>
                                @endif
                            </div>
                            <div class="flex-grow-1 overflow-hidden">
                                <div style="font-size:13px; font-weight:500; white-space:nowrap; overflow:hidden; text-overflow:ellipsis;">
                                    {{ $service->name }}
                                </div>
                                <div class="text-muted" style="font-size:11px;">
                                    Rp {{ number_format($service->price, 0, ',', '.') }}
                                </div>
                            </div>
                            <span class="badge bg-{{ $service->is_active ? 'success' : 'secondary' }}-lt" style="font-size:10px; white-space:nowrap;">
                                {{ $service->is_active ? 'Aktif' : 'Nonaktif' }}
                            </span>
                        </div>
                    </div>
                    @endforeach
                </div>
                @endif
            </div>
        </div>
    </div>

</div>
@endsection
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.1/chart.umd.min.js"></script>
@push('scripts')
<script>
    (function() {
        const labels = @json($chartLabels);

        const chartData = {
            PENDING: @json($chartData['PENDING']),
            PROCESS: @json($chartData['PROCESS']),
            SHIPPING: @json($chartData['SHIPPING']),
            DONE: @json($chartData['DONE']),
        };

        // Taruh variabel PHP di sini, bukan di dalam objek Chart
        const txPending = "{{ $txPending }}";
        const txProcess = "{{  $txProcess }}";
        const txShipping = "{{ $txShipping }}";
        const txDone = "{{ $txDone }}";

        // ── Bar chart ────────────────────────────────────────────
        const ctx1 = document.getElementById('transactionChart');
        if (ctx1) {
            new Chart(ctx1.getContext('2d'), {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [{
                            label: 'Pending',
                            data: chartData.PENDING,
                            backgroundColor: 'rgba(245,159,0,0.85)',
                            borderRadius: 4
                        },
                        {
                            label: 'Process',
                            data: chartData.PROCESS,
                            backgroundColor: 'rgba(32,107,196,0.85)',
                            borderRadius: 4
                        },
                        {
                            label: 'Shipping',
                            data: chartData.SHIPPING,
                            backgroundColor: 'rgba(66,153,225,0.85)',
                            borderRadius: 4
                        },
                        {
                            label: 'Done',
                            data: chartData.DONE,
                            backgroundColor: 'rgba(47,179,68,0.85)',
                            borderRadius: 4
                        },
                    ],
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: {
                                boxWidth: 10,
                                font: {
                                    size: 11
                                }
                            }
                        },
                        tooltip: {
                            mode: 'index',
                            intersect: false
                        },
                    },
                    scales: {
                        x: {
                            stacked: true,
                            grid: {
                                display: false
                            }
                        },
                        y: {
                            stacked: true,
                            beginAtZero: true,
                            ticks: {
                                stepSize: 1,
                                precision: 0
                            }
                        },
                    },
                },
            });
        }

        // ── Donut chart ──────────────────────────────────────────
        const ctx2 = document.getElementById('donutChart');
        if (ctx2) {
            new Chart(ctx2.getContext('2d'), {
                type: 'doughnut',
                data: {
                    labels: ['Pending', 'Process', 'Shipping', 'Done'],
                    datasets: [{
                        data: [txPending, txProcess, txShipping, txDone],
                        backgroundColor: ['#f59f00', '#206bc4', '#4299e1', '#2fb344'],
                        borderWidth: 0,
                        hoverOffset: 6,
                    }],
                },
                options: {
                    cutout: '72%',
                    plugins: {
                        legend: {
                            display: false
                        },
                        tooltip: {
                            callbacks: {
                                label: ctx => ` ${ctx.label}: ${ctx.parsed} transaksi`,
                            },
                        },
                    },
                },
            });
        }
    })();
</script>
@endpush