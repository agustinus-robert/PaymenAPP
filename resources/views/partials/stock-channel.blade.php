<script>
document.addEventListener('DOMContentLoaded', () => {
    if (window.Echo) {
        const marketChannel = window.Echo.channel('products-market');

        const syncStockDisplay = (data) => {
            const isOthers = data.socketId !== window.Echo.socketId();
            const buttons = document.querySelectorAll(`.btn-add-to-cart[onclick*="${data.variantCode}"]`);

            buttons.forEach(btn => {
                let oldStock = 0;
                if (btn.innerText.includes(':')) {
                    oldStock = parseInt(btn.innerText.split(':')[1]) || 0;
                }

                if (btn.innerText.includes(':')) {
                    let parts = btn.innerText.split(':');
                    btn.innerHTML = `${parts[0]}: ${data.newStock}`;
                } else {
                    btn.innerHTML = `Stok: ${data.newStock}`;
                }

                if (isOthers && data.newStock < oldStock) {
                    if (typeof Swal !== 'undefined') {
                        Swal.fire({
                            toast: true,
                            position: 'top-end',
                            icon: 'info',
                            title: `Stok diperbarui karena ada pelanggan lain yang beli.`,
                            showConfirmButton: false,
                            timer: 3000,
                            timerProgressBar: true
                        });
                    }
                }

                if (data.newStock <= 0) {
                    btn.classList.add('disabled', 'btn-light');
                    btn.classList.remove('btn-outline-primary');
                    const card = btn.closest('.product-card-item');
                    if (card) {
                        card.classList.add('is-out');
                        if (!card.querySelector('.bg-danger')) {
                            card.insertAdjacentHTML('afterbegin', '<div class="position-absolute top-50 start-50 translate-middle bg-danger text-white px-2 py-1 rounded small fw-bold" style="z-index: 10;">HABIS</div>');
                        }
                    }
                } else {
                    btn.classList.remove('disabled', 'btn-light');
                    btn.classList.add('btn-outline-primary');
                    const card = btn.closest('.product-card-item');
                    if (card) {
                        card.classList.remove('is-out');
                        const badge = card.querySelector('.bg-danger');
                        if (badge) badge.remove();
                    }
                }
            });

            const variantInput = document.querySelector(`input[data-code="${data.variantCode}"]`);
            if (variantInput) {
                const label = variantInput.nextElementSibling;
                const stockDisplay = label ? label.querySelector('strong') : null;
                const uniqueId = `${variantInput.value}_${data.variantCode}`;
                const qtyInput = document.getElementById(`qty_input_${uniqueId}`);

                if (stockDisplay) {
                    stockDisplay.innerText = data.newStock;
                    stockDisplay.className = data.newStock <= 0 ? 'text-danger' : 'text-success';

                    if (data.newStock <= 0) {
                        variantInput.disabled = true;
                        if (variantInput.checked) variantInput.checked = false;
                        const titleArea = label.querySelector('.justify-content-between');
                        if (titleArea && !titleArea.querySelector('.badge')) {
                            titleArea.insertAdjacentHTML('beforeend', '<span class="badge bg-danger">Habis</span>');
                        }
                        const qtyContainer = label.querySelector('.mt-2');
                        if (qtyContainer) qtyContainer.remove();
                    } else {
                        variantInput.disabled = false;
                        const badgeHabis = label.querySelector('.badge.bg-danger');
                        if (badgeHabis) badgeHabis.remove();

                        if (qtyInput) {
                            qtyInput.max = data.newStock;
                            if (parseInt(qtyInput.value) > data.newStock) {
                                qtyInput.value = data.newStock;
                            }
                            const qtyGroup = qtyInput.closest('.qty-input-group');
                            if (qtyGroup) {
                                qtyGroup.querySelectorAll('button').forEach(btn => {
                                    let currentOnClick = btn.getAttribute('onclick');
                                    if (currentOnClick && currentOnClick.includes('changeModalQty')) {
                                        btn.setAttribute('onclick', currentOnClick.replace(/,\s*\d+\)$/, `, ${data.newStock})`));
                                    }
                                });
                            }
                        }
                    }
                }
            }
        };

        marketChannel.listen('.stock.updated', (data) => {
            syncStockDisplay({
                variantCode: data.variantCode,
                newStock: data.newStock,
                socketId: data.socketId || null
            });
        });

        marketChannel.on('client-stock-reserved', (data) => {
            console.log("Whisper Publik Diterima:", data);
            syncStockDisplay({
                variantCode: data.variantCode,
                newStock: data.newVisualStock,
                socketId: data.socketId
            });
        });

        marketChannel.listenForWhisper('stock-reserved', (data) => {
            syncStockDisplay({
                variantCode: data.variantCode,
                newStock: data.newVisualStock,
                socketId: data.socketId
            });
        });
    }
});
</script>
