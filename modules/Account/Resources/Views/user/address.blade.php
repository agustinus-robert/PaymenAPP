@extends('account::layouts.default')

@section('title', 'Ubah alamat domisili | ')

@section('content')
	<div class="row justify-content-center">
		<div class="col-xl-9">
			<div class="d-flex align-items-center">
				<a class="text-decoration-none" href="{{ request('next', route('account::index')) }}"><i class="mdi mdi-arrow-left-circle-outline mdi-36px"></i></a>
				<div class="ms-4">
					<h2 class="mb-1">Ubah alamat domisili</h2>
					<div class="text-muted">Perubahan informasi dibawah akan diterapkan di semua Akun Anda</div>
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
					<form class="form-block" action="{{ route('account::user.address', ['next' => request('next')]) }}" method="POST"> @csrf @method('PUT')
						@include('x-account::User.Address.form', ['user' => Auth::user(), 'back' => true])
					</form>
					@if(Auth::user()->getMeta('address_state'))
						<hr class="text-muted">
						<form class="form-block form-confirm py-4" action="{{ route('account::user.address', ['next' => request('next')]) }}" method="POST"> @csrf @method('DELETE')
							<div class="d-sm-flex flex-row justify-content-between align-items-center">
								<div class="mb-2 mb-sm-0"><strong class="text-danger">Hapus alamat domisili?</strong> <br> Tindakan ini tidak dapat diurungkan!</div>
								<button class="btn btn-outline-danger" type="submit"><i class="mdi mdi-trash-can-outline"></i> Hapus</button>
							</div>
						</form>
					@endif
				</div>
			</div>
		</div>
	</div>
@endsection