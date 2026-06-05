<div id="nav-dropdown-apps" class="dropdown-menu dropdown-menu-end position-absolute rounded border-0 p-1 shadow" style="width: 360px;">
    <div class="p-3" style="max-height: 360px; overflow-y: auto;">
        <div class="row justify-content-center gx-1 gy-1">
            <div class="col-4">
                <a class="btn btn-ghost-light text-dark w-100" href="{{ config('app.url') }}">
                    <div class="mt-2" style="height: 46px;">
                        <img src="{{ asset('img/logo/logo-icon.svg') }}" style="height: 36px;" alt="">
                    </div>
                    <div class="d-block text-dark">Beranda</div>
                </a>
            </div>
            <div class="col-4">
                <a class="btn btn-ghost-light text-dark w-100" href="{{ route('account::index') }}">
                    <i class="mdi mdi-account-circle-outline mdi-36px"></i>
                    <div class="d-block text-dark">Akun</div>
                </a>
            </div>
            <div class="col-4">
                <a class="btn btn-ghost-light text-dark w-100" href="{{ route('portal::home') }}">
                    <i class="mdi mdi-account-convert-outline mdi-36px"></i>
                    <div class="d-block text-dark">Portal</div>
                </a>
            </div>
            <div class="col-4">
                <a class="btn btn-ghost-light text-dark w-100" href="{{ route('docs::home') }}">
                    <i class="mdi mdi-file-document-outline mdi-36px"></i>
                    <div class="d-block text-dark">Dokumen</div>
                </a>
            </div>
            @can('core::access')
                <div class="col-4">
                    <a class="btn btn-ghost-light text-dark w-100" href="{{ route('core::dashboard') }}">
                        <i class="mdi mdi-shield-star-outline mdi-36px"></i>
                        <div class="d-block text-dark">Core</div>
                    </a>
                </div>
            @endcan
            @can('hrms::access')
                <div class="col-4">
                    <a class="btn btn-ghost-light text-dark w-100" href="{{ route('hrms::dashboard') }}">
                        <i class="mdi mdi-account-group-outline mdi-36px"></i>
                        <div class="d-block text-dark">SDM</div>
                    </a>
                </div>
            @endcan
            @can('finance::access')
                <div class="col-4">
                    <a class="btn btn-ghost-light text-dark w-100" href="{{ route('finance::index') }}">
                        <i class="mdi mdi-cash mdi-36px"></i>
                        <div class="d-block text-dark">Finance</div>
                    </a>
                </div>
            @endcan
            {{-- @can('administration::access') --}}
            <div class="col-4">
                <a class="btn btn-ghost-light text-dark w-100" href="{{ route('administration::index') }}">
                    <i class="mdi mdi-cast-education mdi-36px"></i>
                    <div class="d-block text-dark">Pengajaran</div>
                </a>
            </div>
            {{-- @endcan --}}
            <div class="col-4">
                <a class="btn btn-ghost-light text-dark w-100" href="{{ route('support::index') }}">
                    <i class="mdi mdi-headset mdi-36px"></i>
                    <div class="d-block text-dark">Dukungan</div>
                </a>
            </div>
        </div>
    </div>
</div>
