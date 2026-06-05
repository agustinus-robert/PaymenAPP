@props([
    'productId',
    'class' => 'btn btn-primary border-secondary rounded-pill py-2 px-4 mb-4'
])

<a href="javascript:void(0)"
   class="{{ $class }} btn-add-to-cart"
   data-id="{{ $productId }}">
    <i class="fas fa-shopping-cart me-2"></i> Add To Cart
</a>

@once
    @push('styles')
    <style>
        .variant-picker input[type="radio"] { display: none; }
        .variant-picker label {
            display: block; padding: 15px; border: 2px solid #ebedef;
            border-radius: 10px; cursor: pointer; transition: all 0.2s ease-in-out;
            margin-bottom: 12px; position: relative;
        }
        .variant-picker input[type="radio"]:checked + label {
            border-color: #0d6efd; background-color: #f0f7ff;
        }
        .variant-picker input[type="radio"]:checked + label::after {
            content: "\f058"; font-family: "Font Awesome 5 Free"; font-weight: 900;
            position: absolute; top: 15px; right: 15px; font-size: 1.2rem; color: #0d6efd;
        }
        .variant-picker label:hover { border-color: #dee2e6; background-color: #f8f9fa; }
        .modal-content { border-radius: 15px; }

        .qty-input-group { width: 110px; display: flex; align-items: center; }
        .qty-input-group input { text-align: center; border-left: 0; border-right: 0; border-radius: 0; }
        .qty-input-group .btn { padding: 0px 8px; font-weight: bold; }
    </style>
    @endpush

    @push('scripts')
    <div class="modal fade" id="variantModal" tabindex="-1" aria-hidden="true" data-bs-backdrop="static">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content shadow-lg border-0">
                <div class="modal-header border-0 bg-light">
                    <h5 class="modal-title fw-bold">Pilih Varian & Jumlah</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <form id="form-variant-selection" class="variant-picker">
                        <input type="hidden" id="modal-product-id">
                        <div id="variant-list-container"></div>
                    </form>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-light px-4" data-bs-dismiss="modal">Batal</button>
                    <button type="button" id="btn-confirm-variant" class="btn btn-primary px-4 fw-bold">
                        Konfirmasi & Tambah
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('click', async function (e) {
            const btn = e.target.closest('.btn-add-to-cart');
            if (!btn) return;
            e.preventDefault();
            const productId = btn.getAttribute('data-id');
            await processAddToCart(productId, null, btn);
        });

        async function processAddToCart(productId, variantId = null, btnElement = null, quantity = 1, variantCode = null) {
            let originalContent = btnElement ? btnElement.innerHTML : '';
            if (btnElement) {
                btnElement.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i> Adding...';
                btnElement.style.pointerEvents = 'none';
            }

            try {
                const response = await fetch("{{ route('web::web.cart.add') }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        id: productId,
                        variant_id: variantId,
                        variant_code: variantCode,
                        qty: quantity
                    })
                });

                const data = await response.json();
                if (data.status === 'NEED_VARIANT') {
                    openVariantSelection(productId, data.variants);
                } else if (data.success) {
                    const modalEl = document.getElementById('variantModal');
                    const modalInstance = bootstrap.Modal.getInstance(modalEl);
                    if (modalInstance) modalInstance.hide();

                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: 'Produk sudah masuk keranjang.',
                        showConfirmButton: false,
                        timer: 1500,
                        position: 'center'
                    });
                    if (typeof refreshCartUI === 'function') await refreshCartUI();
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal!',
                        text: data.message || 'Gagal menambahkan barang',
                        confirmButtonColor: '#3085d6'
                    });

                    alert(data.message || 'Gagal menambahkan');
                }
            } catch (error) {
                console.error('Error:', error);
            } finally {
                if (btnElement) {
                    btnElement.innerHTML = originalContent;
                    btnElement.style.pointerEvents = 'auto';
                }
            }
        }

        function openVariantSelection(productId, variants) {
            const container = document.getElementById('variant-list-container');
            document.getElementById('modal-product-id').value = productId;

            let html = '';
            let hasSelected = false;

            variants.forEach((v) => {
                const subVariants = v.decoded_variants || [];

                subVariants.forEach((sub) => {
                    if (sub.status === 'deleted') return;

                    let stock = parseFloat(sub.real_stock) || 0;
                    const isOutOfStock = stock <= 0;
                    const uniqueId = `${v.id}_${sub.code}`;

                    let checkedAttr = '';
                    if (!isOutOfStock && !hasSelected) {
                        checkedAttr = 'checked';
                        hasSelected = true;
                    }

                    html += `
                        <div class="variant-option">
                            <input type="radio" name="selected_variant" id="v_${uniqueId}"
                                value="${v.id}"
                                data-code="${sub.code}"
                                ${isOutOfStock ? 'disabled' : ''}
                                ${checkedAttr}>
                            <label for="v_${uniqueId}">
                                <div class="d-flex flex-column text-start">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <span class="fs-6 fw-bold text-dark">${sub.name || 'Varian'}</span>
                                        ${isOutOfStock ? '<span class="badge bg-danger">Habis</span>' : ''}
                                    </div>
                                    <span class="text-primary fw-bold">Rp ${new Intl.NumberFormat('id-ID').format(sub.price || 0)}</span>
                                    <span class="text-muted small mt-1">Sisa Stok: <strong class="${isOutOfStock ? 'text-danger' : 'text-success'}">${stock}</strong></span>

                                    ${!isOutOfStock ? `
                                    <div class="mt-2" onclick="event.preventDefault();">
                                        <div class="input-group qty-input-group">
                                            <button class="btn btn-outline-secondary btn-sm" type="button" onclick="changeModalQty('${uniqueId}', -1, ${stock})">-</button>
                                            <input type="number" id="qty_input_${uniqueId}" class="form-control form-control-sm" value="1" min="1" max="${stock}" readonly>
                                            <button class="btn btn-outline-secondary btn-sm" type="button" onclick="changeModalQty('${uniqueId}', 1, ${stock})">+</button>
                                        </div>
                                    </div>
                                    ` : ''}
                                </div>
                            </label>
                        </div>`;
                });
            });

            container.innerHTML = html;

            const btnConfirm = document.getElementById('btn-confirm-variant');
            if (!hasSelected) {
                btnConfirm.disabled = true;
                btnConfirm.innerText = 'Stok Habis';
            } else {
                btnConfirm.disabled = false;
                btnConfirm.innerText = 'Konfirmasi & Tambah';
            }

            const modalEl = document.getElementById('variantModal');
            let myModal = bootstrap.Modal.getInstance(modalEl);
            if (!myModal) {
                myModal = new bootstrap.Modal(modalEl);
            }

            if (!modalEl.classList.contains('show')) {
                myModal.show();
            }
        }

        window.changeModalQty = function(uniqueId, amount, max) {
            const input = document.getElementById('qty_input_' + uniqueId);
            if (!input) return;
            let current = parseInt(input.value);
            let next = current + amount;
            if (next >= 1 && next <= max) input.value = next;
        };

        document.getElementById('btn-confirm-variant').addEventListener('click', async function() {
            const productId = document.getElementById('modal-product-id').value;
            const selected = document.querySelector('input[name="selected_variant"]:checked');

            if (!selected) {
                alert('Pilih salah satu varian!');
                return;
            }

            const variantId = selected.value;
            const variantCode = selected.getAttribute('data-code');
            const uniqueId = `${variantId}_${variantCode}`;
            const qty = document.getElementById('qty_input_' + uniqueId).value;

            const btn = this;
            const oldText = btn.innerHTML;
            btn.innerHTML = '<i class="fas fa-circle-notch fa-spin me-2"></i> Memproses...';
            btn.disabled = true;

            await processAddToCart(productId, variantId, null, qty, variantCode);

            btn.innerHTML = oldText;
            btn.disabled = false;
        });

        // window.addEventListener('cart-updated', async function() {
        //     const modalEl = document.getElementById('variantModal');

        //     if (modalEl && modalEl.classList.contains('show')) {
        //         const productId = document.getElementById('modal-product-id').value;
        //         console.log('Update detected, refreshing variants for product:', productId);

        //         try {
        //             const response = await fetch("{{ route('web::web.cart.add') }}", {
        //                 method: 'POST',
        //                 headers: {
        //                     'Content-Type': 'application/json',
        //                     'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content,
        //                     'Accept': 'application/json'
        //                 },
        //                 body: JSON.stringify({ id: productId, qty: 0 })
        //             });

        //             const data = await response.json();
        //             if (data.status === 'NEED_VARIANT') {
        //                 openVariantSelection(productId, data.variants);
        //             }
        //         } catch (error) {
        //             console.error('Gagal sinkronisasi stok modal:', error);
        //         }
        //     }
        // });
    </script>
    @endpush
@endonce
