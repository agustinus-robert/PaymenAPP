@extends('portal::layout.index')

@section('navtitle', 'Dashboard')

@section('contents')
    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid">

                <div class="row">
                    <div class="col-12">
                        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                            <h4 class="mb-sm-0 font-size-18">Dashboard</h4>
                            <div class="page-title-right">
                                <ol class="breadcrumb m-0">
                                    <li class="breadcrumb-item"><a href="javascript: void(0);">Portal</a></li>
                                    <li class="breadcrumb-item active">Dashboard</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12">
                        <form method="GET" action="" class="bg-light p-3 rounded-3 mb-4">
                            <div class="row g-3">
                                <div class="col-md-5">
                                    <label class="form-label small fw-bold text-muted">Mulai Tanggal</label>
                                    <input type="date" name="start_date" class="form-control" value="{{ request('start_date') }}">
                                </div>
                                <div class="col-md-5">
                                    <label class="form-label small fw-bold text-muted">Sampai Tanggal</label>
                                    <input type="date" name="end_date" class="form-control" value="{{ request('end_date') }}">
                                </div>
                                <div class="col-md-2 d-flex align-items-end">
                                    <button type="submit" class="btn btn-primary w-100"><i class="fa fa-search me-1"></i> Cari</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-8">
                        <div class="card" style="min-height: 480px;">
                            <div class="card-body">
                                <h4 class="card-title mb-3">Logs Riwayat Aktivitas</h4>

                                <ul class="nav nav-tabs nav-tabs-custom nav-justified" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active" data-bs-toggle="tab" href="#mutasi-saldo" role="tab">
                                            <span class="fw-bold"><i class="bx bx-wallet-quarter me-1"></i> Mutasi Dana (Top Up / WD)</span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" data-bs-toggle="tab" href="#pembayaran-nasabah" role="tab">
                                            <span class="fw-bold"><i class="bx bx-transfer-alt me-1"></i> Transaksi Antar Nasabah</span>
                                        </a>
                                    </li>
                                </ul>

                                <div class="tab-content p-3 text-muted">
                                    <div class="tab-pane active" id="mutasi-saldo" role="tabpanel">
                                        <div class="table-responsive" style="max-height: 320px; overflow-y: auto;" id="scrollMutasi">
                                            <table class="table table-hover table-nowrap mb-0 align-middle">
                                                <thead class="table-light sticky-top">
                                                    <tr>
                                                        <th>ID Mutasi</th>
                                                        <th>Jenis Aktivitas</th>
                                                        <th>Status</th>
                                                        <th>Waktu</th>
                                                        <th>Nominal</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @forelse($balances as $balance)
                                                        @php
                                                            $specificLog = $balance->logs->first();
                                                            $status = $specificLog->adjustment_status ?? 1;
                                                            $isTopUp = ($status === 1);
                                                        @endphp
                                                        <tr>
                                                            <td><span class="font-monospace fw-semibold">#{{ $balance->id }}</span></td>
                                                            <td><h6 class="mb-0 font-size-14 fw-bold text-dark">{{ $isTopUp ? 'Tambah Saldo (Top Up)' : 'Tarik Saldo (Withdraw)' }}</h6></td>
                                                            <td>
                                                                <span class="badge {{ $isTopUp ? 'bg-success-subtle text-success' : 'bg-danger-subtle text-danger' }} p-2">
                                                                    <i class="fas {{ $isTopUp ? 'fa-arrow-down' : 'fa-arrow-up' }} me-1"></i>{{ $isTopUp ? 'Dana Masuk' : 'Dana Keluar' }}
                                                                </span>
                                                            </td>
                                                            <td><small class="text-muted">{{ $balance->created_at->diffForHumans() }}</small></td>
                                                            <td><span class="fw-bold text-dark">Rp {{ number_format($balance->amount, 0, ',', '.') }}</span></td>
                                                        </tr>
                                                    @empty
                                                        <tr><td colspan="5" class="text-center py-4 text-muted">Belum ada riwayat mutasi dana.</td></tr>
                                                    @endforelse
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>

                                    <div class="tab-pane" id="pembayaran-nasabah" role="tabpanel">
                                        <div class="table-responsive" style="max-height: 320px; overflow-y: auto;" id="scrollPembayaran">
                                            <table class="table table-hover table-nowrap mb-0 align-middle">
                                                <thead class="table-light sticky-top">
                                                    <tr>
                                                        <th>Kode Transaksi</th>
                                                        <th>Pihak Terkait</th>
                                                        <th>Tipe Transfer</th>
                                                        <th>Keterangan</th>
                                                        <th>Waktu</th>
                                                        <th>Nominal</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @forelse($transactions as $transaction)
                                                        @php
                                                            $isSender = $transaction->sender_id === auth()->id();
                                                            $displayUser = $isSender ? $transaction->receiver : $transaction->sender;
                                                            $displayName = $displayUser->name ?? 'Sistem';
                                                        @endphp
                                                        <tr>
                                                            <td><span class="font-monospace fw-bold text-primary">{{ $transaction->transaction_code }}</span></td>
                                                            <td><h6 class="mb-0 font-size-14 text-dark">{{ $displayName }}</h6></td>
                                                            <td>
                                                                <span class="badge {{ $isSender ? 'bg-danger-subtle text-danger' : 'bg-success-subtle text-success' }} p-2">
                                                                    {{ $isSender ? 'Kirim Uang' : 'Menerima Uang' }}
                                                                </span>
                                                            </td>
                                                            <td><small class="text-secondary">{{ $transaction->description ?? '-' }}</small></td>
                                                            <td><small class="text-muted">{{ $transaction->created_at->translatedFormat('d F Y, H:i') }}</small></td>
                                                            <td>
                                                                <span class="fw-bold {{ $isSender ? 'text-danger' : 'text-success' }}">
                                                                    {{ $isSender ? '-' : '+' }} Rp {{ number_format($transaction->amount, 0, ',', '.') }}
                                                                </span>
                                                            </td>
                                                        </tr>
                                                    @empty
                                                        <tr><td colspan="6" class="text-center py-4 text-muted">Belum ada aktivitas transaksi antar nasabah.</td></tr>
                                                    @endforelse
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4">
                        <div class="card" style="min-height: 480px;">
                            <div class="card-body d-flex flex-column justify-content-between">
                                <div>
                                    <h4 class="card-title mb-2">Persentase Volume Finansial</h4>
                                    <p class="text-muted font-size-13">Perbandingan akumulasi volume dana mutasi saldo dengan transfer antar nasabah.</p>
                                </div>

                                <div class="my-4">
                                    <canvas id="pie" height="260" data-colors='["--bs-primary", "--bs-info"]'></canvas>
                                </div>

                                <div class="row text-center mt-2 font-size-12 fw-semibold text-muted">
                                    <div class="col-6 border-end">
                                        <p class="mb-1 text-truncate"><i class="bx bxs-circle text-primary me-1"></i> Total Mutasi</p>
                                        <h5 class="mb-0 font-size-14 text-dark">Rp {{ number_format($balances->sum('amount'), 0, ',', '.') }}</h5>
                                    </div>
                                    <div class="col-6">
                                        <p class="mb-1 text-truncate"><i class="bx bxs-circle text-info me-1"></i> Total Transaksi</p>
                                        <h5 class="mb-0 font-size-14 text-dark">Rp {{ number_format($transactions->sum('amount'), 0, ',', '.') }}</h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <style>
        #scrollMutasi, #scrollPembayaran {
            overflow-y: scroll !important;
            scrollbar-width: thin;
            scrollbar-color: rgba(0, 0, 0, 0.2) rgba(0, 0, 0, 0.03);
        }
        #scrollMutasi::-webkit-scrollbar, #scrollPembayaran::-webkit-scrollbar {
            width: 6px !important;
            display: block !important;
        }
        #scrollMutasi::-webkit-scrollbar-track, #scrollPembayaran::-webkit-scrollbar-track {
            background: rgba(0, 0, 0, 0.03) !important;
            border-radius: 10px !important;
        }
        #scrollMutasi::-webkit-scrollbar-thumb, #scrollPembayaran::-webkit-scrollbar-thumb {
            background-color: rgba(0, 0, 0, 0.2) !important;
            border-radius: 10px !important;
        }
        #scrollMutasi::-webkit-scrollbar-thumb:hover, #scrollPembayaran::-webkit-scrollbar-thumb:hover {
            background-color: rgba(0, 0, 0, 0.35) !important;
        }
    </style>
@endsection

@push('scripts')
    <script>
        function getChartColorsArray(r) {
            if (null !== document.getElementById(r)) {
                var o = document.getElementById(r).getAttribute("data-colors");
                if (o) return (o = JSON.parse(o)).map(function(r) {
                    var o = r.replace(" ", "");
                    if (-1 === o.indexOf(",")) {
                        var e = getComputedStyle(document.documentElement).getPropertyValue(o);
                        return e || o
                    }
                    var t = r.split(",");
                    return 2 != t.length ? o : "rgba(" + getComputedStyle(document.documentElement).getPropertyValue(t[0]) + "," + t[1] + ")"
                })
            }
        }

        Chart.defaults.borderColor = "rgba(133, 141, 152, 0.1)", Chart.defaults.color = "#858d98",
            function(p) {
                "use strict";
                function r() {}
                r.prototype.respChart = function(r, o, e, t) {
                    var a = r.get(0).getContext("2d"),
                        n = p(r).parent();

                    function l() {
                        r.attr("width", p(n).width());
                        if (o === "Pie") {
                            new Chart(a, {
                                type: "pie",
                                data: e,
                                options: t
                            });
                        }
                    }
                    p(window).resize(l), l()
                }, r.prototype.init = function() {
                    var a, n = getChartColorsArray("pie");
                    if (n) {
                        a = {
                            labels: ["Total Mutasi Saldo", "Total Transaksi Nasabah"],
                            datasets: [{
                                // Mengambil data penjumlahan nominal langsung dari laravel collection secara dinamis
                                data: [{{ $balances->sum('amount') }}, {{ $transactions->sum('amount') }}],
                                backgroundColor: n,
                                hoverBackgroundColor: n,
                                hoverBorderColor: "#fff"
                            }]
                        };
                        this.respChart(p("#pie"), "Pie", a, {
                            responsive: true,
                            maintainAspectRatio: false,
                            plugins: {
                                legend: {
                                    display: false // dimatikan karena diganti dengan legenda kustom di bagian bawah agar lebih rapi
                                }
                            }
                        });
                    }
                }, p.ChartJs = new r, p.ChartJs.Constructor = r
            }(window.jQuery),
            function() {
                "use strict";
                window.jQuery.ChartJs.init()
            }();
    </script>
@endpush
