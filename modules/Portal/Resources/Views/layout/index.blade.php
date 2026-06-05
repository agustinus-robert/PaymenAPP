<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1.0">
    <title>Dashboard Page</title>
    @include('layouts.component.skote-style')
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@chgibb/css-spinners@2.2.1/css/spinners.min.css">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    @stack('style')
</head>

<body class="g-sidenav-show bg-gray-100" data-topbar="dark" data-layout="horizontal">

    <div id="layout-wrapper">
         <header id="page-topbar">
            <div class="navbar-header d-flex justify-content-between align-items-center position-relative">

               <div class="d-flex align-items-center">
                    <div class="navbar-brand-box">
                        <a href="javascript:void(0)" class="logo logo-dark text-decoration-none">
                            <span class="logo-sm">
                                <i class="fa fa-wallet text-dark font-size-22"></i>
                            </span>
                            <span class="logo-lg">
                                <div class="d-flex align-items-center gap-2" style="height: 70px;">
                                    <i class="fa fa-wallet text-dark font-size-20"></i>
                                    <span class="fw-bold text-dark font-size-18 text-uppercase tracking-wider">Payment</span>
                                </div>
                            </span>
                        </a>

                        <a href="#" class="logo logo-light text-decoration-none">
                            <span class="logo-sm">
                                <i class="fa fa-wallet text-white font-size-22"></i>
                            </span>
                            <span class="logo-lg">
                                <div class="d-flex align-items-center gap-2" style="height: 70px;">
                                    <i class="fa fa-wallet text-white font-size-20"></i>
                                    <span class="fw-bold text-white font-size-18 text-uppercase tracking-wider">Payment</span>
                                </div>
                            </span>
                        </a>
                    </div>

                    <button type="button" class="btn btn-sm font-size-16 d-lg-none header-item waves-effect waves-light px-3" data-bs-toggle="collapse" data-bs-target="#topnav-menu-content">
                        <i class="fa fa-fw fa-bars"></i>
                    </button>
                </div>

                <div class="position-absolute start-50 translate-middle-x">
                    <a href="{{ url('/') }}" class="btn btn-light rounded-pill px-3 py-1.5 d-flex align-items-center gap-2 shadow-sm border border-secondary border-opacity-10 header-item waves-effect" style="height: auto; margin: auto;">
                        <i class="fa fa-globe text-primary font-size-16"></i>
                        <span class="fw-semibold font-size-13 text-dark d-none d-sm-inline">Ke Halaman Depan</span>
                    </a>
                </div>

                <div class="d-flex align-items-center">
                    <div class="dropdown d-inline-block">
                       <button type="button" class="btn header-item waves-effect d-flex align-items-center gap-2" id="page-header-user-dropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <div class="bg-secondary bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center text-secondary" style="width: 36px; height: 36px;">
                                <i class="fa fa-user font-size-16"></i>
                            </div>

                            <span class="d-none d-xl-inline-block ms-1" key="t-henry">{{ auth()->user()->name ?? 'User' }}</span>
                            <i class="mdi mdi-chevron-down d-none d-xl-inline-block ms-1"></i>
                        </button>
                        <div class="dropdown-menu dropdown-menu-end">
                            <a class="dropdown-item text-secondary" href="{{ url('/') }}">
                                <i class="bx bx-home-circle font-size-16 align-middle me-1"></i>
                                <span key="t-frontend">Kembali ke Halaman depan</span>
                            </a>

                            <div class="dropdown-divider"></div>

                            <a class="dropdown-item text-danger" href="javascript:void(0);" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                <i class="bx bx-power-off font-size-16 align-middle me-1 text-danger"></i>
                                <span key="t-logout">Logout</span>
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </div>
                    </div>
                </div>

            </div>
        </header>

        @yield('contents')
    </div>

    @include('layouts.component.skote-extra')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.js"></script>
    @stack('scripts')
</body>

</html>
