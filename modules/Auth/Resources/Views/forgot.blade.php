@extends('auth::layouts.auth')

@section('title', 'Forgot password | ')

@section('content')
    <h2>Forgot password</h2>
    <p class="text-muted mb-4">We will send a password recovery link to your email</p>
    <form class="form-block" action="{{ route('auth::forgot') }}" method="POST"> @csrf
        <div class="mb-3">
            <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" placeholder="Email" value="{{ old('email') }}" required autofocus>
            @error('email')
                <span class="invalid-feedback">{{ $message }}</span>
            @enderror
        </div>
        <div class="mt-5">
            <button type="submit" class="btn btn-soft-danger px-2"><i class="mdi mdi-check"></i> Send link</button>
            <a class="btn btn-ghost-light text-dark" href="{{ route('auth::signin', ['next' => request('next')]) }}"><i class="mdi mdi-arrow-left"></i> Previous</a>
        </div>
    </form>
@endsection
