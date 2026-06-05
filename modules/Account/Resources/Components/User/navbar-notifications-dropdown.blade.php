<div id="nav-dropdown-notifications" class="dropdown-menu dropdown-menu-end position-absolute rounded border-0 pt-0 shadow-sm" style="min-width: 350px">
    <div class="dropdown-header bg-light rounded-top">
        Notifications ({{ $user->notifications->whereNull('read_at')->count() }})
        @if ($user->notifications->whereNull('read_at')->count())
            <a href="{{ route('account::notifications.read-all', ['next' => url()->full()]) }}" class="float-end font-weight-normal text-muted">M<span class="text-lowercase">ark all as read</span></a>
        @endif
    </div>
    @forelse($user->notifications->take(4) as $notification)
        <a class="dropdown-item d-flex align-items-center @if (!$notification->read_at) bg-light @else bg-white @endif py-3" href="{{ isset($notification->data['link']) ? route('account::notifications.read', ['id' => $notification->id, 'next' => $notification->data['link'] ?? url()->full()]) : 'javascript:;' }}">
            <div class="me-3">
                @if (!$notification->read_at)
                    <span class="float-end ms-n3 bg-danger pulse-danger rounded-circle border" style="width: 12px; height: 12px;"></span>
                @endif
                <div class="rounded-circle d-flex align-items-center justify-content-center bg-{{ $notification->data['color'] ?? 'primary' }}" style="width: 2.5rem; height: 2.5rem;">
                    <i class="{{ $notification->data['icon'] ?? 'mdi mdi-bell-outline' }} m-0 text-white"></i>
                </div>
            </div>
            <div>
                <div class="text-wrap">{!! Str::words($notification->data['message'], 6) !!}</div>
                <div class="small text-muted">
                    {{ optional($notification->created_at)->diffForHumans() }}
                    @isset($notification->data['link'])
                        <i class="mdi mdi-link mdi-rotate-45 float-end"></i>
                    @endisset
                </div>
            </div>
        </a>
    @empty
        <div class="dropdown-item py-2">
            Tidak ada notifikasi
        </div>
    @endforelse
    <div class="dropdown-divider my-0"></div>
    <a class="dropdown-item text-muted bg-white" href="{{ route('account::notifications', ['next' => url()->full()]) }}">See all <i class="mdi mdi-chevron-right-circle-outline float-end"></i></a>
</div>
