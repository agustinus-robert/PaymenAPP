@props([
    'name',
    'type' => 'text',
    'id' => null,
    'placeholder' => null,
    'required' => false,
    'value' => null,
])

@php
    $id = $id ?? $name;
    $value = old($name, $value);
    $error = $errors->has($name) ? 'is-invalid' : '';
@endphp

<input
    type="{{ $type }}"
    name="{{ $name }}"
    id="{{ $id }}"
    placeholder="{{ $placeholder }}"
    value="{{ $value }}"
    {{ $attributes->merge(['class' => "form-control $error"]) }}
    @if($required) required @endif
/>

@error($name)
    <small class="invalid-feedback d-block">{{ $message }}</small>
@enderror
