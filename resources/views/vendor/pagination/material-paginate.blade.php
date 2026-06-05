<div class="row align-items-center justify-content-between g-3 py-3">

    {{-- LIMIT SELECT --}}
    <div class="col-md-5 d-flex align-items-center gap-2">
        <span class="text-secondary small fw-medium">Tampilkan</span>
        <select class="form-select form-select-sm border-0 bg-light shadow-none fw-bold"
                style="width: auto; border-radius: 8px; cursor: pointer;"
                onchange="if(this.value) window.location.href=this.value;">
            @foreach ([5, 10, 25, 50, 100] as $limiter)
                <option value="{{ url()->current() }}?{{ http_build_query(array_merge(request()->except('page'), ['limit' => $limiter])) }}"
                        @selected(request('limit', 10) == $limiter)>
                    {{ $limiter }}
                </option>
            @endforeach
        </select>
        <span class="text-secondary small fw-medium">baris</span>
    </div>

    {{-- PAGINATION --}}
    <div class="col-md-7 d-flex justify-content-md-end justify-content-center align-items-center">
        <div class="d-flex align-items-center gap-2">
            
            {{-- PREV --}}
            <a class="text-decoration-none small fw-bold d-flex align-items-center {{ $paginator->onFirstPage() ? 'text-light disabled' : 'text-dark' }}"
               href="{{ $paginator->previousPageUrl() ?? '#' }}" 
               style="gap: 4px; transition: 0.2s;">
               <i class="material-symbols-rounded fs-6">chevron_left</i>
               <span>Prev</span>
            </a>

            {{-- DIGITS --}}
            <div class="d-flex align-items-center gap-1 mx-2">
                @php
                    $start = max($paginator->currentPage() - 2, 1);
                    $end = min($start + 4, $paginator->lastPage());
                    if($end - $start < 4) { $start = max($end - 4, 1); }
                @endphp

                @for ($i = $start; $i <= $end; $i++)
                    <a href="{{ $paginator->url($i) }}"
                       class="d-flex align-items-center justify-content-center text-decoration-none fw-bold"
                       style="width: 30px; height: 30px; border-radius: 8px; font-size: 0.8rem; transition: all 0.2s;
                              {{ $paginator->currentPage() == $i 
                                 ? 'background-color: #212529; color: #fff;' 
                                 : 'color: #6c757d; background-color: transparent;' }}">
                        {{ $i }}
                    </a>
                @endfor
            </div>

            {{-- NEXT --}}
            <a class="text-decoration-none small fw-bold d-flex align-items-center {{ !$paginator->hasMorePages() ? 'text-light disabled' : 'text-dark' }}"
               href="{{ $paginator->nextPageUrl() ?? '#' }}" 
               style="gap: 4px; transition: 0.2s;">
               <span>Next</span>
               <i class="material-symbols-rounded fs-6">chevron_right</i>
            </a>
            
        </div>
    </div>
</div>