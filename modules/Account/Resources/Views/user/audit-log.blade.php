@extends('account::layouts.default')

@section('title', 'Log Aktivitas | ')

@section('content')
<div class="container-fluid">
    <div class="mb-4 d-flex align-items-center justify-content-between">
        <div>
            <h4 class="font-weight-bold text-dark">Log Aktivitas {{ $isAdmin ? 'Sistem' : 'Saya' }}</h4>
            <p class="text-muted small mb-0">Menampilkan rekaman audit untuk keamanan dan transparansi data.</p>
        </div>
    </div>

    <div class="card shadow-sm border-0 mb-4">
        <div class="card-body">
            <form action="{{ route('account::manage-audit-log.index') }}" method="GET" class="row align-items-end">

                @if($isAdmin)
                <div class="col-md-4">
                    <label class="small font-weight-bold text-muted text-uppercase">Pilih Pengguna</label>
                    <select name="user_id" class="form-control">
                        <option value="">Semua Pengguna</option>
                        @foreach($users as $u)
                            <option value="{{ $u->id }}" {{ request('user_id') == $u->id ? 'selected' : '' }}>
                                {{ strtoupper($u->name) }}
                            </option>
                        @endforeach
                    </select>
                </div>
                @endif

                <div class="col-md-3">
                    <label class="small font-weight-bold text-muted text-uppercase">Filter Event</label>
                    <select name="event" class="form-control">
                        <option value="">Semua Event</option>
                        <option value="created" {{ request('event') == 'created' ? 'selected' : '' }}>Created</option>
                        <option value="updated" {{ request('event') == 'updated' ? 'selected' : '' }}>Updated</option>
                        <option value="deleted" {{ request('event') == 'deleted' ? 'selected' : '' }}>Deleted</option>
                    </select>
                </div>

                <div class="col-md-4">
                    <button type="submit" class="btn btn-primary px-4 shadow-sm font-weight-bold">
                        <i class="fas fa-filter mr-2"></i> Terapkan Filter
                    </button>
                    @if(request()->anyFilled(['user_id', 'event']))
                        <a href="{{ route('account::manage-audit-log.index') }}" class="btn btn-light border px-4 ml-2">Reset</a>
                    @endif
                </div>
            </form>
        </div>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light small font-weight-bold text-muted text-uppercase">
                        <tr>
                            <th class="px-4 py-3 border-0">Waktu</th>
                            <th class="py-3 border-0">Event</th>
                            <th class="py-3 border-0">Deskripsi</th>
                            <th class="py-3 border-0">Model</th>
                            <th class="py-3 border-0">User</th>
                            <th class="py-3 border-0">IP Address</th>
                            <th class="px-4 py-3 border-0 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($logs as $log)
                        <tr>
                            <td class="px-4 py-3 small">
                                <span class="d-block font-weight-bold">{{ $log->created_at->format('d M Y') }}</span>
                                <span class="text-muted">{{ $log->created_at->format('H:i:s') }}</span>
                            </td>
                            <td class="py-3">
                                @php
                                    $badge = match($log->event) {
                                        'created' => 'badge-success',
                                        'updated' => 'badge-info',
                                        'deleted' => 'badge-danger',
                                        default   => 'badge-secondary'
                                    };
                                @endphp
                                <span class="badge {{ $badge }} text-uppercase px-2 py-1" style="font-size: 10px;">{{ $log->event }}</span>
                            </td>
                            <td class="py-3">
                                <span class="small font-weight-bold d-block text-dark">{{ $log->description }}</span>
                                <small class="text-muted italic">{{ Str::limit($log->url, 35) }}</small>
                            </td>
                            <td class="py-3">
                                <code class="small text-primary font-weight-bold">{{ class_basename($log->auditable_type) }}</code>
                                <span class="text-muted small d-block">ID: #{{ $log->auditable_id }}</span>
                            </td>
                            <td class="py-3">
                                <span class="font-weight-bold small text-dark d-block">
                                    {{ $log->user->name ?? 'SYSTEM' }}
                                </span>
                                <small class="text-muted">ID: {{ $log->user_id }}</small>
                            </td>
                            <td class="py-3 small text-muted">{{ $log->ip_address }}</td>
                            <td class="px-4 py-3 text-right">
                                <button type="button" class="btn btn-sm btn-light border shadow-sm" data-toggle="modal" data-target="#modalDetail{{ $log->id }}">
                                    <i class="fas fa-search-plus text-primary"></i>
                                </button>
                            </td>
                        </tr>

                        <div class="modal fade" id="modalDetail{{ $log->id }}" tabindex="-1" role="dialog">
                            <div class="modal-dialog modal-lg border-0" role="document">
                                <div class="modal-content shadow-lg border-0">
                                    <div class="modal-header bg-dark text-white border-0">
                                        <h6 class="modal-title font-weight-bold text-uppercase">Audit Detail #{{ $log->id }}</h6>
                                        <button type="button" class="close text-white" data-dismiss="modal"><span>&times;</span></button>
                                    </div>
                                    <div class="modal-body p-4 bg-light">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label class="font-weight-bold small text-muted">DATA LAMA (PREVIOUS)</label>
                                                <pre class="bg-white p-3 border rounded shadow-sm small" style="max-height: 400px; overflow-y: auto;">{{ json_encode($log->old_values, JSON_PRETTY_PRINT) }}</pre>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="font-weight-bold small text-muted">DATA BARU (UPDATED)</label>
                                                <pre class="bg-white p-3 border rounded shadow-sm small" style="max-height: 400px; overflow-y: auto;">{{ json_encode($log->new_values, JSON_PRETTY_PRINT) }}</pre>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer bg-light border-0">
                                        <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Tutup</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center py-5 text-muted italic">
                                <i class="fas fa-info-circle mr-1"></i> Data log tidak ditemukan.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer bg-white border-0 py-3 d-flex align-items-center justify-content-between">
            <span class="small text-muted font-weight-bold text-uppercase">Total Rekaman: {{ $logs->total() }}</span>
            {{ $logs->links() }}
        </div>
    </div>
</div>
@endsection
