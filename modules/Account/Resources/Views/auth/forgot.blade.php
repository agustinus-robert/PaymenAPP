@extends('account::layouts.auth')

@section('title', 'Lupa sandi -')

@section('content')
	<h2>Lupa sandi</h2>
	<p class="text-muted mb-4">Kami akan mengirimkan tautan pemulihan sandi ke e-mail Anda</p>
	<form class="form-block" action="{{ route('account::auth.forgot') }}" method="POST"> @csrf
		<div class="form-group">
			<input type="email" class="form-control @error('email') is-invalid @enderror" name="email" placeholder="Alamat e-mail" value="{{ old('email') }}" required autofocus>
			@error('email')
				<span class="invalid-feedback">{{ $message }}</span>
			@enderror
		</div>
		<div class="form-group mb-0 mt-5">
			<button type="submit" class="btn btn-primary px-3">Kirim tautan</button>
			<a class="btn btn-secondary" href="{{ route('account::auth.login') }}">Kembali</a>
		</div>
	</form>
@endsection