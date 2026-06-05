@extends('layouts.guest')

@section('title', 'Reset password | ')

@section('content')
<div class="account-pages my-5 pt-sm-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6 col-xl-5">
                <div class="card overflow-hidden">
                    <div class="bg-primary-subtle">
                        <div class="row">
                            <div class="col-7">
                                <div class="text-primary p-4">
                                    <h5 class="text-primary">Rubah Kata Sandi.</h5>
                                    <p>Silahkan rubah kata sandi.</p>
                                </div>
                            </div>
                            <div class="col-5 align-self-end">
                                <img src="assets/images/profile-img.png" alt="" class="img-fluid">
                            </div>
                        </div>
                    </div>
                    <div class="card-body pt-0" style="background-color: rgb(246, 246, 246) !important;">
                        <div>
                            <a href="{{ route('login') }}">
                                <div class="avatar-md profile-user-wid mb-4">
                                    <span class="avatar-title rounded-circle bg-light">
                                        <img src="{{ asset('skote/images/bw.png') }}" alt="" class="rounded-circle" height="80">
                                    </span>
                                </div>
                            </a>
                        </div>

                        <div class="p-2">
                            <form class="form-block" action="{{ route('auth::broker') }}" method="POST">
                                @csrf
                                @method('PATCH')

                                <input type="hidden" name="email" value="{{ request('email') }}">
                                <input type="hidden" name="token" value="{{ request('token') }}">

                                <div class="mb-3">
                                    <input type="password" class="form-control @error('password') is-invalid @enderror"
                                           name="password" placeholder="Password" required autofocus>
                                </div>
                                <div class="mb-3">
                                    <input type="password" class="form-control @error('password') is-invalid @enderror"
                                           name="password_confirmation" placeholder="Confirm password" required>
                                </div>

                                @error('password')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror

                                <p class="text-muted">
                                    Use at least 8 characters. Don't use a password from another site or something easy
                                    to guess like your birthday.
                                </p>

                                <div class="mt-5">
                                    <button type="submit" class="btn btn-danger px-3">
                                        <i class="bx bx-check"></i> Perbarui Kata Sandi
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="mt-5 text-center">
                    <p>
                        Sudah ingat kata sandi ? <a href="{{ route('login') }}" class="fw-medium text-primary"> Masuk Disini</a>
                        <a href="{{ route('login') }}" class="fw-medium text-primary">Sign In here</a>
                    </p>
                    <p>
                        © <script>document.write(new Date().getFullYear())</script> Solo CMS.
                        Crafted with <i class="mdi mdi-heart text-danger"></i> by Backend2
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
