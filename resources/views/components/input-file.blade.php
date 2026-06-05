{{-- resources/views/components/input-file.blade.php --}}
@props(['name', 'label' => '', 'error' => null])

<div class="form-group mb-3">
    <div class="custom-file">
        <input type="file" name="{{ $name }}" id="{{ $name }}" {{ $attributes->merge(['class' => 'custom-file-input' . ($error ? ' is-invalid' : '')]) }}>
        <label class="custom-file-label" for="{{ $name }}">{{ $label }}</label>
    </div>
    @if($error)
        <small class="text-danger form-text">{{ $error }}</small>
    @endif
</div>
