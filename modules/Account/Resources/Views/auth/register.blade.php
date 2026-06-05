@extends('account::layouts.auth')

@section('title', 'Buat akun -')

@section('content')
	<h2>Buat akun</h2>
	<p class="text-muted mb-4">Bergabung bersama kami</p>
	<form class="form-block" action="{{ route('account::auth.register') }}" method="POST"> @csrf
		<div class="form-group">
			<input type="text" class="form-control @error('name') is-invalid @enderror" name="name" placeholder="Nama lengkap" value="{{ old('name') }}" autofocus required>
			@error('name')
				<span class="invalid-feedback">{{ $message }}</span>
			@enderror
			<small class="form-text text-muted">Nama lengkap Anda (kapital semua), sesuai KTP/KK/Identitas resmi lainnya</small>
		</div>
		<div class="form-group">
			<div class="input-group">
				<div class="input-group-prepend">
					<div class="input-group-text @error('username') alert-danger border-danger @enderror">@</div>
				</div>
				<input type="text" class="form-control @error('username') is-invalid @enderror" name="username" placeholder="Username" value="{{ old('username') }}" required>
			</div>
			@error('username')
				<small class="text-danger">{{ $message }}</small>
			@enderror
			<small class="form-text text-muted">Nama unik pengguna (bukan nama lengkap), digunakan untuk login, terdiri dari huruf kecil, titik, dan angka, tanpa spasi</small>
		</div>
		<div class="form-group">
			<input type="password" class="form-control @error('password') is-invalid @enderror" name="password" placeholder="Sandi" required>
			<small class="form-text text-muted">Minimal 4 karakter</small>
		</div>
		<div class="form-group">
			<input type="password" class="form-control @error('password') is-invalid @enderror" name="password_confirmation" placeholder="Ulangi sandi" required>
			@error('password')
				<span class="invalid-feedback">{{ $message }}</span>
			@enderror
		</div>
		<div class="form-group mb-0">
			<button type="submit" class="btn btn-primary px-3">Buat akun</button>
		</div>
	</form>
	<p class="text-muted mt-5 mb-0">Sudah punya akun? <a href="{{ route('account::auth.login') }}">Masuk</a></p>
@endsection