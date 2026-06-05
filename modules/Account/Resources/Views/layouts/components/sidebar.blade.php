<ul class="metismenu list-unstyled" id="side-menu">
    <li class="nav-main-item">
        <a class="nav-main-link {{ Route::is('account::account.dashboard') ? 'active' : '' }}" href="{{ route('account::account.dashboard') }}">
            <i class="nav-main-link-icon bx bxs-dashboard"></i>
            <span class="nav-main-link-name">Dashboard</span>
        </a>
    </li>

    <li class="menu-title" key="t-menu">Kelola</li>

    <li class="nav-main-item">
        <a class="nav-main-link {{ Route::is('account::manage-profile.*') ? 'active' : '' }}" href="{{ route('account::manage-profile.index') }}">
            <i class="nav-main-link-icon bx bx-user-circle"></i>
            <span class="nav-main-link-name">Profil</span>
        </a>
    </li>

    <li class="nav-main-item">
        <a class="nav-main-link {{ Route::is('account::manage-audit-log.*') ? 'active' : '' }}" href="{{ route('account::manage-audit-log.index') }}">
            <i class="nav-main-link-icon bx bx-run"></i>
            <span class="nav-main-link-name">Aktivitas</span>
        </a>
    </li>

    <li class="nav-main-item">
        <a class="nav-main-link {{ Route::is('account::manage-session.*') ? 'active' : '' }}" href="{{ route('account::manage-session.index') }}">
            <i class="nav-main-link-icon bx bx-log-out-circle"></i>
            <span class="nav-main-link-name">Login History</span>
        </a>
    </li>
</ul>
