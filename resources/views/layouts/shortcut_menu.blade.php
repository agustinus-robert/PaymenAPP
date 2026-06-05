<div class="d-none d-lg-flex align-items-center ms-2">
    @if(session()->has('impersonate_admin_id'))
        <a href="{{ route('core::manage-user.leave') }}" class="btn btn-warning btn-sm rounded-pill d-flex align-items-center px-3 me-2" style="height: 34px; border-width: 1.5px; font-weight: 600;" title="Keluar dari Penyamaran">
            <i class="bx bx-log-out-circle font-size-16 me-2"></i>
            <span class="d-none d-xl-inline-block">Kembali Ke Administrator</span>
        </a>
    @endif

    <a href="{{ url('/') }}" class="btn btn-primary btn-sm rounded-pill d-flex align-items-center px-3" style="height: 34px; border-width: 1.5px;" title="Lihat Website">
        <i class="bx bx-globe font-size-16 me-2"></i>
        <span class="d-none d-xl-inline-block fw-medium">Ke Website Utama</span>
    </a>

    <div class="ms-3 me-2 border-start" style="height: 24px; border-color: rgba(0,0,0,0.1) !important; opacity: 0.5;"></div>
</div>

@include('portal::layouts.components.notifications')

@push('styles')
<style>
    /* Paksa warna biru saat item active */
    .dropdown-icon-item.active {
        background-color: #6a80ee; /* Biru sangat muda untuk background */
        border-radius: 8px;
    }
    .dropdown-icon-item.active i,
    .dropdown-icon-item.active span {
        color: white !important; /* Warna biru utama */
    }
</style>
@endpush

<div class="dropdown d-none d-lg-inline-block ms-1">
    <button type="button" class="btn header-item noti-icon waves-effect" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <i class="bx bx-customize"></i>
    </button>
    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end">
        <div class="px-lg-2">
            <div class="row g-0">
                {{-- Dashboard --}}
                <div class="col-md-4">
                    <a class="dropdown-icon-item {{ str_contains(Route::currentRouteName(), 'portal::dashboard-msdm') ? 'active' : '' }}" href="{{ route('portal::dashboard-msdm.index') }}">
                        <i class="bx bxs-dashboard" style='font-size:30px;'></i>
                        <span>Dashboard</span>
                    </a>
                </div>

                {{-- Kepegawaian/HRMS --}}
                <div class="col-md-4">
                    <a class="dropdown-icon-item {{ str_contains(Route::currentRouteName(), 'hrms::') ? 'active' : '' }}" href="{{ route('hrms::dashboard') }}">
                        <i class="bx bx-briefcase" style='font-size:30px;'></i>
                        <span>Kepegawaian</span>
                    </a>
                </div>

                {{-- Akuntansi --}}
                <div class="col-md-4">
                    <a class="dropdown-icon-item {{ str_contains(Route::currentRouteName(), 'acc::dashboard') ? 'active' : '' }}" href="{{ route('acc::dashboard') }}">
                        <i class="bx bx-calculator" style='font-size:30px;'></i>
                        <span>Akuntansi</span>
                    </a>
                </div>

                {{-- Keuangan/Finance --}}
                <div class="col-md-4">
                    <a class="dropdown-icon-item {{ str_contains(Route::currentRouteName(), 'finance::') ? 'active' : '' }}" href="{{ route('finance::dashboard') }}">
                        <i class="bx bx-money" style='font-size:30px;'></i>
                        <span>Keuangan</span>
                    </a>
                </div>

                <div class="col-md-4">
                    <a class="dropdown-icon-item {{ str_contains(Route::currentRouteName(), 'core::') ? 'active' : '' }}" href="{{ route('core::dashboard') }}">
                        <i class="bx bxs-cog" style='font-size:30px;'></i>
                        <span>Referensi</span>
                    </a>
                </div>

                <div class="col-md-4">
                    <a class="dropdown-icon-item {{ str_contains(Route::currentRouteName(), 'account::') ? 'active' : '' }}" href="{{ route('account::account.dashboard') }}">
                        <i class="bx bxs-user-circle" style='font-size:30px;'></i>
                        <span>Akun</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
