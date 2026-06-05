<div class="card {{ $type ?? '' }}">
    @if(isset($title))
        <div class="card-header">{{ $title }}</div>
    @endif
    <div class="card-body">
        {{ $slot }}
    </div>
</div>
