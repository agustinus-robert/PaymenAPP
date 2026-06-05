@props(['items' => [], 'total' => 0])

<div class="dropdown" id="cart-dropdown-wrapper">
    <a href="#" class="text-muted d-flex align-items-center justify-content-center position-relative"
       data-bs-toggle="dropdown" aria-expanded="false" id="cart-trigger">
        <span class="rounded-circle btn-md-square border">
            <i class="fas fa-shopping-cart"></i>
        </span>
        <span id="cart-count-badge" class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger {{ count($items) > 0 ? '' : 'd-none' }}" style="font-size: 0.7rem;">
            {{ count($items) }}
        </span>
    </a>

    <div class="dropdown-menu dropdown-menu-end shadow border-0 p-3" style="width: 320px;">
        <h6 class="dropdown-header px-0 text-dark d-flex justify-content-between align-items-center">
            Keranjang Belanja
            <span class="badge bg-primary-subtle text-primary" id="cart-total-qty">{{ count($items) }} Produk</span>
        </h6>

        <hr class="dropdown-divider">

        <div id="cart-items-list" class="cart-items-scroll" style="max-height: 280px; overflow-y: auto; overflow-x: hidden;">
            @forelse($items as $id => $item)
                <div class="d-flex align-items-center mb-3 pe-2 cart-item-row" data-id="{{ $id }}">
                   <img src="{{ (!empty($item['location']) && !empty($item['image_name']))
                            ? asset('uploads/'.$item['location'].'/'.$item['image_name'])
                            : 'https://via.placeholder.com/50' }}"
                    class="rounded border"
                    style="width: 50px; height: 50px; object-fit: cover;"
                    alt="{{ $item['name'] }}">
                    <div class="flex-grow-1 ms-3">
                        <h6 class="mb-0" style="font-size: 0.85rem; display: -webkit-box; -webkit-line-clamp: 1; -webkit-box-orient: vertical; overflow: hidden;">
                            {{ $item['name'] }}
                        </h6>
                        <small class="text-muted">{{ $item['qty'] }} x Rp {{ number_format($item['price'], 0, ',', '.') }}</small>
                    </div>
                    <button type="button" class="btn btn-sm text-danger p-0 ms-2 btn-remove-cart" data-id="{{ $id }}">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            @empty
                <div id="cart-empty-msg" class="text-center py-4">
                    <i class="fas fa-shopping-cart fa-3x text-light mb-2"></i>
                    <p class="text-muted small">Keranjang kosong</p>
                </div>
            @endforelse
        </div>

        <div id="cart-footer" class="{{ count($items) > 0 ? '' : 'd-none' }}">
            <hr class="dropdown-divider">
            <div class="d-flex justify-content-between align-items-center my-2 px-1">
                <span class="text-muted small">Subtotal:</span>
                <strong class="text-primary" id="cart-subtotal">Rp {{ number_format($total, 0, ',', '.') }}</strong>
            </div>

            <div class="d-grid gap-2 mt-3">
                <a href="{{ route('web::web.cart.detail') }}" class="btn btn-outline-primary btn-sm rounded-pill">Lihat Selengkapnya</a>
                <a href="{{ route('web::area.checkout.index') }}" class="btn btn-primary btn-sm rounded-pill">Checkout</a>
            </div>
        </div>
    </div>
</div>

<style>
    .cart-items-scroll::-webkit-scrollbar { width: 4px; }
    .cart-items-scroll::-webkit-scrollbar-thumb { background: #dee2e6; border-radius: 10px; }
    .cart-items-scroll::-webkit-scrollbar-track { background: transparent; }
</style>

@once
    @push('scripts')
    <script>
       window.refreshCartUI = async function() {
            try {
                const response = await fetch("{{ route('web::web.cart.render') }}");
                const html = await response.text();

                const oldWrapper = document.getElementById('cart-dropdown-wrapper');
                if (!oldWrapper) return;

                const parser = new DOMParser();
                const doc = parser.parseFromString(html, 'text/html');
                const newWrapper = doc.getElementById('cart-dropdown-wrapper');

                if (newWrapper) {
                    oldWrapper.replaceWith(newWrapper);

                    const newTrigger = newWrapper.querySelector('#cart-trigger');
                    if (newTrigger && typeof bootstrap !== 'undefined') {
                        new bootstrap.Dropdown(newTrigger);
                    }
                }

                window.dispatchEvent(new Event('cart-updated'));
            } catch (error) {
                console.error('Gagal refresh keranjang:', error);
            }
        };

        document.addEventListener('DOMContentLoaded', () => {
            refreshCartUI();
        });

        document.addEventListener('click', async function(e) {
            const btnRemove = e.target.closest('.btn-remove-cart');
            if (!btnRemove) return;

            e.preventDefault();
            e.stopPropagation();

            const id = btnRemove.getAttribute('data-id');
            if (confirm('Hapus item ini dari keranjang?')) {
                try {
                    const response = await fetch("{{ route('web::web.cart.remove', '') }}/" + id, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                            'Content-Type': 'application/json',
                            'Accept': 'application/json'
                        }
                    });

                    const data = await response.json();

                    if (data.success) {
                        await refreshCartUI();

                        Swal.fire({
                            icon: 'success',
                            title: 'Terhapus!',
                            text: 'Barang berhasil dihapus.',
                            timer: 1000,
                            showConfirmButton: false
                        });
                    } else {
                        Swal.fire('Gagal!', data.message || 'Gagal menghapus item', 'error');
                    }
                } catch (err) {
                    console.error('Error saat menghapus item:', err);
                    alert('Terjadi kesalahan koneksi.');
                }
            }
        });
    </script>
    @endpush
@endonce
