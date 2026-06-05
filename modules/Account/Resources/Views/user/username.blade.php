@extends('account::layouts.default')

@section('title', 'Ubah sandi | ')

@section('content')
	<div class="row justify-content-center">
		<div class="col-xl-9">
			<div class="d-flex align-items-center">
				<a class="text-decoration-none" href="{{ request('next', route('account::index')) }}"><i class="mdi mdi-arrow-left-circle-outline mdi-36px"></i></a>
				<div class="ms-4">
					<h2 class="mb-1">Ubah username</h2>
				<div class="text-muted">Username ini digunakan untuk login ke {{ config('app.name') }}</div>
				</div>
			</div>
			<hr class="my-4">
		</div>
	</div>
	<div class="row justify-content-center">
		<div class="col-xl-3 col-lg-4">
			@include('x-account::User.list-group-account-menu')
		</div>
		<div class="col-xl-6 col-lg-8">
			<div class="card mb-4">
				<div class="card-body p-4">
					<form class="form-block" action="{{ route('account::user.username', ['next' => request('next')]) }}" method="POST"> @csrf @method('PUT')
						<div class="mb-3">
							<label class="form-label required">Username</label>
							<div class="input-group">
								<span class="input-group-text">@</span>
								<input type="text" class="form-control @error('username') is-invalid @enderror" name="username" value="{{ old('username', Auth::user()->username) }}" required>
							</div>
							<small class="form-text text-muted">Nama unik pengguna (bukan nama lengkap), digunakan untuk login, terdiri dari huruf kecil, titik, dan angka, tanpa spasi.</small>
							@error('username')
								<small class="text-primary"> {{ $message }} </small>
							@enderror
						</div>
						<div>
							<button class="btn btn-soft-danger" type="submit"><i class="mdi mdi-check"></i> Simpan</button>
							<a class="btn btn-ghost-light text-dark" href="{{ request('next', route('account::index')) }}"><i class="mdi mdi-arrow-left"></i> Kembali</a>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
@endsection