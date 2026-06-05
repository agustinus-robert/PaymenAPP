@props([
    'label' => null,
    'required' => false,
    'isRow' => false,

    // control tampilan
    'isInputGroup' => true,      // wrapper mb-3
    'isOutline' => true,         // outline / non-outline
    'isLegend' => false,         // fieldset + legend
    'legendSize' => 'sm',        // sm | md
    'prepend' => null
])

@php
    $legendClass = match($legendSize) {
        'md' => 'fs-6',
        default => 'fs-7'
    };
@endphp

@if($isInputGroup)
<div class="mb-3">
@endif

{{-- ===== FIELDSET MODE ===== --}}
@if($isLegend)
<fieldset class="border rounded p-3">
    <legend class="float-none w-auto px-2 {{ $legendClass }}">
        {{ $label }}
        @if($required)
            <span class="text-danger">*</span>
        @endif
    </legend>
@endif

{{-- ===== LABEL NORMAL ===== --}}
@if(!$isLegend && $label)
<label class="form-label">
    {{ $label }}
    @if($required)
        <span class="text-danger">*</span>
    @endif
</label>
@endif

{{-- ===== CONTENT ===== --}}
@if($isOutline)
    {{-- INPUT GROUP OUTLINE --}}
    <div class="input-group input-group-outline">
        @if($isRow)
            <div class="row w-100">
                {{ $slot }}
            </div>
        @else
            {{ $slot }}
        @endif
    </div>
@else
    {{-- INPUT GROUP BIASA (TANPA OUTLINE) --}}
    <div class="input-group input-group-dynamic">
        @if(!empty($prepend))
            <span class="input-group-text">{{ $prepend }}</span>
        @endif
        {{ $slot }}
                {{-- @if($isRow)
            <div class="row w-100">
                @if(!empty($prepend))
                    <span class="input-group-text">{{ $prepend }}</span>
                @endif
                {{ $slot }}
            </div>
        @else
            @if(!empty($prepend))
                <span class="input-group-text">{{ $prepend }}</span>
            @endif
            {{ $slot }}
        @endif --}}
    </div>
@endif

@if($isLegend)
</fieldset>
@endif

@if($isInputGroup)
</div>
@endif
