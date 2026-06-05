@php
    $user = request()->user();
@endphp

<div class="dropdown d-inline-block">
    <button type="button" class="btn header-item noti-icon waves-effect" id="page-header-notifications-dropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <i class="bx bx-bell bx-tada"></i>
        <span id="notif-count-data"
      class="js-notif-badge badge bg-danger rounded-pill {{ $user->notifications->whereNull('read_at')->count() == 0 ? 'd-none' : '' }}">
    {{ $user->notifications->whereNull('read_at')->count() }}
</span>
    </button>

    <div id="nav-dropdown-notifications" class="dropdown-menu dropdown-menu-end position-absolute rounded border-0 pt-0 shadow-sm" style="min-width: 350px">
        <div class="p-3">
            <div class="row align-items-center">
                <div class="col">
                    <h6 class="m-0" key="t-notifications"> Notifications </h6>
                </div>
                <div class="col-auto">
                    @if ($user->notifications->whereNull('read_at')->count())

                        <a href="{{ route('account::notifications.read-all', ['next' => url()->full()]) }}" class="float-end font-weight-normal text-muted">T<span class="text-lowercase">andai semua telah dibaca</span></a>
                     @endif
                </div>
            </div>
        </div>

        <div id="notification-list">
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
        </div>

        <div class="dropdown-divider my-0"></div>
        <div class="p-2 border-top d-grid">
            <a class="btn btn-sm btn-link font-size-14 text-center" href="{{ route('account::notifications', ['next' => url()->full()]) }}">
                <i class="mdi mdi-arrow-right-circle me-1"></i> <span key="t-view-more">Lihat Semua..</span>
            </a>
        </div>
    </div>
</div>
