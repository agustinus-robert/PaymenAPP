@extends('account::layouts.default')

@section('title', 'Dashboard User | ')

@section('content')
<div class="container-fluid">

    <div class="row">
        <div class="col-md-3 mb-4">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="rounded-circle bg-soft-primary p-3 mr-3">
                            <i class="fas fa-users text-primary fa-lg"></i>
                        </div>
                        <div>
                            <small class="text-muted font-weight-bold text-uppercase">Total User</small>
                            <h3 class="mb-0 font-weight-bold text-dark">{{ $total_user }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3 mb-4">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="rounded-circle bg-soft-success p-3 mr-3">
                            <i class="fas fa-shield-alt text-success fa-lg"></i>
                        </div>
                        <div>
                            <small class="text-muted font-weight-bold text-uppercase">Total Role</small>
                            <h3 class="mb-0 font-weight-bold text-dark">{{ $total_role }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3 mb-4">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="rounded-circle bg-soft-info p-3 mr-3">
                            <i class="fas fa-user-tie text-info fa-lg"></i>
                        </div>
                        <div>
                            <small class="text-muted font-weight-bold text-uppercase">Administrator</small>
                            <h3 class="mb-0 font-weight-bold text-dark">{{ $total_admin }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white py-3 d-flex align-items-center">
                    <h6 class="mb-0 font-weight-bold"><i class="fas fa-history mr-2 text-warning"></i> User Terbaru</h6>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th class="border-0 px-4 py-3">User</th>
                                    <th class="border-0 py-3">Role</th>
                                    <th class="border-0 py-3">Terdaftar</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($recent_users as $u)
                                <tr>
                                    <td class="px-4 py-3">
                                        <div class="d-flex align-items-center">
                                            <img src="https://ui-avatars.com/api/?name={{ urlencode($u->name) }}&background=random"
                                                 class="rounded-circle mr-3" width="35" height="35">
                                            <div>
                                                <span class="font-weight-bold d-block text-dark small">{{ strtoupper($u->name) }}</span>
                                                <small class="text-muted">{{ $u->email }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="py-3">
                                        @foreach($u->roles as $role)
                                            <span class="badge badge-light border px-2 py-1 text-uppercase" style="font-size: 10px;">
                                                {{ $role->name }}
                                            </span>
                                        @endforeach
                                    </td>
                                    <td class="py-3 small text-muted">{{ $u->created_at->diffForHumans() }}</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="text-center py-5 text-muted italic">Belum ada data user.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer bg-white text-center py-3 border-0">
                    <a href="{{ route('core::manage-user.index') }}" class="font-weight-bold small">Lihat Semua User <i class="fas fa-arrow-right ml-1"></i></a>
                </div>
            </div>
        </div>

        {{-- QUICK LINKS / INFO --}}
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm bg-primary text-white mb-4">
                <div class="card-body py-4">
                    <h5 class="font-weight-bold">Bantuan Cepat</h5>
                    <p class="small opacity-75">Butuh bantuan mengelola hak akses atau menambah user baru?</p>
                    <a href="#" class="btn btn-light btn-sm font-weight-bold px-3 shadow-sm">
                        Baca Panduan <i class="fas fa-book ml-2"></i>
                    </a>
                </div>
            </div>

            <div class="card border-0 shadow-sm">
                <div class="card-body py-3">
                    <h6 class="font-weight-bold mb-3">Security Tip</h6>
                    <div class="d-flex align-items-start small">
                        <i class="fas fa-shield-alt text-warning mr-3 mt-1 fa-lg"></i>
                        <span>Pastikan setiap user memiliki **Role** yang sesuai. Jangan memberikan akses berlebihan untuk menjaga keamanan data.</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<style>
    .bg-soft-primary { background-color: rgba(0, 123, 255, 0.1); }
    .bg-soft-success { background-color: rgba(40, 167, 69, 0.1); }
    .bg-soft-info    { background-color: rgba(23, 162, 184, 0.1); }
    .opacity-75      { opacity: 0.75; }
</style>
@endsection
