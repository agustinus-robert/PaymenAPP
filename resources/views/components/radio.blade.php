@props([
    'name',
    'id',
    'value',
    'label' => '',
    'checked' => false,
    'disabled' => false,
    'onchange' => null,
])

<div class="form-check">
    <input type="radio"
           name="{{ $name }}"
           id="{{ $id }}"
           value="{{ $value }}"
           class="form-check-input"
           @if($checked) checked @endif
           @if($disabled) disabled @endif
           @if($onchange) onchange="{{ $onchange }}" @endif
    >
    <label class="form-check-label" for="{{ $id }}">
        {!! $label !!}
    </label>
</div>
