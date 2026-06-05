@extends('account::layouts.auth')

@section('title', 'Masuk - ')

@section('content')
	<h2>Masuk</h2>
	<p class="text-muted mb-4">Silahkan masuk untuk melanjutkan</p>
	<form class="form-block" action="{{ route('account::auth.login', ['next' => request('next')]) }}" method="POST"> @csrf
		<div class="form-group">
			<input type="text" class="form-control" name="username" placeholder="Username" value="{{ old('username') }}" @if(!old('username')) autofocus @endif required autocomplete="off">
		</div>
		<div class="form-group">
			<div class="input-group">
				<input type="password" class="form-control" name="password" placeholder="Sandi" @if(old('username')) autofocus @endif required autocomplete="off">
				<div class="input-group-append">
					<button type="button" class="btn btn-outline-secondary" id="toggle" data-toggle="button" tabindex="-1"><i id="toggle-icon" class="mdi mdi-eye"></i></button>
				</div>
			</div>
		</div>
		<div class="form-group">
			<div class="custom-control custom-checkbox">
				<input type="checkbox" class="custom-control-input" id="remember" name="remember" value="1" @if(old('remember')) checked @endif>
				<label class="custom-control-label" for="remember">Ingat saya</label>
			</div>
		</div>
		@error('username')
			<p class="text-danger">{{ $message }}</p>
		@enderror
		<div class="form-group mb-0 mt-5">
			<button type="submit" class="btn btn-primary px-3">Masuk</button>
			<a class="btn btn-link float-right pr-0" href="{{ route('account::auth.forgot') }}">Lupa sandi?</a>
		</div>
	</form>
	<p class="text-muted mt-5 mb-0">Tidak punya akun? <a href="{{ route('account::auth.register') }}">Buat akun</a></p>
@endsection

@push('script')
<script>
	var toggle = false;
	$('#toggle').click(() => {
		toggle = !toggle;
		$('[name="password"]').attr('type', toggle ? 'text' : 'password');
		$('#toggle-icon').attr('class', toggle ? 'mdi mdi-eye-off' : 'mdi mdi-eye');
	})
</script>
@endpush