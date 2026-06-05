<div id="mutation-app" class="row g-4">
    <div class="col-lg-7">
        <div class="card border border-secondary border-opacity-10 shadow-sm rounded-3 bg-white">
            <div class="card-body p-4">
                <h2 class="h5 mb-4 fw-bold text-dark text-uppercase tracking-wider border-bottom pb-2">Kelola Dana & Saldo</h2>

                <form @submit.prevent="handleMutation" :class="{'was-validated': wasValidated}" novalidate>
                    <div class="mb-4">
                        <label class="form-label fw-semibold text-secondary small text-uppercase">Pilih Jenis Aktivitas</label>
                        <div class="row g-2">
                            <div class="col-6">
                                <input type="radio" class="btn-check" name="mutation_type" id="type-topup" value="top_up" v-model="mutationType" checked>
                                <label class="btn btn-outline-success w-100 py-2.5 fw-semibold d-flex align-items-center justify-content-center gap-2" for="type-topup">
                                    <i class="fas fa-plus-circle"></i> Tambah Saldo
                                </label>
                            </div>
                            <div class="col-6">
                                <input type="radio" class="btn-check" name="mutation_type" id="type-withdraw" value="withdraw" v-model="mutationType">
                                <label class="btn btn-outline-danger w-100 py-2.5 fw-semibold d-flex align-items-center justify-content-center gap-2" for="type-withdraw">
                                    <i class="fas fa-minus-circle"></i> Tarik Saldo
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="amount" class="form-label fw-semibold text-secondary small text-uppercase">Nominal (Rp)</label>
                        <div class="input-group has-validation">
                            <span class="input-group-text bg-light border-secondary border-opacity-20 fw-medium text-secondary">Rp</span>
                            <input type="number"
                                   id="amount"
                                   class="form-control focus-ring"
                                   :class="{'is-invalid': isBalanceInsufficient}"
                                   placeholder="0"
                                   v-model.number="form.amount"
                                   required>
                            <div class="invalid-feedback" v-if="isBalanceInsufficient">
                                Saldo Anda tidak mencukupi untuk melakukan penarikan ini.
                            </div>
                        </div>

                        <div class="d-flex flex-wrap gap-2 mt-2">
                            <button type="button" class="btn btn-sm btn-light border border-secondary border-opacity-10 text-dark px-3 rounded-2 small" @click="selectNominal(50000)">+50.000</button>
                            <button type="button" class="btn btn-sm btn-light border border-secondary border-opacity-10 text-dark px-3 rounded-2 small" @click="selectNominal(100000)">+100.000</button>
                            <button type="button" class="btn btn-sm btn-light border border-secondary border-opacity-10 text-dark px-3 rounded-2 small" @click="selectNominal(500000)">+500.000</button>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label for="note" class="form-label fw-semibold text-secondary small text-uppercase">Keterangan / Catatan (Opsional)</label>
                        <textarea id="note" class="form-control focus-ring" rows="2" placeholder="Contoh: Tambah Saldo" v-model="form.note"></textarea>
                    </div>

                    <button type="submit" class="btn w-100 py-2.5 fw-bold text-uppercase text-white shadow-sm d-flex align-items-center justify-content-center gap-2"
                            :class="mutationType === 'top_up' ? 'btn-success' : 'btn-danger'"
                            :disabled="isLoading">
                        <span v-if="isLoading" class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                        <i v-else :class="mutationType === 'top_up' ? 'fas fa-plus-circle' : 'fas fa-minus-circle'"></i>
                        @{{ mutationType === 'top_up' ? 'Proses Tambah Saldo' : 'Proses Tarik Saldo' }}
                    </button>
                </form>
            </div>
        </div>
    </div>

    <div class="col-lg-5 d-flex flex-column">
        <div class="card border border-secondary border-opacity-10 shadow-sm rounded-3 bg-white h-100 d-flex flex-column">
            <div class="card-body p-4 d-flex flex-column" style="height: 100%;">

                <div class="d-flex justify-content-between align-items-center mb-4 pb-2 border-bottom border-light flex-shrink-0">
                    <div class="d-flex align-items-center gap-2">
                        <i class="fas fa-history text-dark fs-5"></i>
                        <h2 class="h6 mb-0 fw-bold text-dark text-uppercase tracking-wider">Riwayat Mutasi Anda</h2>
                    </div>
                </div>

                <div class="flex-grow-1 overflow-y-auto pe-2" style="height: 0; min-height: 380px;">
                    <div class="list-group list-group-flush" id="transactionHistory">
                        @forelse($activities as $activity)
                            @php
                                $specificLog = $activity->logs->first();
                                $status = $specificLog->adjustment_status ?? 1;

                                $isTopUp = ($status === 1);
                                $displayName = $isTopUp ? 'Tambah Saldo' : 'Tarik Saldo';
                                $initials = $isTopUp ? 'TS' : 'TK';
                                $logText = $specificLog->log_user ?? '-';
                            @endphp

                            <div class="list-group-item px-0 py-3 d-flex align-items-start border-0 mb-2">
                                <div class="d-flex align-items-start gap-3 w-100 justify-content-between">
                                    <div class="d-flex align-items-start gap-3">
                                        <div class="rounded-circle d-flex align-items-center justify-content-center fw-bold small flex-shrink-0"
                                             style="width: 42px; height: 42px; background-color: {{ $isTopUp ? 'rgba(40, 167, 69, 0.1)' : 'rgba(220, 53, 69, 0.1)' }}; color: {{ $isTopUp ? '#28a745' : '#dc3545' }}">
                                            {{ $initials }}
                                        </div>

                                        <div class="d-flex flex-column gap-1">
                                            <h6 class="mb-0 fw-bold text-dark">{{ $displayName }}</h6>
                                            <span class="text-secondary small d-block">ID Transaksi: #{{ $activity->id }}</span>

                                            <small class="text-muted d-block">
                                                <i class="fas {{ $isTopUp ? 'fa-arrow-down text-success' : 'fa-arrow-up text-danger' }} fa-xs me-1"></i>
                                                {{ $isTopUp ? 'Dana Masuk' : 'Dana Keluar' }} • {{ $activity->created_at->diffForHumans() }}
                                            </small>

                                            <div class="mt-1">
                                                <small class="text-muted d-block" style="font-size: 0.75rem;">Sisa Saldo: Rp {{ number_format($activity->amount, 0, ',', '.') }}</small>
                                            </div>
                                        </div>
                                    </div>

                                    <button type="button" class="btn btn-link text-secondary p-1 border-0" data-bs-toggle="modal" data-bs-target="#detailMutationModal{{ $activity->id }}">
                                        <i class="fas fa-eye fs-5"></i>
                                    </button>
                                </div>
                            </div>

                            <div class="modal fade" id="detailMutationModal{{ $activity->id }}" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content border-0 shadow-lg rounded-3 text-start">
                                        <div class="modal-header border-bottom border-light px-4 py-3">
                                            <h5 class="modal-title fw-bold text-dark">Detail Mutasi Saldo</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body p-4">
                                            <div class="text-center mb-4 pb-3 border-bottom border-light">
                                                <span class="text-muted d-block small mb-1">Status Sisa Saldo Akhir</span>
                                                <h3 class="fw-bold mb-0 text-dark">
                                                    Rp {{ number_format($activity->amount, 0, ',', '.') }}
                                                </h3>
                                            </div>
                                            <div class="d-flex flex-column gap-3">
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <span class="text-muted small">Log ID</span>
                                                    <span class="font-monospace fw-bold text-dark">#{{ $activity->id }}</span>
                                                </div>
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <span class="text-muted small">Tipe Perubahan</span>
                                                    <span class="fw-bold {{ $isTopUp ? 'text-success' : 'text-danger' }}">
                                                        {{ $isTopUp ? 'Penambahan Saldo (+)' : 'Pengurangan Saldo (-)' }}
                                                    </span>
                                                </div>
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <span class="text-muted small">Waktu Pencatatan</span>
                                                    <span class="text-secondary small">{{ $activity->created_at->translatedFormat('d F Y, H:i') }}</span>
                                                </div>
                                                <div class="border-top border-light pt-3">
                                                    <span class="text-muted small d-block mb-1">Keterangan Aktivitas Finansial</span>
                                                    <div class="bg-light rounded p-2.5 small mb-0 text-dark fw-medium">{{ $logText }}</div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer border-0 px-4 pb-4 pt-0">
                                            <button type="button" class="btn btn-secondary w-100 rounded-pill fw-semibold" data-bs-dismiss="modal">Tutup</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-5 text-muted my-auto">
                                <i class="fas fa-receipt fa-2x mb-2 opacity-50"></i>
                                <p class="small mb-0">Belum ada aktivitas mutasi saldo.</p>
                            </div>
                        @endforelse
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
