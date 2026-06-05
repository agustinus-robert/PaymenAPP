@props([
    'productId',
    'class' => 'text-primary d-flex align-items-center justify-content-center me-0'
])

<style>
    .btn-wishlist { transition: transform 0.2s ease; cursor: pointer; display: inline-flex !important; text-decoration: none !important; }
    html body .btn-wishlist.active .wishlist-icon,
    html body .btn-wishlist.active i { color: #dc3545 !important; }
    html body .btn-wishlist.active span { border-color: #dc3545 !important; background-color: #fff1f2 !important; }
    .btn-wishlist:active { transform: scale(0.9); }
    .btn-wishlist.pe-none { pointer-events: none; opacity: 0.7; }
</style>

<a href="javascript:void(0)"
   class="{{ $class }} btn-wishlist"
   data-id="{{ $productId }}"
   id="wishlist-btn-{{ $productId }}"
   title="Tambah ke Favorit">
    <span class="rounded-circle btn-sm-square border shadow-sm d-flex align-items-center justify-content-center wishlist-border" style="width: 35px; height: 35px;">
        <i class="far fa-heart wishlist-icon"></i>
    </span>
</a>

@once
    @push('scripts')
    <script>
        async function initWishlistStatus() {
            const btns = document.querySelectorAll('.btn-wishlist');
            if (btns.length === 0) return;
            try {
                const response = await fetch("{{ route('web::area.wishlist.render') }}");
                const data = await response.json();
                const rawItems = data.items || (Array.isArray(data) ? data : []);
                if (rawItems.length > 0) {
                    const favIds = rawItems.map(id => id.toString().trim());
                    btns.forEach(btn => {
                        const pid = btn.getAttribute('data-id').toString().trim();
                        const icon = btn.querySelector('.wishlist-icon');
                        if (favIds.includes(pid)) {
                            btn.classList.add('active');
                            if (icon) {
                                icon.classList.remove('far');
                                icon.classList.add('fas');
                            }
                        }
                    });
                }
            } catch (err) { console.error(err); }
        }

        document.addEventListener('DOMContentLoaded', initWishlistStatus);

        document.addEventListener('click', async function (e) {
            const btn = e.target.closest('.btn-wishlist');
            if (!btn || btn.classList.contains('pe-none')) return;
            e.preventDefault();
            const productId = btn.getAttribute('data-id');
            const icon = btn.querySelector('.wishlist-icon');
            const csrf = document.querySelector('meta[name="csrf-token"]')?.content;
            btn.classList.add('pe-none');
            try {
                const response = await fetch("{{ route('web::area.wishlist.toggle') }}", {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrf, 'Accept': 'application/json' },
                    body: JSON.stringify({ product_id: productId })
                });
                if (response.status === 401) {
                    Swal.fire({ icon: 'info', title: 'Login Dulu', text: 'Silakan login.' }).then(() => { window.location.href = "{{ route('login') }}"; });
                    return;
                }
                const data = await response.json();
                if (data.status === 'success') {
                    const isAdded = data.action === 'added';

                    Swal.fire({
                        icon: 'success',
                        title: isAdded ? 'Ditambahkan!' : 'Dihapus!',
                        text: isAdded ? 'Berhasil simpan ke favorit.' : 'Produk dihapus dari favorit.',
                        timer: 1200,
                        showConfirmButton: false,
                        position: 'center'
                    });

                    if (isAdded) {
                        icon.classList.replace('far', 'fas');
                        btn.classList.add('active');
                    } else {
                        icon.classList.replace('fas', 'far');
                        btn.classList.remove('active');
                    }
                    if (typeof window.refreshWishlistUI === 'function') await window.refreshWishlistUI();
                }
            } catch (error) { console.error(error); } finally { btn.classList.remove('pe-none'); }
        });
    </script>
    @endpush
@endonce
