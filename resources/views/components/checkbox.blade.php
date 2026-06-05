@props([
    'name' => null,
    'checked' => false,
    'required' => false,
    'label' => null,
])

<div class="form-check d-flex align-items-center mb-2">
    <input
        type="checkbox"
        name="{{ $name }}"
        {{ $checked ? 'checked' : '' }}
        {{ $required ? 'required' : '' }}
        {!! $attributes->merge(['class' => 'form-check-input rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500']) !!}
    >
    @if($label)
        <label class="form-check-label ms-3" for="{{ $attributes->get('id') ?? $name }}">
            {!! $label !!}
        </label>
    @endif
</div>
