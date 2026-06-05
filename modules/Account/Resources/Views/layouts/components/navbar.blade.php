<nav class="navbar navbar-expand-sm navbar-light bg-white" style="height: 80px;">
    <div class="container-lg">
        @if ($sidebar ?? true)
            <button class="btn me-md-3 bg-light rounded-circle d-block me-2" type="button" onclick="openNav()">
                <i class="mdi mdi-menu" style="font-size: 20px;"></i>
            </button>
        @endif
        <a class="navbar-brand d-flex" href="{{ config('app.url') }}">
            <img src="{{ asset('img/logo/logo-text.svg') }}" height="24" class="me-2">
            <div class="d-none d-sm-block"><small class="text-muted">{{ config('app.name') }}</small></div>
        </a>
        <ul class="navbar-nav align-items-center ms-auto flex-row">
            <li class="nav-item dropdown">
                <a class="nav-link mx-md-2 mx-1 px-2" href="javascript:;" role="button" data-bs-toggle="dropdown">
                    <i class="mdi mdi-apps" style="font-size: 20px;"></i>
                </a>
                @include('components.apps')
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link relative mx-1" href="javascript:;" role="button" data-bs-toggle="dropdown">
                    @if (Auth::user()->notifications->whereNull('read_at')->count())
                        <span class="bg-danger rounded-circle pulse-danger ms-n6 float-end text-white" style="height: 8px; width: 8px;"></span>
                    @endif
                    <div class="rounded-circle d-flex align-items-center justify-content-center bg-light" style="width: 36px; height: 36px;">
                        <i class="mdi mdi-bell-outline" style="font-size: 20px;"></i>
                    </div>
                </a>
                @include('x-account::User.navbar-notifications-dropdown', ['user' => Auth::user()])
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link relative mx-1" href="javascript:;" role="button" data-bs-toggle="dropdown">
                    <div class="rounded-circle d-flex align-items-center justify-content-center bg-light" style="width: 36px; height: 36px;">
                        <i class="mdi mdi-account-outline" style="font-size: 20px;"></i>
                    </div>
                </a>
                @include('x-account::User.navbar-accounts-dropdown')
            </li>
        </ul>
    </div>
</nav>
