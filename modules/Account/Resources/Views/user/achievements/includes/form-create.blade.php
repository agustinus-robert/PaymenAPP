<div class="form-group required row mb-3">
	<label class="col-md-5 col-lg-4 col-form-label">Nama prestasi</label>
	<div class="col-md-6 col-lg-7">
		<input type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autofocus>
		<small class="form-text text-muted">Nama prestasi lengkap, bukan singkatan atau kependekan</small>
		@error('name')
			<small class="text-danger"> {{ $message }} </small>
		@enderror
	</div>
</div>
<div class="form-group required row mb-3">
	<label class="col-md-5 col-lg-4 col-form-label">Jenis prestasi</label>
	<div class="col-md-6">
		<select name="type_id" class="form-control @error('type_id') is-invalid @enderror" required>
			<option value="">-- Pilih --</option>
			@foreach (\App\Models\References\AchievementType::all() as $v)
				<option value="{{ $v->id }}" @if((old('type_id') == $v->id)) selected @endif>{{ $v->name }}</option>
			@endforeach	
		</select>
		@error('type_id')
			<span class="invalid-feedback"> {{ $message }} </span>
		@enderror
	</div>
</div>
<div class="form-group required row mb-3">
	<label class="col-md-5 col-lg-4 col-form-label">Tingkat</label>
	<div class="col-md-6">
		<select name="territory_id" class="form-control @error('territory_id') is-invalid @enderror" required>
			<option value="">-- Pilih --</option>
			@foreach (\App\Models\References\Territory::all() as $v)
				<option value="{{ $v->id }}" @if((old('territory_id') == $v->id)) selected @endif>{{ $v->name }}</option>
			@endforeach	
		</select>
		@error('territory_id')
			<span class="invalid-feedback"> {{ $message }} </span>
		@enderror
	</div>
</div>
<div class="form-group required row mb-3">
	<label class="col-md-5 col-lg-4 col-form-label">Tahun</label>
	<div class="col-md-4">
		<input type="number" class="form-control @error('year') is-invalid @enderror" name="year" value="{{ old('year') }}" required>
		@error('year')
			<span class="invalid-feedback"> {{ $message }} </span>
		@enderror
	</div>
</div>
<div class="form-group required row mb-3">
	<label class="col-md-5 col-lg-4 col-form-label">Peringkat</label>
	<div class="col-md-6">
		<select name="num_id" class="form-control @error('num_id') is-invalid @enderror" required>
			<option value="">-- Pilih --</option>
			@foreach (\App\Models\References\AchievementNum::all() as $v)
				<option value="{{ $v->id }}" @if((old('num_id') == $v->id)) selected @endif>{{ $v->name }}</option>
			@endforeach	
		</select>
		@error('num_id')
			<span class="invalid-feedback"> {{ $message }} </span>
		@enderror
	</div>
</div>
<div class="form-group row mb-3">
	<label class="col-md-5 col-lg-4 col-form-label">Bukti keikutsertaan</label>
	<div class="col-md-6 col-lg-7">
		<div class="pb-4 d-flex justify-content-center">
			<img id="upload-preview" class="w-100 rounded border @error('file') border-danger @enderror" src="{{ asset('img/default-img.png') }}" alt="">
		</div>
		<div class="input-group">
			<div class="custom-file">
				<input type="file" name="file" class="form-control" id="upload-input" accept="image/*">
				<label class="custom-file-label text-left" for="upload-input">Pilih berkas ...</label>
			</div>
		</div>
		@error('file')
			<small class="text-danger"> {{ $message }} </small>
		@enderror
	</div>
</div>
<div class="form-group row mb-0">
	<div class="col-md-7 offset-md-5 offset-lg-4">
		<button class="btn btn-primary" type="submit"><i class="mdi mdi-check"></i> Simpan</button>
		@isset($back)
			<a class="btn btn-secondary" href="{{ request('next', route('account::index')) }}"><i class="mdi mdi-arrow-left"></i> Kembali</a>
		@endisset
	</div>
</div>

@push('script')
<script>
	$(() => {
		function readURL(input) {
			if (input.files && input.files[0]) {
				$('[for="upload-input"]').html(input.files[0].name)
				var reader = new FileReader();
				reader.onload = function(e) {
					$('#upload-preview').attr('src', e.target.result);
				}
				reader.readAsDataURL(input.files[0]);
			}
		}

		$("#upload-input").change(function(e) {
			readURL(this);
		});
	})
</script>
@endpush