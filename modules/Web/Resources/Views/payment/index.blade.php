<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment System</title>
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('favicon/apple-touch-icon.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicon/favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('favicon/favicon-16x16.png') }}">
    <link rel="manifest" href="{{ asset('favicon/site.webmanifest') }}">
    <meta name="theme-color" content="#ffffff">
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
    <link rel="stylesheet" href="https://unpkg.com/vue-select@3.20.2/dist/vue-select.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css" integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link class="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" />
</head>
<body class="bg-body-secondary min-vh-100 py-4">

    <div class="container bg-white p-0 shadow-sm border border-secondary border-opacity-10 rounded-3 overflow-hidden">

        <main class="w-100 m-0 p-0">
            <div class="bg-dark text-white p-4 pt-4 pb-4 shadow-sm border border-secondary border-opacity-25 position-relative">
                <div class="row align-items-center">
                    <div class="col-md-7">
                        <h1 class="h4 mb-1 fw-bold tracking-tight text-white">Sistem Pembayaran</h1>
                        <p class="text-white-50 small mb-0">Silakan pilih penerima atau masukkan lakukan mutasi.</p>
                    </div>

                    @if(auth()->check())
                        <div class="col-md-5 text-md-end mt-3 mt-md-0">
                            <div class="bg-secondary bg-opacity-10 p-2 px-3 rounded-3 border border-secondary border-opacity-50 d-inline-block text-start">
                                <span class="small text-white-50 d-block" style="font-size: 0.75rem; letter-spacing: 0.5px;">SALDO ANDA</span>
                                <span class="fw-bold text-warning fs-5" id="user-balance">{{ formatRupiah(auth()->user()->balance?->amount) }}</span>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <nav class="navbar navbar-expand-lg bg-white border-bottom border-secondary border-opacity-10 px-4 py-2 shadow-sm mb-4">
                <div class="container-fluid p-0">
                    <button class="navbar-toggler border-0 p-0 focus-ring" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon" style="width: 1.25rem; height: 1.25rem;"></span>
                    </button>

                    <div class="collapse navbar-collapse" id="navbarNav">
                        <ul class="navbar-nav gap-2 mt-2 mt-lg-0">
                            <li class="nav-item">
                                <a class="nav-link px-3 py-2 rounded-2 d-flex align-items-center gap-2
                                {{ (Route::is('web::payment.home-payment.index') || request()->is('/')) ? 'active bg-light text-dark fw-bold' : 'text-secondary fw-medium' }}"
                                href="{{ route('web::payment.home-payment.index') }}"
                                {!! (Route::is('web::payment.home-payment.index') || request()->is('/')) ? 'aria-current="page"' : '' !!}>
                                    <i class="fas fa-home"></i> Home
                                </a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link px-3 py-2 rounded-2 d-flex align-items-center gap-2
                                {{ Route::is('web::payment.transfer-payment.index') ? 'active bg-light text-dark fw-bold' : 'text-secondary fw-medium' }}"
                                href="{{ route('web::payment.transfer-payment.index') }}"
                                {!! Route::is('web::payment.transfer-payment.index') ? 'aria-current="page"' : '' !!}>
                                    <i class="fas fa-credit-card"></i> Pembayaran
                                </a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link px-3 py-2 rounded-2 d-flex align-items-center gap-2
                                {{ Route::is('web::payment.fund-payment.index') ? 'active bg-light text-dark fw-bold' : 'text-secondary fw-medium' }}"
                                href="{{ route('web::payment.fund-payment.index') }}"
                                {!! Route::is('web::payment.fund-payment.index') ? 'aria-current="page"' : '' !!}>
                                    <i class="fas fa-wallet"></i> Kelola Dana
                                </a>
                            </li>
                        </ul>

                        <ul class="navbar-nav ms-auto mt-2 mt-lg-0 align-items-lg-center gap-2">
                            @if(auth()->check() == false)
                                <li class="nav-item">
                                    <a class="nav-link px-3 py-2 rounded-2 fw-medium d-flex align-items-center gap-2 text-secondary" href="{{ route('login') }}">
                                        <i class="fas fa-sign-in-alt"></i> Login
                                    </a>
                                </li>
                            @else
                                <li class="nav-item">
                                    <a class="nav-link px-3 py-2 rounded-2 fw-medium d-flex align-items-center gap-2 text-danger"
                                    href="{{ route('logout') }}"
                                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                        <i class="fas fa-sign-out-alt"></i> Logout
                                    </a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </li>
                            @endif

                            @if(auth()->check() == true)
                                <li class="vr d-none d-lg-block mx-2 text-secondary opacity-25" style="height: 20px;"></li>

                                <li class="nav-item dropdown">
                                    <button class="btn btn-link text-dark text-decoration-none dropdown-toggle d-flex align-items-center gap-2 p-2 rounded-2 focus-ring" type="button" id="dropdownMenuProfile" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="fas fa-user-circle text-secondary fs-5"></i>
                                        <span class="fw-medium" style="font-size: 0.9rem; letter-spacing: 0.3px;">{{ auth()->user()->name }}</span>
                                    </button>

                                    <ul class="dropdown-menu dropdown-menu-light dropdown-menu-end shadow border border-secondary border-opacity-25" aria-labelledby="dropdownMenuProfile">
                                        <li>
                                            <a class="dropdown-item d-flex align-items-center gap-2" href="{{ route('portal::dashboard.index') }}">
                                                <i class="fas fa-tachometer-alt small text-muted"></i> Dashboard
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                            @endif
                        </ul>
                    </div>
                </div>
            </nav>

            <div class="px-4">
                @yield('content')
            </div>

            <footer class="mt-5 mx-4 pt-4 pb-4 text-center text-muted border-top border-secondary border-opacity-10">
                <small>&copy; {{ date('Y') }} Mini Payment. All rights reserved.</small>
                <small>Copyright <b>Agustinus Robert</b></small>
            </footer>
        </main>

    </div>


    <script src="https://cdn.jsdelivr.net/npm/vue@2.7.16"></script>
    <script src="https://unpkg.com/vue-select@3.20.2/dist/vue-select.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://unpkg.com/axios@1.13.2/dist/axios.min.js"></script>
    @include('web::payment.script')
</body>
</html>
