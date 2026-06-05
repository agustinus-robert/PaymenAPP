@extends('auth::layouts.auth')

@section('title', 'Sign in | ')

@section('content')
   
  <div class="card w-full max-w-sm bg-white shadow-xl rounded-lg">
    <div class="card-body">
      <h2 class="card-title text-center">Login</h2>
      <form class="form-block" action="{{ route('auth::signin', ['next' => request('next')]) }}" method="POST"> @csrf
        <div class="form-control mb-4">
          <label class="label">
            <span class="label-text">Username</span>
          </label>
          <input type="text" name="username" placeholder="Username or email" value="{{ old('username') }}" @if (!old('username')) autofocus @endif required autocomplete="off" class="input input-bordered w-full" />
        </div>
        <div class="form-control mb-4">
          <label class="label">
            <span class="label-text">Password</span>
          </label>
          <input type="password" name="password" placeholder="Password" @if (old('username')) autofocus @endif required autocomplete="off" class="input input-bordered w-full" />
          <label class="label">
            <span class="label-text-alt text-red-500 text-xs">Please choose a password.</span>
          </label>
        </div>
        <div class="form-control mb-4">
          <button type="submit" class="btn btn-primary w-full">Sign In</button>
        </div>
        <div class="flex justify-between text-sm">
          <a href="#" class="link link-primary">Forgot Password?</a>
          <span>&copy;{{date('Y')}} Sellers</span>
        </div>
      </form>
    </div>
  </div>

