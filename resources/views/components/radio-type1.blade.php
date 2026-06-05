@props([
    'name',
    'options' => [],
    'selected' => null,
    'required' => false,
    'inline' => true,
])

<div class="d-flex {{ $inline ? 'flex-row' : 'flex-column' }} gap-1">
    @foreach($options as $key => $option)
        @php
            $label = is_array($option) ? ($option['label'] ?? '') : $option;
            $value = is_array($option) ? ($option['value'] ?? $key) : $key;
            $inputClass = is_array($option) ? ($option['input_class'] ?? '') : '';
            $id = $name . '_' . $value . '_' . bin2hex(random_bytes(2)); // Tambah random ID biar gak bentrok
        @endphp

        <div class="flex-grow-1">
            <input type="radio"
                   name="{{ $name }}"
                   id="{{ $id }}"
                   value="{{ $value }}"
                   class="btn-check {{ $inputClass }}"
                   autocomplete="off"
                   {{ (string)$selected === (string)$value ? 'checked' : '' }}
                   {{ $required ? 'required' : '' }}

                   @if(is_array($option) && isset($option['attributes']))
                       @foreach($option['attributes'] as $attr => $val)
                           {{ $attr }}="{{ $val }}"
                       @endforeach
                   @endif
            >
            <label class="btn btn-outline-dark btn-sm w-100 mb-0 py-2 d-flex align-items-center justify-content-center" 
                   for="{{ $id }}" 
                   style="text-transform: none; letter-spacing: 0;">
                {!! $label !!}
            </label>
        </div>
    @endforeach
</div>

@error($name)
    <small class="text-danger d-block mt-1">{{ $message }}</small>
@enderror

<style>
    /* Styling agar saat terpilih (checked), warnanya berubah sesuai tema Material */
    .btn-check:checked + .btn-outline-dark {
        background-color: #344767 !important; /* Warna dark material */
        color: #fff !important;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
    }
    .btn-check:focus + .btn-outline-dark {
        border-color: #344767;
        box-shadow: 0 0 0 0.2rem rgba(52, 71, 103, 0.25);
    }
</style>