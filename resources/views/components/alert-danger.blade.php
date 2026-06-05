@if(session('danger'))
    <div class="alert alert-danger text-white alert-dismissible border-0 fade show" role="alert">
        {!! session('danger') !!}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif