<div class="row mb-3">
    <label class="form-label required">Peran</label>
    <div class="input-group d-flex">
        <select name="role_id" id="role_id" class="form-select">
            <option value="">--Pilih--</option>
            @foreach ($roles as $role)
                <option value="{{ $role->id }}">{{ $role->name }}</option>
            @endforeach
        </select>
    </div>
    @error('username')
        <small class="text-danger d-block"> {{ $message }} </small>
    @enderror
    <div class="text-muted my-4">
        Peran saat ini adalah <span class="badge bg-soft-secondary text-dark">{{ $user->roles->first()->name ?? 'Belum ada peran' }}</span>
    </div>
</div>
<div>
    <button class="btn btn-soft-danger" type="submit"><i class="mdi mdi-check"></i> Simpan</button>
    @isset($back)
        <a class="btn btn-ghost-light text-dark" href="{{ request('next', route('core::system.users.index')) }}"><i class="mdi mdi-arrow-left"></i> Kembali</a>
    @endisset
</div>
