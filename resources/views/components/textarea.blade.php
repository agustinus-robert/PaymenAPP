@props([
    'name',
    'id' => null,
    'rows' => 3,
    'placeholder' => null,
    'required' => false,
    'value' => null,
])

@php
    $id = $id ?? $name;
    $value = old($name, $value);
    $error = $errors->has($name) ? 'is-invalid' : '';
@endphp

<textarea
    name="{{ $name }}"
    id="{{ $id }}"
    rows="{{ $rows }}"
    placeholder="{{ $placeholder }}"
    {{ $attributes->merge(['class' => "form-control $error"]) }}
    @if($required) required @endif
>{{ $value }}</textarea>

@error($name)
    <small class="invalid-feedback d-block">{{ $message }}</small>
@enderror
