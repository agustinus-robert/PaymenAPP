<div class="card border-0 shadow-sm mb-3" style="border-radius: 12px; overflow: hidden;">
    <div class="card-header bg-white border-0 pt-3 pb-0">
        <h6 class="mb-0 fw-bold text-dark">
            <i class="mdi mdi-account-circle-outline me-1 text-primary"></i> Informasi Akun
        </h6>
    </div>
    
    <div class="card-body">
        <div class="d-flex align-items-center mb-3">
            <div class="flex-shrink-0 bg-soft-primary rounded-circle d-flex align-items-center justify-content-center" 
                 style="width: 45px; height: 45px; background-color: #eef2ff;">
                <span class="fw-bold text-primary">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</span>
            </div>
            <div class="ms-3 overflow-hidden">
                <h6 class="mb-0 fw-bold text-truncate" style="font-size: 0.9rem;">{{ auth()->user()->name }}</h6>
                <small class="text-muted">@<span>{{ auth()->user()->username }}</span></small>
            </div>
        </div>

        <div class="bg-light p-2 rounded-3" style="background-color: #f8f9fa !important;">
            <div class="d-flex justify-content-between align-items-center px-2">
                <span class="text-muted" style="font-size: 0.75rem;">Status Akun</span>
                <span class="badge bg-success-soft text-success p-0" style="font-size: 0.7rem;">
                    <i class="mdi mdi-check-decagram"></i> Aktif
                </span>
            </div>
            <hr class="my-2 opacity-5">
            <div class="d-flex justify-content-between align-items-center px-2">
                <span class="text-muted" style="font-size: 0.75rem;">Bergabung</span>
                <span class="fw-medium text-dark" style="font-size: 0.75rem;">
                    {{ auth()->user()->created_at->diffForHumans() }}
                </span>
            </div>
        </div>
    </div>

    <div class="card-footer bg-transparent border-top-0 p-0">
        <a class="btn btn-light w-100 border-0 rounded-0 py-2 text-primary fw-bold" 
           href="{{ route('account::index') }}" 
           style="font-size: 0.8rem; background-color: #f0f4f8;">
            <i class="mdi mdi-cog-outline me-1"></i> Pengaturan Akun
        </a>
    </div>
</div>

<style>
    .bg-success-soft { background-color: rgba(40, 167, 69, 0.1); }
</style>