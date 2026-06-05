@extends('auth::layouts.auth')

@section('title', 'Sign up -')

@section('content')
    <h2>Sign up</h2>
    <p class="text-muted mb-4">Create an account to join with us</p>
    <form class="form-block" action="{{ route('auth::signup', ['next' => request('next')]) }}" method="POST"> @csrf
        <div class="mb-3">
            <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" placeholder="Full name" value="{{ old('name') }}" autofocus required>
            @error('name')
                <span class="invalid-feedback">{{ $message }}</span>
            @enderror
        </div>
        <div class="mb-3">
            <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" placeholder="Email" value="{{ old('email') }}" required>
            @error('email')
                <small class="text-danger d-block">{{ $message }}</small>
            @enderror
        </div>
        <div class="mb-3">
            <div class="input-group">
                <input type="password" class="form-control @error('password') is-invalid @enderror" name="password" placeholder="Password" required>
                <button type="button" class="btn btn-light toggle-password" data-target="password" data-bs-toggle="button" tabindex="-1"><i class="mdi mdi-eye"></i></button>
            </div>
            <small class="form-text text-muted">Use a hard-to-guess password, at least 8 characters long and remember your password well</small>
        </div>
        <div class="mb-3">
            <div class="input-group">
                <input type="password" class="form-control @error('password') is-invalid @enderror" name="password_confirmation" placeholder="Confirm password" required>
                <button type="button" class="btn btn-light toggle-password" data-target="password_confirmation" data-bs-toggle="button" tabindex="-1"><i class="mdi mdi-eye"></i></button>
            </div>
            @error('password')
                <small class="text-danger d-block">{{ $message }}</small>
            @enderror
        </div>
        <div>
            <button type="submit" class="btn btn-soft-danger px-3">Join now <i class="mdi mdi-arrow-right ms-1"></i></button>
        </div>
    </form>
    <p class="text-muted mt-4 mb-0">Already have an account? <a href="{{ route('auth::signin', ['next' => request('next')]) }}"><span>Sign in</span></a> here</p>
  {{--   <div class="d-flex align-items-center w-100 my-4 gap-4">
        <div class="w-100 border-top"></div>
        <div class="small text-muted">OR</div>
        <div class="w-100 border-top"></div>
    </div> --}}
  {{--   <a href="{{ route('auth::signin') }}" class="btn btn-outline-secondary d-flex align-items-center w-100 text-dark gap-3 p-3 text-start">
        <img src="{{ asset('img/logo/logo-text.svg') }}" alt="" class="d-block" style="height: 20px;">
        <div class="w-100 text-sm-center">Sign up with PéMad Account</div>
    </a>  --}}
@endsection

@push('scripts')
    <script>
        window.addEventListener('DOMContentLoaded', () => {
            [].slice.call(document.querySelectorAll('.toggle-password')).map((e) => {
                e.addEventListener('click', (e) => {
                    var toggle = e.currentTarget.classList.contains('active');
                    document.querySelector('[name="' + e.currentTarget.dataset.target + '"]').type = (toggle ? 'text' : 'password');
                    e.currentTarget.querySelector('.mdi').className = (toggle ? 'mdi mdi-eye-off' : 'mdi mdi-eye');
                });
            });
        });
    </script>
@endpush
