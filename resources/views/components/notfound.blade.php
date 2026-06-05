<div class="py-5 d-flex align-items-center justify-content-center" style="min-height: 50vh;">
    <div class="row justify-content-center align-items-center gx-2 gx-sm-5 mx-0 gy-4 text-center text-xl-start">

        <div class="col-xl-4">
            <div class="d-flex justify-content-center">
                <div style="
                    background: url('{{ asset('img/manypixels/404-page-not-found-62.png') }}') center center no-repeat;
                    background-size: contain;
                    min-height: 250px;
                    width: 100%;
                    max-width: 300px;">
                </div>
            </div>
        </div>

        <div class="col-xl-8">
            <div>
                <div class="display-4 fw-bold mb-3">Upss!!</div>
                <div class="text-muted mb-4">
                    Tidak ada data, kami tidak berhasil menemukan datanya,
                    <p>atau mungkin datanya sudah dihapus.</p>
                </div>

                <a href="{{ url()->current() }}" class="btn bg-gradient-dark d-inline-flex align-items-center px-4 py-2">
                    <i class="material-symbols-rounded fixed-plugin-button-nav me-2" style="font-size: 22px;">refresh</i>
                    Muat Ulang Halaman
                </a>
            </div>
        </div>

    </div>
</div>
