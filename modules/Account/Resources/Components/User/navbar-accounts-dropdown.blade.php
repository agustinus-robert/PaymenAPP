<div class="dropdown-menu dropdown-menu-end position-absolute rounded border-0 shadow-sm" style="min-width: 180px;">
    @if ($user = request()->user())
        <div class="dropdown-header bg-light mt-n2 rounded-top py-2">
            <span class="d-inline-block text-truncate" style="max-width: 200px;">{{ $user->name }}</span>
        </div>
    @endif
    <a class="dropdown-item py-2" href="{{ route('account::manage-profile.index') }}"><i class="mdi mdi-account-outline"></i> My profile</a>
    <a class="dropdown-item py-2" href="{{ route('account::user.password', ['next' => url()->full()]) }}"><i class="mdi mdi-lock-open-outline"></i> Change password</a>
    <div class="dropdown-divider"></div>
    <a class="dropdown-item text-danger py-2" href="javascript:;" onclick="signout()">Sign out</a>
</div>
