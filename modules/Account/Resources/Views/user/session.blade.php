@extends('account::layouts.default')

@section('title', 'Riwayat Login | ')

@section('content')
<div class="container-fluid">
    <div class="mb-4">
        <h4 class="font-weight-bold text-dark">Sesi Login & Riwayat Aktif</h4>
        <p class="text-muted small">Daftar perangkat yang saat ini mengakses akun Anda.</p>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light small font-weight-bold text-muted text-uppercase">
                        <tr>
                            <th class="px-4 py-3 border-0">Perangkat / Browser</th>
                            <th class="py-3 border-0">IP Address</th>
                            <th class="py-3 border-0">User</th>
                            <th class="py-3 border-0 text-center">Status</th>
                            <th class="py-3 border-0 text-right px-4">Aktivitas Terakhir</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($sessions as $session)
                        <tr>
                            <td class="px-4 py-3">
                                <div class="d-flex align-items-center">
                                    <div class="text-primary d-flex align-items-center justify-content-center"
                                        style="min-width: 45px; margin-right: 15px;">
                                        @if(Str::contains($session->user_agent, ['iPhone', 'Android']))
                                            <i class="fas fa-mobile-alt fa-2x"></i>
                                        @else
                                            <i class="fas fa-desktop fa-2x"></i>
                                        @endif
                                    </div>

                                    <div style="flex: 1; min-width: 0;">
                                        <span class="small font-weight-bold d-block text-dark">
                                            @if(Str::contains($session->user_agent, 'Firefox')) Firefox
                                            @elseif(Str::contains($session->user_agent, 'Chrome')) Chrome
                                            @elseif(Str::contains($session->user_agent, 'Safari')) Safari
                                            @else Browser Lain @endif
                                        </span>
                                        <small class="text-muted d-block" style="max-width: 250px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
                                            {{ $session->user_agent }}
                                        </small>
                                    </div>
                                </div>
                            </td>
                            <td class="py-3">
                                <span class="badge badge-light border text-dark">{{ $session->ip_address }}</span>
                            </td>
                            <td class="py-3">
                                <span class="font-weight-bold small">{{ $session->user->name ?? 'Guest' }}</span>
                                <small class="d-block text-muted">ID: {{ $session->user_id }}</small>
                            </td>
                            <td class="py-3 text-center">
                                @if($session->id === session()->getId())
                                    <span class="badge badge-success px-3 py-2">Sesi Ini</span>
                                @else
                                    <span class="badge badge-secondary px-3 py-2">Aktif</span>
                                @endif
                            </td>
                            <td class="py-3 text-right px-4 small">
                                <span class="d-block font-weight-bold text-dark">
                                    {{ date('d M Y', $session->last_activity) }}
                                </span>
                                <span class="text-muted">{{ date('H:i:s', $session->last_activity) }}</span>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-5 text-muted">Tidak ada sesi aktif yang ditemukan.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer bg-white border-0 py-3 d-flex justify-content-between">
             <span class="small text-muted italic">Menampilkan sesi yang tersimpan di database.</span>
             {{ $sessions->links() }}
        </div>
    </div>
</div>
@endsection
