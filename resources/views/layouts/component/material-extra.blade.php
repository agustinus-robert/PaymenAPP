<style>
    /* 1. FAB BUTTONS */
    #sync-fab-main, #search-fab-main {
        position: fixed !important;
        right: 37px;
        z-index: 1050 !important;
        display: block !important;
    }

    #sync-fab-main { bottom: 100px; }
    #search-fab-main { bottom: 170px; }

    #sync-fab-main button, #search-fab-main button {
        width: 45px !important;
        height: 45px !important;
        border: none;
    }

    /* 2. SIDEBAR CUSTOM (SEARCH & SYNC) */
    #sidebar-sync-custom, #sidebar-search-custom {
        position: fixed;
        top: 0;
        right: -400px;
        width: 350px;
        height: 100%;
        background: #fff;
        z-index: 1100;
        transition: 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        box-shadow: -10px 0 25px rgba(0,0,0,0.07);
        padding: 20px;
        pointer-events: none; /* Klik tembus saat tertutup */
        visibility: hidden;
    }

    #sidebar-sync-custom.active, #sidebar-search-custom.active {
        right: 0;
        pointer-events: auto; /* Aktif klik saat terbuka */
        visibility: visible;
    }

    /* 3. ANIMATION & UTILS */
    .sync-spin { animation: spin 2s linear infinite; }
    @keyframes spin { 100% { transform: rotate(360deg); } }

    #sync-task-container {
        max-height: 70vh;
        overflow-y: auto;
    }

    /* 4. FIXED PLUGIN (SETTINGS) OVERRIDE */
    /* Menghilangkan backdrop hitam bawaan Material Dashboard */
    .fixed-plugin .card {
        right: -400px !important;
        transition: 0.3s ease;
        z-index: 1100;
    }
    .fixed-plugin.show .card {
        right: 0 !important;
    }
    .fixed-plugin-button ~ .card:before {
        display: none !important;
    }
</style>

<div id="search-fab-main">
    <button type="button" class="btn btn-dark rounded-circle shadow-lg d-flex align-items-center justify-content-center p-0"
            onclick="toggleSearchSidebar(true)">
        <i class="material-symbols-rounded fs-4">info</i>
    </button>
</div>

<div id="sidebar-search-custom" style="height: 100vh; display: flex; flex-direction: column;">
    <div class="d-flex justify-content-between align-items-center mb-4 p-3 pb-0">
        <h5 class="mb-0 text-dark">Pencarian & Informasi</h5>
        <button class="btn btn-link text-dark p-0" onclick="toggleSearchSidebar(false)">
            <i class="material-symbols-rounded">close</i>
        </button>
    </div>

    <div class="search-body p-3 pt-0" style="flex: 1; overflow-y: auto; scrollbar-width: thin;">
        <hr class="horizontal dark mt-0">
        <div class="additional-stack-container">
            @stack('additional-content')
        </div>

        <div id="search-results-placeholder" class="mt-4 pb-5">
            <p class="text-muted text-center small">Silahkan kelola data anda</p>
        </div>
    </div>
</div>

<style>
    #sidebar-search-custom .search-body::-webkit-scrollbar {
        width: 4px;
    }
    #sidebar-search-custom .search-body::-webkit-scrollbar-track {
        background: transparent;
    }
    #sidebar-search-custom .search-body::-webkit-scrollbar-thumb {
        background: #d6d6d6;
        border-radius: 10px;
    }
    #sidebar-search-custom .search-body::-webkit-scrollbar-thumb:hover {
        background: #b5b5b5;
    }

    .additional-stack-container {
        display: flex;
        flex-direction: column;
        gap: 1rem;
    }
</style>

<div id="sync-fab-main">
    <button type="button" class="btn btn-primary rounded-circle shadow-lg d-flex align-items-center justify-content-center p-0"
            onclick="toggleSyncSidebar(true)">
        <i class="material-symbols-rounded fs-4" id="sync-icon-status">sync</i>
    </button>
</div>

<div id="sidebar-sync-custom">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h5 class="mb-0 text-dark">Proses Sinkronisasi</h5>


        <button class="btn btn-link text-dark p-0" onclick="toggleSyncSidebar(false)">
            <i class="material-symbols-rounded">close</i>
        </button>
    </div>

    <hr class="horizontal dark my-3">

    <div id="sync-task-container">
    </div>
</div>

<div class="fixed-plugin">
    <a class="fixed-plugin-button text-dark position-fixed px-3 py-2">
      <i class="material-symbols-rounded py-2">settings</i>
    </a>
    <div class="card shadow-lg">
        <div class="card-header pb-0 pt-3 bg-transparent">
            <div class="float-start">
                <h5 class="mt-3 mb-0">Kelola Modul</h5>
                <p class="text-sm">Daftar modul tersedia</p>
            </div>
            <div class="float-end mt-4">
                <button class="btn btn-link text-dark p-0 fixed-plugin-close-button">
                    <i class="material-symbols-rounded">clear</i>
                </button>
            </div>
        </div>
        <hr class="horizontal dark my-1 mb-3">
        <div class="card-body pt-0">
            <div class="row g-2 text-center">
                @php
                    $moduls = [
                        ['route' => 'portal::dashboard.index', 'icon' => 'local_convenience_store', 'label' => 'Point Of Sale'],
                    ];
                @endphp
                @foreach($moduls as $m)
                <div class="col-4">
                    <a href="{{ route($m['route']) }}" class="d-flex flex-column align-items-center justify-content-center bg-light rounded p-3 border border-radius-md mb-2">
                        <span class="material-symbols-rounded fs-4 mb-1">{{ $m['icon'] }}</span>
                        <span style="font-size:11px;">{{ $m['label'] }}</span>
                    </a>
                </div>
                @endforeach
            </div>
            <hr class="horizontal dark my-3">
            <a href="{{ route('account::user.profile') }}" class="btn bg-gradient-info w-100 mb-2">
                <i class="material-symbols-rounded text-sm me-2">account_circle</i> Profil
            </a>
            <a href="javascript:void(0)" onclick="signout();" class="btn bg-gradient-primary w-100">
                <i class="material-symbols-rounded text-sm me-2">logout</i> Keluar
            </a>
        </div>
    </div>
</div>

<script src="{{ asset('material/js/core/popper.min.js') }}"></script>
<script src="{{ asset('material/js/core/bootstrap.min.js') }}"></script>
<script src="{{ asset('material/js/plugins/perfect-scrollbar.min.js')}}"></script>
<script src="{{ asset('material/js/material-dashboard.js')}}"></script>

<script>
    function toggleSearchSidebar(show) {
        const sidebar = $('#sidebar-search-custom');
        show ? sidebar.addClass('active') : sidebar.removeClass('active');
        if(show) setTimeout(() => $('#input-search-sidebar').focus(), 300);
    }

    function toggleSyncSidebar(show) {
        const sidebar = $('#sidebar-sync-custom');
        const icon = $('#sync-icon-status');
        if (show) {
            sidebar.addClass('active');
            icon.addClass('sync-spin');
        } else {
            sidebar.removeClass('active');
            if ($('.progress-bar-animated').length === 0) icon.removeClass('sync-spin');
        }
    }

    const signout = () => {
        if (confirm('Apakah Anda yakin ingin keluar?')) {
            document.getElementById('signout-form').submit();
        }
    }

    // Handle close manual untuk fixed plugin bawaan material
    $(document).ready(function() {
        $('.fixed-plugin-close-button').click(function() {
            $('.fixed-plugin').removeClass('show');
        });
        $('.fixed-plugin-button').click(function() {
            $('.fixed-plugin').addClass('show');
        });
    });
</script>

<form id="signout-form" action="{{ route(config('modules.auth.signout.route')) }}" method="POST" style="display: none;"> @csrf </form>
