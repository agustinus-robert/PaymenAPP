<div class="row g-4" id="payment-app" data-options='@json($user ?? [])'>
    <div class="col-lg-7">
        <div class="card border border-secondary border-opacity-10 shadow-sm rounded-3">
            <div class="card-body p-4 p-md-5">
                <div class="d-flex align-items-center gap-2 mb-4 pb-2 border-bottom border-light">
                    <i class="bi bi-wallet2 text-dark fs-5"></i>
                    <h5 class="card-title mb-0 fw-bold text-dark">Detail Transfer</h5>
                </div>

                <form @submit.prevent="handleTransfer" :class="{ 'was-validated': wasValidated }" novalidate>
                    <div class="mb-4">
                        <label for="recipient" class="form-label small fw-bold text-uppercase text-muted mb-2">Pilih Penerima</label>

                        <div class="input-group has-validation">
                            <span class="input-group-text bg-body border-end-0 text-muted"><i class="fa fa-user"></i></span>

                            <v-select
                                v-model="form.recipient"
                                :options="options"
                                :reduce="item => item.id"
                                label="label"
                                placeholder="Cari"
                                class="flex-grow-1 custom-vselect"
                            >
                            </v-select>

                            <div class="invalid-feedback">Silakan pilih penerima terlebih dahulu.</div>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label for="amount" class="form-label small fw-bold text-uppercase tracking-wider text-muted mb-2">Nominal Transfer</label>
                        <div class="input-group has-validation">
                            <span class="input-group-text bg-light fw-bold text-dark border-end-0" :class="{ 'border-danger text-danger': isBalanceInsufficient }">Rp</span>
                            <input v-model.number="form.amount" type="number"
                                   class="form-control border-start-0 ps-2 fs-5 fw-semibold focus-ring"
                                   :class="{ 'is-invalid': isBalanceInsufficient }"
                                   id="amount" placeholder="0" min="10000" required>

                            <div v-if="isBalanceInsufficient" class="invalid-feedback d-block" v-text="errorMessage || 'Saldo Anda tidak mencukupi untuk melakukan transfer ini.'">
                            </div>
                            <div v-else class="invalid-feedback">
                                Nominal tidak boleh kosong dan minimal Rp 10.000.
                            </div>
                        </div>
                        <div class="form-text text-muted small mt-1">Minimal transfer adalah Rp 10.000</div>
                    </div>

                    <div class="mb-4">
                        <label for="note" class="form-label small fw-bold text-uppercase tracking-wider text-muted mb-2">Catatan (Opsional)</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light text-dark border-end-0"><i class="fa fa-pencil"></i></span>
                            <textarea v-model="form.note" class="form-control border-start-0" id="note" rows="2" placeholder="Tulis catatan pembayaran di sini..."></textarea>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-dark w-100 py-3 rounded-3 fw-semibold shadow-sm border-0 d-flex justify-content-center align-items-center gap-2" :disabled="isLoading">
                        <span v-if="!isLoading" class="d-flex align-items-center gap-2">
                            Kirim Uang Sekarang <i class="fa fa-paper-plane fs-5"></i>
                        </span>
                        <span v-else class="d-flex align-items-center justify-content-center">
                            <span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>
                            Memproses Pembayaran...
                        </span>
                    </button>
                </form>
            </div>
        </div>
    </div>

    <div class="col-lg-5 d-flex flex-column gap-4">
        <div class="card border border-secondary border-opacity-10 shadow-sm rounded-3 bg-white flex-grow-1">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-center mb-4 pb-2 border-bottom border-light">
                    <div class="d-flex align-items-center gap-2">
                        <i class="fas fa-history text-dark fs-5"></i>
                        <h2 class="h6 mb-0 fw-bold text-dark text-uppercase tracking-wider">Aktivitas Transaksi antar nasabah</h2>
                    </div>
                </div>

                <div class="list-group list-group-flush" id="transactionHistory" style="max-height: 430px; overflow-y: auto; padding-right: 5px;">
                    @forelse($activities as $activity)
                        @php
                            $isSender = $activity->sender_id === auth()->id();
                            $displayUser = $isSender ? $activity->receiver : $activity->sender;
                            $displayName = $displayUser->name ?? 'Sistem';

                            $words = explode(' ', $displayName);
                            $initials = strtoupper(substr($words[0], 0, 1) . (isset($words[1]) ? substr($words[1], 0, 1) : ''));

                            $specificLog = $activity->logs->first(function($log) use ($isSender) {
                                return $isSender ? $log->adjustment_status === 2 : $log->adjustment_status === 1;
                            });
                        @endphp

                        <div class="list-group-item px-0 py-3 d-flex align-items-start border-0 mb-2">
                            <div class="d-flex align-items-start gap-3 w-100 justify-content-between">

                                <div class="d-flex align-items-start gap-3">
                                    <div class="bg-secondary bg-opacity-10 text-secondary rounded-circle d-flex align-items-center justify-content-center fw-bold small flex-shrink-0" style="width: 42px; height: 42px;">
                                        {{ $initials }}
                                    </div>

                                    <div class="d-flex flex-column gap-1">
                                        <h6 class="mb-0 fw-bold text-dark">{{ $displayName }}</h6>

                                        <span class="font-monospace text-secondary fw-semibold small d-block">{{ $activity->transaction_code }}</span>

                                        <small class="text-muted d-block">
                                            @if($isSender)
                                                <i class="fas fa-arrow-up text-danger fa-xs me-1"></i> Kirim uang
                                            @else
                                                <i class="fas fa-arrow-down text-success fa-xs me-1"></i> Menerima uang
                                            @endif
                                            • {{ $activity->created_at->diffForHumans() }}
                                        </small>

                                        <small class="text-secondary d-block italic">
                                            <i class="fas fa-sticky-note fa-xs me-1 opacity-50"></i> Ket: {{ $activity->description ?? '-' }}
                                        </small>

                                        <div class="mt-1">
                                            @if($isSender)
                                                <span class="text-danger fw-bold fs-6">- Rp {{ number_format($activity->amount, 0, ',', '.') }}</span>
                                            @else
                                                <span class="text-success fw-bold fs-6">+ Rp {{ number_format($activity->amount, 0, ',', '.') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <button type="button"
                                        class="btn btn-link text-secondary p-1 border-0"
                                        data-bs-toggle="modal"
                                        data-bs-target="#detailTransactionModal{{ $activity->id }}">
                                    <i class="fas fa-eye fs-5"></i>
                                </button>

                            </div>
                        </div>

                        <div class="modal fade" id="detailTransactionModal{{ $activity->id }}" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content border-0 shadow-lg rounded-3 text-start">
                                    <div class="modal-header border-bottom border-light px-4 py-3">
                                        <h5 class="modal-title fw-bold text-dark">Detail Transaksi</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body p-4">
                                        <div class="text-center mb-4 pb-3 border-bottom border-light">
                                            <span class="text-muted d-block small mb-1">Nominal Transaksi</span>
                                            <h3 class="fw-bold mb-0 {{ $isSender ? 'text-danger' : 'text-success' }}">
                                                {{ $isSender ? '-' : '+' }} Rp {{ number_format($activity->amount, 0, ',', '.') }}
                                            </h3>
                                        </div>
                                        <div class="d-flex flex-column gap-3">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <span class="text-muted small">Kode Transaksi</span>
                                                <span class="font-monospace fw-bold text-dark">{{ $activity->transaction_code }}</span>
                                            </div>
                                            <div class="d-flex justify-content-between align-items-center">
                                                <span class="text-muted small">Pihak Terkait</span>
                                                <span class="fw-semibold text-dark">{{ $displayName }}</span>
                                            </div>
                                            <div class="d-flex justify-content-between align-items-center">
                                                <span class="text-muted small">Jenis Transaksi</span>
                                                <span class="fw-bold {{ $isSender ? 'text-danger' : 'text-success' }}">
                                                    {{ $isSender ? 'Kirim Uang' : 'Menerima Uang' }}
                                                </span>
                                            </div>
                                            <div class="d-flex justify-content-between align-items-center">
                                                <span class="text-muted small">Waktu Transaksi</span>
                                                <span class="text-secondary small">{{ $activity->created_at->translatedFormat('d F Y, H:i') }}</span>
                                            </div>

                                            <div class="border-top border-light pt-2">
                                                <span class="text-muted small d-block mb-1">Keterangan / Catatan</span>
                                                <p class="text-secondary bg-light rounded p-2.5 small mb-0 font-italic">{{ $activity->description ?? '-' }}</p>
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
                        <div class="text-center py-4 text-muted">
                            <i class="fas fa-receipt fa-2x mb-2 opacity-50"></i>
                            <p class="small mb-0">Belum ada aktivitas transaksi.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
