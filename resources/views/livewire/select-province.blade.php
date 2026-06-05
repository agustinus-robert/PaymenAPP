<div>
    <div class="mb-4">
        <label for="provinsi">Provinsi</label>
        <select wire:model="province_id" id="provinsi" class="w-full border p-2">
            <option value="">-- Pilih Provinsi --</option>
            @foreach ($provinces as $prov)
                <option value="{{ $prov->id }}">{{ $prov->name }}</option>
            @endforeach
        </select>
    </div>
</div>
