<ul class="nav flex-lg-column mb-3 pb-3" style="flex-wrap: nowrap; overflow-x: auto;">
    <li class="nav-item">
        <a style="white-space: nowrap;" class="nav-link text-dark @if (Route::is('account::user.profile')) active bg-light rounded fw-bold @endif" href="{{ route('account::user.profile', ['next' => request('next')]) }}"><i class="mdi mdi-pencil-outline d-none d-lg-inline"></i> Ubah profil</a>
    </li>
    <li class="nav-item">
        <a style="white-space: nowrap;" class="nav-link text-dark @if (Route::is('account::user.avatar')) active bg-light rounded fw-bold @endif" href="{{ route('account::user.avatar', ['next' => request('next')]) }}"><i class="mdi mdi-pencil-outline d-none d-lg-inline"></i> Ubah foto profil</a>
    </li>
    <li class="nav-item">
        <a style="white-space: nowrap;" class="nav-link text-dark @if (Route::is('account::user.email')) active bg-light rounded fw-bold @endif" href="{{ route('account::user.email', ['next' => request('next')]) }}"><i class="mdi mdi-pencil-outline d-none d-lg-inline"></i> Ubah alamat surel</a>
    </li>
    <li class="nav-item">
        <a style="white-space: nowrap;" class="nav-link text-dark @if (Route::is('account::user.phone')) active bg-light rounded fw-bold @endif" href="{{ route('account::user.phone', ['next' => request('next')]) }}"><i class="mdi mdi-pencil-outline d-none d-lg-inline"></i> Ubah nomor ponsel</a>
    </li>
    {{-- <li class="nav-item">
        <a style="white-space: nowrap;" class="nav-link text-dark @if (Route::is('account::user.skype')) active bg-light rounded fw-bold @endif" href="{{ route('account::user.skype', ['next' => request('next')]) }}"><i class="mdi mdi-pencil-outline d-none d-lg-inline"></i> Ubah skype</a>
    </li> --}}
    {{-- <li class="nav-item">
        <a style="white-space: nowrap;" class="nav-link text-dark @if (Route::is('account::user.address')) active bg-light rounded fw-bold @endif" href="{{ route('account::user.address', ['next' => request('next')]) }}"><i class="mdi mdi-pencil-outline d-none d-lg-inline"></i> Ubah alamat</a>
    </li> --}}
    <hr class="d-none d-lg-block mx-3">
    {{-- <li class="nav-item">
        <a style="white-space: nowrap;" class="nav-link text-dark @if (Route::is('account::user.username')) active bg-light rounded fw-bold @endif" href="{{ route('account::user.username', ['next' => request('next')]) }}"><i class="mdi mdi-pencil-outline d-none d-lg-inline"></i> Ubah username</a>
    </li> --}}
    <li class="nav-item">
        <a style="white-space: nowrap;" class="nav-link text-dark @if (Route::is('account::user.password')) active bg-light rounded fw-bold @endif" href="{{ route('account::user.password', ['next' => request('next')]) }}"><i class="mdi mdi-pencil-outline d-none d-lg-inline"></i> Ubah sandi</a>
    </li>
</ul>
