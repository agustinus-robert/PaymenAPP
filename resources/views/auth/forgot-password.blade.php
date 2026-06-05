@extends('layouts.guest')

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
                        <div class="card-body pt-0" style="background-color:rgb(246, 246, 246) !important;">

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

                                <form method="POST" action="{{ route('password.email') }}">
                                    @csrf

                                    <div class="mb-3">
                                        <label for="useremail" class="form-label">Email</label>
                                        <input type="email" class="form-control" name="email" id="email" value="{{ old('email') }}" placeholder="Enter email">
                                    </div>

                                    <div class="text-end">
                                        <button class="btn btn-primary w-md waves-effect waves-light" type="submit"><i class="bx bx-paper-plane"></i> Kirim</button>
                                    </div>

                                </form>
                            </div>

                        </div>
                    </div>
                    <div class="mt-5 text-center">
                        <p>Sudah ingat kata sandi ? <a href="{{ route('login') }}" class="fw-medium text-primary"> Masuk Disini</a> </p>
                        <p>© <script>document.write(new Date().getFullYear())</script> Solo CMS. Crafted with <i class="mdi mdi-heart text-danger"></i> by Backend2</p>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
