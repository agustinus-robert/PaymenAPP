@props(['type' => 'default'])

<div class="card-header {{ $type === 'material' ? 'bg-gradient-dark text-white' : '' }}">
    <h6 class="{{ $type === 'material' ? 'text-white' : '' }}">
        {{ $slot }}
    </h6>
</div>
