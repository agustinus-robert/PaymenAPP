@extends('layouts.guest')

@section('content')
    <div>
        <div class="container-fluid p-0">
            <div class="row g-0">

                <div class="col-xl-9">
                    <div class="auth-full-bg pt-lg-5 p-4">
                        <div class="w-100">
                            <div class="bg-overlay"></div>
                            <div class="d-flex h-100 flex-column">

                                <div class="mt-auto p-4">
                                    <div class="row justify-content-center">
                                        <div class="col-lg-7">
                                            <div class="text-center">

                                                <h4 class="mb-3"><i class="bx bxs-quote-alt-left text-primary h1 me-3 align-middle"></i><span class="text-primary">Payment</span> System</h4>

                                                <div dir="ltr">
                                                    <div class="owl-carousel owl-theme auth-review-carousel" id="auth-review-carousel">
                                                        <div class="item">
                                                            <div class="py-3">
                                                                <p class="font-size-16 mb-4">Kemudahan dalam pembayaran</p>

                                                                <div>
                                                                    <h4 class="font-size-16 text-primary">- Payment APP -</h4>
                                                                </div>
                                                            </div>

                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end col -->

                <div class="col-xl-3">
                    <div class="auth-full-page-content p-md-5 p-4">
                        <div class="w-100">

                            <div class="d-flex flex-column h-100">
                                <div class="mb-md-5 mb-4">
                                   <a href="{{ route('login') }}" class="d-block card-logo text-center text-dark decoration-none py-3">
                                        <div class="d-flex align-items-center justify-content-center gap-2">
                                            <i class="fa fa-wallet text-dark fs-1"></i>
                                            <span class="fs-2 fw-bold text-uppercase tracking-wider">PaymentApp</span>
                                        </div>
                                    </a>
                                </div>
                                <div class="my-auto">

                                    <div>
                                        <h5 class="text-primary">Selamat Datang !</h5>
                                        <p class="text-muted">Silahkan login sesuai dengan user pengguna anda</p>
                                    </div>

                                    <div class="mt-4">
                                        @if (session('status'))
                                            <div class="alert alert-success">
                                              <i class="bx bx-envelope"></i>  {{ session('status') }}
                                            </div>
                                        @endif

                                        @if (session('success'))
                                            <div class="alert alert-success">
                                              <i class=" bx bx-id-card"></i>  {{ session('success') }}
                                            </div>
                                        @endif

                                        <form method="POST" action="{{ route('login') }}">
                                            @csrf

                                            <div class="mb-3">
                                                <label for="username" class="form-label" value="{{ __('Username') }}">Username</label>
                                                <input id="username" class="form-control" type="text" name="username" :value="old('username')" required autofocus autocomplete="username" />
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label" for="password" value="{{ __('Password') }}">Password</label>
                                                <input class="form-control" type="password" name="password" required />
                                            </div>

                                            <div class="d-grid mt-3">
                                                <button class="btn btn-primary waves-effect waves-light" type="submit">Masuk</button>
                                            </div>

                                            <div class="mt-4 flex items-center justify-end">
                                                @if (Route::has('password.request'))
                                                    <a class="rounded-md text-sm text-gray-600 underline hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2" href="{{ route('password.request') }}">
                                                        {{ __('Lupa password anda?') }}
                                                    </a>
                                                @endif

                                                {{-- <x-button class="ms-4">
                                                    {{ __('Masuk') }}
                                                </x-button> --}}
                                            </div>
                                        </form>

                                        {{-- <div class="mt-5 text-center">
                                            <p>Don't have an account ? <a href="auth-register-2.html" class="fw-medium text-primary"> Signup now </a> </p>
                                        </div> --}}
                                    </div>
                                </div>

                                <div class="mt-md-5 mt-4 text-center">
                                    <p class="mb-0">©
                                        <script>
                                            document.write(new Date().getFullYear())
                                        </script> Manajemen Terintegrasi. By <b>Backend2</b>
                                    </p>
                                </div>
                            </div>


                        </div>
                    </div>
                </div>
                <!-- end col -->
            </div>
            <!-- end row -->
        </div>
        <!-- end container-fluid -->
    </div>
@endsection
