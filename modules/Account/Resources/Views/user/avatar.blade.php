@extends('account::layouts.default')

@section('title', 'Ubah foto profil | ')

@section('content')
	<div class="row justify-content-center">
		<div class="col-xl-9">
			<div class="d-flex align-items-center">
				<a class="text-decoration-none" href="{{ request('next', route('account::index')) }}"><i class="mdi mdi-arrow-left-circle-outline mdi-36px"></i></a>
				<div class="ms-4">
					<h2 class="mb-1">Ubah foto profil</h2>
					<div class="text-muted">Tetapkan foto profil Anda dengan rasio gambar 1:1 dan berukuran tidak lebih dari 1 MB</div>
				</div>
			</div>
			<hr class="my-4">

			<div class="container">
					@if (Session::has('success'))
						<div x-data="{ show: true }" x-init="setTimeout(() => show = false, 1500)" x-show="show">
							<div class="alert alert-success">
								{!! Session::get('success') !!}
							</div>
						</div>
					@endif 

					@if (Session::has('danger'))
						<div x-data="{ show: true }" x-init="setTimeout(() => show = false, 1500)" x-show="show">
							<div class="alert-danger alert">
								{!! Session::get('danger') !!}
							</div>
						</div>
					@endif
				</div>
		</div>

	</div>
	<div class="row justify-content-center">
		<div class="col-xl-3 col-lg-4">
			@include('x-account::User.list-group-account-menu')
		</div>
		<div class="col-xl-6 col-lg-8">
			<div class="card mb-4">
				<div class="card-body p-4">
					<form class="form-block" action="{{ route('account::user.avatar', ['next' => request('next')]) }}" method="POST" enctype="multipart/form-data"> @csrf @method('PUT')
						@include('x-account::User.Avatar.form', ['user' => Auth::user(), 'back' => true])
					</form>
					@if(Auth::user()->getMeta('profile_avatar'))
						<hr class="text-muted">
						<form class="form-block form-confirm py-4" action="{{ route('account::user.avatar', ['next' => request('next')]) }}" method="POST"> @csrf @method('DELETE')
							<div class="d-sm-flex flex-row justify-content-between align-items-center">
								<div class="mb-2 mb-sm-0"><strong class="text-danger">Hapus foto profil?</strong> <br> Tindakan ini tidak dapat diurungkan!</div>
								<button class="btn btn-outline-danger" type="submit"><i class="mdi mdi-trash-can-outline"></i> Hapus</button>
							</div>
						</form>
					@endif
				</div>
			</div>
		</div>
	</div>
@endsection