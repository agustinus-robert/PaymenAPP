@props(['message'])

@if($message)
    <small class="text-danger d-block">{{ $message }}</small>
@endif
