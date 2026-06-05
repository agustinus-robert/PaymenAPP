@if ($errors->any())
    <div class="alert alert-danger shadow-sm border-0 d-flex align-items-start mb-4" role="alert">
        <span class="material-symbols-rounded mr-3 mt-1 text-white" style="font-size: 24px;">error</span>
        <div>
            <div class="font-weight-bold text-white mb-1">
                {{ __('Whoops! Ada yang salah.') }}
            </div>
            <ul class="mb-0 pl-3 text-sm" style="list-style-type: disc;">
                @foreach ($errors->all() as $error)
                    <li class="text-white">{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    </div>
@endif