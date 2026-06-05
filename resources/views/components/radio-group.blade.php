@props([
    'name',
    'options' => [],
    'selected' => null,
    'required' => false,
])

@foreach($options as $key => $option)
    @php
        $label = is_array($option) ? ($option['label'] ?? '') : $option;
        $value = is_array($option) ? ($option['value'] ?? $key) : $key;
        $wrapperClass = is_array($option) ? ($option['wrapper_class'] ?? 'form-check') : 'form-check';
        $inputClass = is_array($option) ? ($option['input_class'] ?? '') : '';
    @endphp

    <div class="{{ $wrapperClass }}">
        <input type="radio"
               name="{{ $name }}"
               id="{{ $name . '_' . $value }}"
               value="{{ $value }}"
               class="form-check-input {{ $inputClass }}"
               autocomplete="off"
               {{ $selected == $value ? 'checked' : '' }}
               {{ $required ? 'required' : '' }}

               @if(is_array($option) && isset($option['attributes']))
                   @foreach($option['attributes'] as $attr => $val)
                       {{ $attr }}="{{ $val }}"
                   @endforeach
               @endif
        >
        <label class="form-check-label mb-0 ms-2" for="{{ $name . '_' . $value }}">
            {!! $label !!}
        </label>
    </div>
@endforeach

@error($name)
    <small class="text-danger d-block">{{ $message }}</small>
@enderror