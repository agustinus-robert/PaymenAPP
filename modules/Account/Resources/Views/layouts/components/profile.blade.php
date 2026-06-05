@php($img = !is_null(Auth::user()->getMeta('profile_avatar')) && Storage::disk('public')->exists(Auth::user()->getMeta('profile_avatar')) ? Storage::disk('public')->url(Auth::user()->getMeta('profile_avatar')) : 'https://pbs.twimg.com/media/FjU2lkcWYAgNG6d.jpg')
<div class="card card-body p-lg-4 border text-center">
    <div class="mb-4">
        <div class="rounded-circle mx-auto mb-2" style="width: 128px; height: 128px; background: url('{{ $img }}') center center no-repeat; background-size: cover;"></div>
        <h4>{{ $user->name }}</h4>
        <div class="text-muted">{{ $user->email_address }}</div>
    </div>
    <a class="btn btn-primary mx-auto px-4" href="{{ route('account::user.profile') }}">Lengkapi</a>
</div>
<div class="card card-body p-lg-4 border">
    <div class="mb-4">
        <h6 class="fw-bold mb-1">Bio</h6>
        <div>{{ $user->getMeta('bio', 'Kamu belum punya bio') }}</div>
    </div>
    <div class="mb-4">
        <h6 class="fw-bold mb-1">Kontak</h6>
        <div class="mb-2">
            <div class="text-muted">Email</div>
            <div>{{ $user->email_address ?: '-' }}</div>
        </div>
        <div class="mb-2">
            <div class="text-muted">WA</div>
            <div>{{ $user->getMeta('phone_number', '-') }}</div>
        </div>
    </div>
    <div class="mb-4">
        <h6 class="fw-bold mb-1">Sosial media</h6>
        <div>
            <a class="text-muted me-2" href=""><span class="mdi mdi-gmail mdi-18px"></span></a>
            <a class="text-muted me-2" href=""><span class="mdi mdi-skype mdi-18px"></span></a>
            <a class="text-muted me-2" href=""><span class="mdi mdi-whatsapp mdi-18px"></span></a>
        </div>
    </div>
</div>
<div class="card card-body p-lg-4 border">
    <h6 class="fw-bold mb-4">Informasi otentikasi</h6>
    <p><strong>Peramban</strong> <br> <span>{{ request()->server('HTTP_USER_AGENT') }}</span></p>
    <p><strong>IP Anda</strong> <br> <span>{{ getClientIp() }}</span></p>
</div>
