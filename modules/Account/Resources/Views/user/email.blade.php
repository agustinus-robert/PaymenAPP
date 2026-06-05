@extends('account::layouts.default')

@section('title', 'Ubah alamat surel | ')

@section('content')
	<div class="row justify-content-center">
		<div class="col-xl-9">
			<div class="d-flex align-items-center">
				<a class="text-decoration-none" href="{{ request('next', route('account::index')) }}"><i class="mdi mdi-arrow-left-circle-outline mdi-36px"></i></a>
				<div class="ms-4">
					<h2 class="mb-1">Ubah alamat surel</h2>
					<div class="text-muted">Alamat surel ini digunakan untuk menerima notifikasi/pemberitahuann dari sistem serta mengatur ulang sandi</div>
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
					<form class="form-block" action="{{ route('account::user.email', ['next' => request('next')]) }}" method="POST"> @csrf @method('PUT')
						@include('x-account::User.Email.form', ['user' => Auth::user(), 'back' => true])
					</form>
				</div>
			</div>
		</div>
	</div>
@endsection