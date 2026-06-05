<div class="topnav">
    <div class="container-fluid">
        <nav class="navbar navbar-light navbar-expand-lg topnav-menu">
            <div class="navbar-collapse collapse" id="topnav-menu-content">
                <ul class="navbar-nav">

                    <li class="nav-item">
                        <a class="nav-link arrow-none {{ request()->routeIs('portal::dashboard-msdm.index') ? 'active' : '' }}"
                           href="{{ route('portal::dashboard-msdm.index') }}" id="topnav-uielement" role="button">
                            <i class=" bx bxs-dashboard me-2"></i>
                            <span key="t-ui-elements"> Dashboard</span>
                        </a>
                    </li>

                </ul>
            </div>
        </nav>
    </div>
</div>
