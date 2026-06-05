<div class="dropdown d-inline-block">
    <button type="button" class="btn header-item waves-effect" id="page-header-user-dropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <img class="rounded-circle header-profile-user"
            src="{{ Auth::user()->profile_avatar_path ?? asset('img/users/default-img.png') }}"
            alt="Header Avatar"
            style="width: 32px; height: 32px; object-fit: cover;"
            onerror="this.onerror=null;this.src='{{ asset('img/users/default-img.png') }}';">

        <span class="d-none d-xl-inline-block ms-1" key="t-henry">{{ Auth::user()->name }}</span>
        <i class="mdi mdi-chevron-down d-none d-xl-inline-block"></i>
    </button>

    <div class="dropdown-menu dropdown-menu-end">
        <a class="dropdown-item" href="{{ route('portal::dashboard-msdm.index') }}">
            <i class="bx bxs-dashboard font-size-16 me-1 align-middle"></i>
            <span key="t-profile">Dashboard</span>
        </a>
        <a class="dropdown-item" href="{{ route('account::manage-profile.index') }}">
            <i class="bx bx-user font-size-16 me-1 align-middle"></i>
            <span key="t-profile">Profile</span>
        </a>
        <a class="dropdown-item text-danger" href="javascript:void(0)" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
            <i class="bx bx-power-off font-size-16 text-danger me-1 align-middle"></i>
            <span key="t-logout">Logout</span>
        </a>

        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            @csrf
        </form>
    </div>
</div>
