@props([
    'name' => null,
    'id' => null,
    'value' => null,
    'options' => [],
    'placeholder' => null,
    'required' => false,
    'multiple' => false,
])

@php
    $selectName = $name
        ? ($multiple ? $name.'[]' : $name)
        : null;

    $id = $id ?? $name;

    $error = $name && $errors->has($name) ? 'is-invalid' : '';

    $values = $multiple
        ? (array) old($name, $value)
        : [old($name, $value)];
@endphp

<div style="position:relative;width:100%;">
    <select
        class="form-select {{ $error }}"
        @if($selectName) name="{{ $selectName }}" @endif
        @if($id) id="{{ $id }}" @endif
        @if($required && $name) required @endif
        @if($multiple) multiple @endif
        {{ $attributes->whereStartsWith('data-') }}
        style="
            appearance:none;
            width:100%;
            background:#fff;
            color:#000;
            padding:0.5rem;
            border:1px solid #ced4da;
            border-radius:0.375rem;
        "
    >
        @if($placeholder && !$multiple)
            <option value="">{{ $placeholder }}</option>
        @endif

        @foreach($options as $opt)
            @if(isset($opt['children']) && is_array($opt['children']))
                <optgroup label="{{ $opt['label'] ?? '' }}">
                    @foreach($opt['children'] as $child)
                        <option
                            value="{{ $child['value'] ?? '' }}"
                            @selected(isset($child['value']) && in_array($child['value'], $values, true))
                            @foreach($child as $attr => $val)
                                @if(!in_array($attr, ['value','label','children']))
                                    {{-- PERBAIKAN DI SINI: Cek scalar biar gak error dancok --}}
                                    @if($val instanceof \Illuminate\Support\Collection || !is_scalar($val))
                                        {{ $attr }}='@json($val)'
                                    @else
                                        {{ $attr }}="{{ $val }}"
                                    @endif
                                @endif
                            @endforeach
                        >
                            {{ $child['label'] ?? '' }}
                        </option>
                    @endforeach
                </optgroup>
            @else
                <option
                    value="{{ $opt['value'] ?? '' }}"
                    @selected(isset($opt['value']) && in_array($opt['value'], $values, true))
                    @foreach($opt as $attr => $val)
                        @if(!in_array($attr, ['value','label','children']))
                            {{-- PERBAIKAN DI SINI JUGA --}}
                            @if($val instanceof \Illuminate\Support\Collection || !is_scalar($val))
                                {{ $attr }}='@json($val)'
                            @else
                                {{ $attr }}="{{ $val }}"
                            @endif
                        @endif
                    @endforeach
                >
                    {{ $opt['label'] ?? '' }}
                </option>
            @endif
        @endforeach
    </select>

    @unless($multiple)
        <span style="
            position:absolute;
            top:50%;
            right:0.5rem;
            transform:translateY(-50%);
            pointer-events:none;
            color:#000;
            font-size:0.8rem;
        ">▼</span>
    @endunless

    @if($name)
        @error($name)
            <small class="invalid-feedback d-block">{{ $message }}</small>
        @enderror
    @endif
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('select[data-dependent]').forEach(function (select) {

        const targetSelector = select.dataset.dependent;
        const sourceKey      = select.dataset.source;
        const target         = document.querySelector(targetSelector);

        if (!target) return;

        select.addEventListener('change', function () {
            const option = select.options[select.selectedIndex];
            if (!option) return;

            const raw = option.dataset[sourceKey];
            if (!raw) return;

            let data;
            try {
                data = JSON.parse(raw);
            } catch (e) {
                return;
            }

            target.innerHTML = '<option value="">Pilih</option>';

            Object.entries(data).forEach(([value, label]) => {
                const opt = document.createElement('option');
                opt.value = value;
                opt.textContent = label;
                target.appendChild(opt);
            });
        });
    });
});
</script>
