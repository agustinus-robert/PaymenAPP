@extends('account::layouts.auth')

@section('title', 'Atur ulang sandi -')

@section('content')
	<h2>Atur ulang sandi</h2>
	<p class="text-muted mb-4">Harap ingat baik-baik sandi Anda!</p>
	<form class="form-block" action="{{ route('account::auth.broker') }}" method="POST"> @csrf
		<input type="hidden" name="token" value="{{ $token ?? '' }}">
		<div class="form-group">
			<input type="password" class="form-control @error('password') is-invalid @enderror" name="password" placeholder="Sandi" required autofocus>
		</div>
		<div class="form-group">
			<input type="password" class="form-control @error('password') is-invalid @enderror" name="password_confirmation" placeholder="Ulangi sandi" required>
		</div>
		@error('password')
			<p class="text-danger">{{ $message }}</p>
		@enderror
		<p class="text-muted">Gunakan sedikitnya 8 karakter. Jangan gunakan sandi dari situs lain atau sesuatu yang mudah ditebak seperti tanggal lahir Anda.</p>
		<div class="form-group mb-0 mt-5">
			<button type="submit" class="btn btn-primary px-3">Simpan sandi</button>
		</div>
	</form>
@endsection