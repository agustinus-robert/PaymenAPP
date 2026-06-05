@push('scripts')
    <script>
        let initialBalance = 0;
        const balanceEl = document.getElementById('user-balance');
        if (balanceEl) {
            initialBalance = parseInt(balanceEl.textContent.replace(/[^0-9]/g, '')) || 0;
        }

        new Vue({
            el: '#mutation-app',
            data() {
                return {
                    userBalance: initialBalance,
                    mutationType: 'top_up',
                    wasValidated: false,
                    isLoading: false,
                    isBalanceInsufficient: false,
                    form: {
                        amount: '',
                        note: ''
                    }
                };
            },
            methods: {
                selectNominal(nominal) {
                    this.form.amount = (this.form.amount || 0) + nominal;
                    this.isBalanceInsufficient = false;
                },

                handleMutation() {
                    this.isBalanceInsufficient = false;
                    if (!this.form.amount || this.form.amount < 10000) {
                        this.wasValidated = true;
                        showToast('Harap masukkan nominal minimal Rp 10.000', 'warning');
                        return;
                    }

                    if (this.mutationType === 'withdraw' && this.form.amount > this.userBalance) {
                        this.isBalanceInsufficient = true;
                        showToast('Saldo Anda tidak mencukupi untuk melakukan penarikan dana.', 'error');
                        return;
                    }

                    this.isLoading = true;
                    this.wasValidated = false;
                    const currentType = this.mutationType;
                    const inputAmount = parseInt(this.form.amount);
                    const inputNote = this.form.note;

                    axios.post(`{{ route('web::payment.fund-payment.store') }}`, {
                        mutation_type: currentType,
                        amount: inputAmount,
                        note: inputNote
                    })
                    .then(response => {
                        if (response.data.status === 'success') {
                            const formattedAmount = inputAmount.toLocaleString('id-ID');
                            if (currentType === 'top_up') {
                                showToast(`Tambah saldo sukses! Rp ${formattedAmount} berhasil ditambahkan.`, 'success');
                                this.userBalance += inputAmount;
                            } else {
                                showToast(`Tarik saldo sukses! Rp ${formattedAmount} berhasil dicairkan.`, 'success');
                                this.userBalance -= inputAmount;
                            }

                            if (balanceEl) {
                                balanceEl.textContent = 'Rp ' + this.userBalance.toLocaleString('id-ID');
                            }

                            const historyContainer = document.getElementById('transactionHistory');
                            if (historyContainer) {
                                const blankState = historyContainer.querySelector('.text-center.py-4');
                                if (blankState) {
                                    blankState.remove();
                                }

                                const activityId = response.data.activity_id || Math.floor(Math.random() * 100000);
                                const isTopUp = (currentType === 'top_up');
                                const displayName = isTopUp ? 'Tambah Saldo' : 'Tarik Saldo';
                                const initials = isTopUp ? 'TS' : 'TK';
                                const badgeBg = isTopUp ? 'rgba(40, 167, 69, 0.1)' : 'rgba(220, 53, 69, 0.1)';
                                const badgeColor = isTopUp ? '#28a745' : '#dc3545';
                                const arrowIcon = isTopUp ? 'fa-arrow-down text-success' : 'fa-arrow-up text-danger';
                                const flowText = isTopUp ? 'Dana Masuk' : 'Dana Keluar';
                                const logText = inputNote || (isTopUp ? 'Tambah saldo' : 'Penarikan saldo');
                                const typeText = isTopUp ? 'Penambahan Saldo (+)' : 'Pengurangan Saldo (-)';

                                const newMutationHtml = `
                                    <div class="list-group-item px-0 py-3 d-flex align-items-start border-0 mb-2">
                                        <div class="d-flex align-items-start gap-3 w-100 justify-content-between">
                                            <div class="d-flex align-items-start gap-3">
                                                <div class="rounded-circle d-flex align-items-center justify-content-center fw-bold small flex-shrink-0"
                                                     style="width: 42px; height: 42px; background-color: ${badgeBg}; color: ${badgeColor}">
                                                    ${initials}
                                                </div>

                                                <div class="d-flex flex-column gap-1">
                                                    <h6 class="mb-0 fw-bold text-dark">${displayName}</h6>
                                                    <span class="text-secondary small d-block">ID Snapshot: #${activityId}</span>

                                                    <small class="text-muted d-block">
                                                        <i class="fas ${arrowIcon} fa-xs me-1"></i>
                                                        ${flowText} • Baru saja
                                                    </small>

                                                    <div class="mt-1">
                                                        <small class="text-muted d-block" style="font-size: 0.75rem;">Sisa Saldo: Rp ${this.userBalance.toLocaleString('id-ID')}</small>
                                                    </div>
                                                </div>
                                            </div>

                                            <button type="button" class="btn btn-link text-secondary p-1 border-0" data-bs-toggle="modal" data-bs-target="#detailMutationModal${activityId}">
                                                <i class="fas fa-eye fs-5"></i>
                                            </button>
                                        </div>
                                    </div>

                                    <div class="modal fade" id="detailMutationModal${activityId}" tabindex="-1" aria-hidden="true">
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
                                                            Rp ${this.userBalance.toLocaleString('id-ID')}
                                                        </h3>
                                                    </div>
                                                    <div class="d-flex flex-column gap-3">
                                                        <div class="d-flex justify-content-between align-items-center">
                                                            <span class="text-muted small">Log ID</span>
                                                            <span class="font-monospace fw-bold text-dark">#${activityId}</span>
                                                        </div>
                                                        <div class="d-flex justify-content-between align-items-center">
                                                            <span class="text-muted small">Tipe Perubahan</span>
                                                            <span class="fw-bold ${isTopUp ? 'text-success' : 'text-danger'}">
                                                                ${typeText}
                                                            </span>
                                                        </div>
                                                        <div class="d-flex justify-content-between align-items-center">
                                                            <span class="text-muted small">Waktu Pencatatan</span>
                                                            <span class="text-secondary small">Sekarang</span>
                                                        </div>
                                                        <div class="border-top border-light pt-3">
                                                            <span class="text-muted small d-block mb-1">Keterangan Aktivitas Finansial</span>
                                                            <div class="bg-light rounded p-2.5 small mb-0 text-dark fw-medium">${logText}</div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer border-0 px-4 pb-4 pt-0">
                                                    <button type="button" class="btn btn-secondary w-100 rounded-pill fw-semibold" data-bs-dismiss="modal">Tutup</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                `;

                                historyContainer.insertAdjacentHTML('afterbegin', newMutationHtml);
                            }

                            this.form.amount = '';
                            this.form.note = '';
                        } else {
                            showToast(response.data.message || 'Gagal memproses transaksi.', 'error');
                        }
                    })
                    .catch(error => {
                        let msg = 'Terjadi kesalahan pada sistem.';
                        if (error.response && error.response.data) {
                            msg = error.response.data.message || msg;
                        }
                        showToast(msg, 'error');
                    })
                    .finally(() => {
                        this.isLoading = false;
                    });
                }
            }
        });
    </script>
@endpush
