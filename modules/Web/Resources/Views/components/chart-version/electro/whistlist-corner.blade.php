@props(['count' => 0])

<div id="wishlist-corner-wrapper">
    <a href="{{ route('web::area.wishlist.index') }}"
       class="text-muted d-flex align-items-center justify-content-center me-3 position-relative">
        <span class="rounded-circle btn-md-square border d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
            <i id="wishlist-icon-main" class="fas fa-heart {{ $count > 0 ? 'text-danger' : '' }}"></i>
        </span>

        <span id="wishlist-count-badge"
              class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger {{ $count > 0 ? '' : 'd-none' }}"
              style="font-size: 0.7rem;">
            {{ $count }}
        </span>
    </a>
</div>

@once
@push('scripts')
<script>
    window.refreshWishlistUI = async function() {
        const badge = document.getElementById('wishlist-count-badge');
        const icon = document.getElementById('wishlist-icon-main');

        if (!badge || !icon) return;

        try {
            const response = await fetch("{{ route('web::area.wishlist.render') }}", {
                headers: { 'Accept': 'application/json' }
            });

            const data = await response.json();

            if (data.status === 'success') {
                const count = data.count;

                badge.innerText = count;
                if (count > 0) {
                    badge.classList.remove('d-none');
                    icon.classList.add('text-danger');
                } else {
                    badge.classList.add('d-none');
                    icon.classList.remove('text-danger');
                }
            }
        } catch (error) {
            console.error('Gagal fetch count wishlist:', error);
        }
    };

    document.addEventListener('DOMContentLoaded', () => {
        window.refreshWishlistUI();
    });
</script>
@endpush
@endonce
