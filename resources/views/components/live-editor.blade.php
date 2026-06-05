@props(['idMenu' => null, 'content' => null, 'postId' => null, 'custom' => null, 'label' => null, 'icon' => null])

@auth
    @php
        $rawId = null;
        try {
            $rawId = $postId ? decrypt($postId) : null;
        } catch (\Exception $e) { }
        $encodedPointer = $rawId ? cms_encode($rawId) : '';
    @endphp

    <div class="position-absolute {{ $custom ?? 'top-0 end-0 m-3' }}" style="{{ $custom ?? 'z-index: 100;' }}">
        <button
            class="btn btn-primary p-0 shadow-none d-flex align-items-center justify-content-center p-1"
            hx-get="{{ route('web::editor-sidebar.edit', $idMenu) }}@if($postId)?post_id={{ urlencode($postId) }}&pointer={{ $encodedPointer }}@endif"
            hx-target="#customizer-content"
            hx-indicator="#loading-spinner"
            title="Edit Section">
            @if(!empty($label))
                @if(!empty($icon)) <i class="{{ $icon }} me-2"></i> @endif
                {{ $label }}
            @else
                <i class="mdi mdi-pencil"></i>
            @endif
        </button>
    </div>

    @once
        @push('scripts')
        <script>
            // Variabel global agar bisa diakses dari iframe/sidebar
            window.currentEditingPostPointer = null;

           window.updateLivePreview = function(id, key, value) {
            let finalKey = key;

            if (key.indexOf('-') === -1 && window.currentEditingPostPointer) {
                finalKey = `${key}-${window.currentEditingPostPointer}`;
            }

            const targets = document.querySelectorAll(`[data-field="${finalKey}"]`);

            console.log("Jumlah elemen ditemukan:", targets.length);

            if (targets.length > 0) {
                targets.forEach(el => {
                    // JIKA ELEMEN ADALAH GAMBAR
                    if (el.tagName === 'IMG') {
                        el.src = value;
                    }
                    // JIKA ELEMEN ADALAH TEKS
                    else {
                        if (el.innerHTML !== value) {
                            el.innerHTML = value;
                        }
                    }
                });
            } else {
                // Fallback global
                const globalTarget = document.querySelector(`[data-section-id="${id}"] [data-field="${key}"]`);
                if (globalTarget) {
                    if (globalTarget.tagName === 'IMG') {
                        globalTarget.src = value;
                    } else {
                        globalTarget.innerHTML = value;
                    }
                }
            }
        };
            // Listener untuk menangkap pointer saat tombol edit diklik
            document.body.addEventListener('click', function(e) {
                const btn = e.target.closest('button[hx-get]');
                if (btn) {
                    const urlStr = btn.getAttribute('hx-get');
                    if (urlStr) {
                        const match = urlStr.match(/pointer=([^&]+)/);
                        if (match) {
                            window.currentEditingPostPointer = match[1];
                            console.log("Pointer Aktif:", window.currentEditingPostPointer);
                        } else {
                            window.currentEditingPostPointer = null;
                        }
                    }
                }
            });
        </script>
        @endpush
    @endonce
@endauth
