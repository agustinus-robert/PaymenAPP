@extends('account::layouts.default')

@section('title', 'Profil Saya | ')

@section('content')
<div class="container-fluid">
    <div class="mb-4">
        <h4 class="font-weight-bold">Pengaturan Akun</h4>
    </div>

    @if(session('success'))
        <div class="alert alert-success border-0 shadow-sm mb-4">
            {{ session('success') }}
        </div>
    @endif

    <div class="row">
        <div class="col-lg-4 text-center">
            <div class="card shadow-sm border-0 p-4">
                <img src="{{ $user->profile_avatar_path }}" class="rounded-circle img-thumbnail mb-3 mx-auto" style="width: 120px; height: 120px;">
                <h5 class="font-weight-bold">{{ strtoupper($user->name) }}</h5>
                <p class="text-muted small">{{ $user->email }}</p>
            </div>
        </div>

        <div class="col-lg-8">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <form action="{{ route('account::manage-profile.update', $user->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <h6 class="font-weight-bold mb-3">Informasi Dasar</h6>
                        <div class="row">
                            <div class="col-md-6 form-group mb-3">
                                <label class="small font-weight-bold">NAMA LENGKAP</label>
                                <input type="text" name="name" class="form-control form-control-lg" value="{{ old('name', $user->name) }}" required>
                            </div>
                            <div class="col-md-6 form-group mb-3">
                                <label class="small font-weight-bold">USERNAME</label>
                                <input type="text" name="username" class="form-control form-control-lg" value="{{ old('username', $user->username) }}" required>
                            </div>
                        </div>

                        <div class="form-group mb-4">
                            <label class="small font-weight-bold">ALAMAT EMAIL</label>
                            <input type="email" name="email" class="form-control form-control-lg" value="{{ old('email', $user->email) }}" required>
                        </div>

                        <hr class="my-4">

                        <h6 class="font-weight-bold mb-3 text-warning">Ganti Password (Kosongkan jika tidak diubah)</h6>
                        <div class="form-group mb-3">
                            <label class="small font-weight-bold">PASSWORD LAMA</label>
                            <input type="password" name="old_password" class="form-control form-control-lg @error('old_password') is-invalid @enderror">
                            @error('old_password') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6 form-group mb-3">
                                <label class="small font-weight-bold">PASSWORD BARU</label>
                                <input type="password" name="password" class="form-control form-control-lg">
                            </div>
                            <div class="col-md-6 form-group mb-3">
                                <label class="small font-weight-bold">KONFIRMASI PASSWORD</label>
                                <input type="password" name="password_confirmation" class="form-control form-control-lg">
                            </div>
                        </div>

                        <hr class="my-4">

                        <h6 class="font-weight-bold mb-3 text-primary">Data Wajib diisikan</h6>
                       <div class="row">
                            <div class="col-md-3 mb-3">
                                <label class="small font-weight-bold">AGAMA</label>
                                <select name="profile_religion" class="form-select form-control-lg" required>
                                    <option value="">-- Pilih --</option>
                                    @foreach(\Modules\Account\Enums\ReligionEnum::cases() as $religion)
                                        <option value="{{ $religion->value }}"
                                            @selected(old('profile_religion', $user->getMeta('profile_religion')) == $religion->value)>
                                            {{ $religion->label() }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-3 mb-3">
                                <label class="small font-weight-bold">JENIS KELAMIN</label>
                                <select name="profile_sex" class="form-select form-control-lg" required>
                                    <option value="male" @selected(old('profile_sex', $user->getMeta('profile_sex')) == 'male')>Laki-laki</option>
                                    <option value="female" @selected(old('profile_sex', $user->getMeta('profile_sex')) == 'female')>Perempuan</option>
                                </select>
                            </div>

                            <div class="col-md-3 mb-3">
                                <label class="small font-weight-bold">STATUS PERNIKAHAN</label>
                                <select name="profile_mariage" class="form-select form-control-lg" required>
                                    <option value="single" @selected(old('profile_mariage', $user->getMeta('profile_mariage')) == 'single')>Lajang (TK)</option>
                                    <option value="mariage" @selected(old('profile_mariage', $user->getMeta('profile_mariage')) == 'mariage')>Menikah (K)</option>
                                </select>
                            </div>

                            <div class="col-md-3 mb-3">
                                <label class="small font-weight-bold">ANAK/TANGGUNGAN</label>
                                <input type="number" name="profile_child" class="form-control form-control-lg"
                                    value="{{ old('profile_child', $user->getMeta('profile_child', 0)) }}" min="0" max="10" required>
                            </div>
                        </div>

                        <div class="mt-4">
                            <button type="submit" class="btn btn-primary px-5 font-weight-bold">Simpan Perubahan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
