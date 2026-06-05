@if(session('success'))
    <div class="alert alert-success text-white alert-dismissible border-0 fade show" role="alert">
        {!! session('success') !!}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif