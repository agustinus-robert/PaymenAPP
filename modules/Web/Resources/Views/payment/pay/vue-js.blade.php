@push('scripts')
    <script>
        const paymentEl = document.getElementById('payment-app');
        let transferOptions = [];

        if (paymentEl) {
            const rawOptions = paymentEl.getAttribute('data-options');
            if (rawOptions) {
                try {
                    transferOptions = JSON.parse(rawOptions);
                } catch (e) {
                    console.error("Gagal melakukan parse data", e);
                }
            }
        }

        const libSelect = window.VueSelect || window.vSelect;
        if (libSelect) {
            Vue.component('v-select', libSelect.VueSelect || libSelect.default || libSelect);
        } else {
            console.error("Library VueSelect tidak ditemukan di window! Pastikan CDN/file js sudah di-load di atas.");
        }

        const balanceNavbarEl = document.getElementById('user-balance');
        let currentBalance = 0;
        if (balanceNavbarEl) {
            currentBalance = parseInt(balanceNavbarEl.textContent.replace(/[^0-9]/g, '')) || 0;
        }

        new Vue({
            el: '#payment-app',
            data() {
                return {
                    userBalance: currentBalance,
                    wasValidated: false,
                    isLoading: false,
                    isBalanceInsufficient: false,
                    errorMessage: '',
                    options: transferOptions,
                    form: {
                        recipient: '',
                        amount: '',
                        note: ''
                    }
                };
            },
            methods: {
                payInvoice(nominal) {
                    this.form.amount = nominal;
                    this.isBalanceInsufficient = false;
                    this.errorMessage = '';
                },

                handleTransfer() {
                    this.isBalanceInsufficient = false;
                    this.errorMessage = '';
                    this.wasValidated = false;

                    if (!this.form.recipient) {
                        this.wasValidated = true;
                        showToast('Silakan pilih penerima terlebih dahulu.', 'warning');
                        return;
                    }

                    if (!this.form.amount || this.form.amount < 10000) {
                        this.wasValidated = true;
                        showToast('Nominal transfer minimal adalah Rp 10.000', 'warning');
                        return;
                    }

                    if (this.form.amount > this.userBalance) {
                        this.isBalanceInsufficient = true;
                        showToast('Saldo Anda tidak mencukupi untuk melakukan transfer ini.', 'error');
                        return;
                    }

                    this.isLoading = true;
                    this.wasValidated = false;

                    axios.post(`{{ route('web::payment.transfer-payment.store') }}`, {
                        recipient: this.form.recipient,
                        amount: this.form.amount,
                        note: this.form.note
                    })
                    .then(response => {
                        if (response.data.status === 'success') {
                            const transferAmount = parseInt(this.form.amount);
                            showToast(response.data.message || `Transfer sukses! Rp ${transferAmount.toLocaleString('id-ID')} berhasil dikirim.`, 'success');
                            this.userBalance -= transferAmount;
                            if (balanceNavbarEl) {
                                balanceNavbarEl.textContent = 'Rp ' + this.userBalance.toLocaleString('id-ID');
                            }

                            const historyContainer = document.getElementById('transactionHistory');
                            if (historyContainer) {
                                const blankState = historyContainer.querySelector('.text-center.py-4');
                                if (blankState) {
                                    blankState.remove();
                                }

                                const selectedRecipient = this.options.find(item => item.id === this.form.recipient);
                                const recipientName = selectedRecipient ? selectedRecipient.label : 'Nasabah';
                                const initials = recipientName.substring(0, 2).toUpperCase();
                                const txCode = response.data.transaction_code || 'PAY-' + Math.floor(Math.random() * 100000);

                                const newRowHtml = `
                                    <div class="list-group-item px-0 py-3 d-flex align-items-start border-0 mb-2">
                                        <div class="d-flex align-items-start gap-3 w-100 justify-content-between">
                                            <div class="d-flex align-items-start gap-3">
                                                <div class="bg-secondary bg-opacity-10 text-secondary rounded-circle d-flex align-items-center justify-content-center fw-bold small flex-shrink-0" style="width: 42px; height: 42px;">
                                                    ${initials}
                                                </div>
                                                <div class="d-flex flex-column gap-1">
                                                    <h6 class="mb-0 fw-bold text-dark">${recipientName}</h6>
                                                    <span class="font-monospace text-secondary fw-semibold small d-block">${txCode}</span>
                                                    <small class="text-muted d-block">
                                                        <i class="fas fa-arrow-up text-danger fa-xs me-1"></i> Kirim uang • Baru saja
                                                    </small>
                                                    <small class="text-secondary d-block italic">
                                                        <i class="fas fa-sticky-note fa-xs me-1 opacity-50"></i> Ket: ${this.form.note || '-'}
                                                    </small>
                                                    <div class="mt-1">
                                                        <span class="text-danger fw-bold fs-6">- Rp ${transferAmount.toLocaleString('id-ID')}</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                `;

                                historyContainer.insertAdjacentHTML('afterbegin', newRowHtml);
                            }

                            this.form.recipient = '';
                            this.form.amount = '';
                            this.form.note = '';
                        } else {
                            showToast(response.data.message, 'error');
                        }
                    })
                    .catch(error => {
                        let msg = 'Terjadi kesalahan pada server.';
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
