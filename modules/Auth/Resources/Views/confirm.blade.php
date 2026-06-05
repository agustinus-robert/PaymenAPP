@extends('auth::layouts.auth')

@section('title', 'Password confirmation | ')

@section('content')
    <h2>Password confirmation</h2>
    <p class="text-muted mb-4">Please enter your password to continue!</p>
    <form class="form-block" action="{{ route('auth::confirm', ['next' => request('next')]) }}" method="POST"> @csrf
        <div class="mb-3">
            <input type="password" class="form-control @error('password') is-invalid @enderror" name="password" placeholder="Password" required autofocus>
        </div>
        @error('password')
            <p class="text-danger">{{ $message }}</p>
        @enderror
        <div class="mt-5">
            <button type="submit" class="btn btn-danger px-3">Continue <i class="mdi mdi-arrow-right"></i></button>
            <a class="btn btn-ghost-light text-dark" href="{{ request('next', url()->previous()) }}"><i class="mdi mdi-arrow-left"></i> Previous</a>
        </div>
    </form>
@endsection
