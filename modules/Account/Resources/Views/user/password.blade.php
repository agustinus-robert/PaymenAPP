@extends('account::layouts.default')

@section('title', 'Ubah sandi | ')

@section('content')
    <div class="row justify-content-center">
        <div class="col-xl-9">
            <div class="d-flex align-items-center">
                <a class="text-decoration-none" href="{{ request('next', route('account::index')) }}"><i class="mdi mdi-arrow-left-circle-outline mdi-36px"></i></a>
                <div class="ms-4">
                    <h2 class="mb-1">Ubah sandi</h2>
                    <div class="text-muted">Alamat surel ini digunakan untuk menerima notifikasi/pemberitahuann dari sistem serta mengatur ulang sandi</div>
                </div>
            </div>
            <hr class="my-4">
        </div>
    </div>
    <div class="row justify-content-center">
        <div class="col-xl-3 col-lg-4">
            @include('x-account::User.list-group-account-menu')
        </div>
        <div class="col-xl-6 col-lg-8">
            <div class="card mb-4">
                <div class="card-body p-4">
                    <form class="form-block" action="{{ route('account::user.password', ['next' => request('next')]) }}" method="POST"> @csrf @method('PUT')
                        <div class="mb-3">
                            <label class="form-label required">Sandi lama</label>
                            <input type="password" class="form-control @error('old_password') is-invalid @enderror" name="old_password" required autofocus>
                            @error('old_password')
                                <small class="text-danger d-block"> {{ $message }} </small>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label required">Sandi baru</label>
                            <input type="password" class="form-control @error('password') is-invalid @enderror" name="password" required>
                            <small class="form-text text-muted">Gunakan sedikitnya 4 karakter. Jangan gunakan sandi dari situs lain atau sesuatu yang mudah ditebak seperti tanggal lahir Anda.</small>
                            <div id="password-strength"></div>
                            @error('password')
                                <small class="text-danger d-block"> {{ $message }} </small>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label required">Konfirmasi sandi baru</label>
                            <input type="password" class="form-control @error('password') is-invalid @enderror" name="password_confirmation" required>
                        </div>
                        <div>
                            <button class="btn btn-soft-danger" type="submit"><i class="mdi mdi-check"></i> Simpan</button>
                            <a class="btn btn-ghost-light text-dark" href="{{ request('next', route('account::index')) }}"><i class="mdi mdi-arrow-left"></i> Kembali</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.querySelector('[name="password"]').addEventListener('keyup', (e) => {
            const password = e.currentTarget.value;
            const strengthbar = document.getElementById("password-strength");

            var strength = 0;
            if (password.match(/[a-z]+/)) {
                strength += 1;
            }
            if (password.match(/[A-Z]+/)) {
                strength += 1;
            }
            if (password.match(/[0-9]+/)) {
                strength += 1;
            }
            if (password.match(/[$@#&!]+/)) {
                strength += 1;
            }
            if (password.length < 6) {
                strengthbar.innerHTML = "minimum number of characters is 6";
            }
            if (password.length > 12) {
                strengthbar.innerHTML = "maximum number of characters is 12";
            }

            switch (strength) {
                case 0:
                    strengthbar.innerHTML = 0;
                    break;

                case 1:
                    strengthbar.innerHTML = 25;
                    break;

                case 2:
                    strengthbar.innerHTML = 50;
                    break;

                case 3:
                    strengthbar.innerHTML = 75;
                    break;

                case 4:
                    strengthbar.innerHTML = 100;
                    break;
            }
        });
    </script>
@endpush
