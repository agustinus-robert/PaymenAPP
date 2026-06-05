<div class="row justify-content-between">
    <div class="col-xl-5 col-lg-6 mb-lg-0 mb-3">
        <div class="input-group">
            <div class="input-group-text">Menampilkan</div>
            <select class="form-select w-25" onchange="this.options[this.selectedIndex].value && (window.location = this.options[this.selectedIndex].value);">
                @foreach ([5, 10, 25, 50, 100] as $limiter)
                    <option value="{{ url()->current() }}?{{ http_build_query(array_merge(request()->except('page'), ['limit' => $limiter])) }}" @if (request('limit', 10) == $limiter) selected @endif>{{ $limiter }}</option>
                @endforeach
            </select>
            <div class="input-group-text">baris</div>
        </div>
    </div>
    <div class="col-xl-5 col-lg-6">
        @if ($paginator->hasPages())
            <div class="input-group">
                <a class="btn btn-light text-secondary {{ request('page') <= 1 ? 'disabled' : 'text-dark' }}" style="font-size:12pt; line-height: 1.3rem;" href="{{ $paginator->url(1) }}">&laquo;</a>
                <a class="btn btn-light text-secondary {{ request('page') <= 1 ? 'disabled' : 'text-dark' }}" style="font-size:12pt; line-height: 1.3rem;" href="{{ $paginator->previousPageUrl() }}">&lsaquo;</a>
                <div class="input-group-text">Halaman</div>
                <select class="form-select w-25" onchange="this.options[this.selectedIndex].value && (window.location = this.options[this.selectedIndex].value);">
                    @for ($page = 1; $page <= $paginator->lastPage(); $page++)
                        <option value="{{ $paginator->url($page) }}" @if (request('page') == $page) selected @endif>{{ $page }}</option>
                    @endfor
                </select>
                <a class="btn btn-light text-secondary {{ request('page') >= $paginator->lastPage() ? 'disabled' : 'text-dark' }}" style="font-size:12pt; line-height: 1.3rem;" href="{{ $paginator->nextPageUrl() }}">&rsaquo;</a>
                <a class="btn btn-light text-secondary {{ request('page') >= $paginator->lastPage() ? 'disabled' : 'text-dark' }}" style="font-size:12pt; line-height: 1.3rem;" href="{{ $paginator->url($paginator->lastPage()) }}">&raquo;</a>
            </div>
        @endif
    </div>
</div>
