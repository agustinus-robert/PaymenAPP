@props([
    'type' => 'material',
    'data',             // Collection
    'columns' => [],    // Array of columns [{field,label,sortable,slot}]
    'title' => 'Tabel',
    'createRoute' => null, 
    'createCan' => null, // Added for authorization
    'searchRoute' => '',
    'trash' => false,
    'isSearch' => true,
    'searchDynamic' => [], 
    'extra' => [],
    'extracollapse' => [],
    'count' => null,
    'countLabel' => 'Total Data'
])

@php
    $isEmpty = $data->isEmpty();
    $isPaginated = method_exists($data, 'links');
@endphp

@if($type === 'material')
<div class="card my-4">
    {{-- Header --}}
    <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
        <div class="bg-gradient-dark shadow-dark border-radius-lg pt-4 pb-3 d-flex justify-content-between align-items-center">
            <h6 class="text-white text-capitalize ps-3 m-0">{{ $title }}</h6>
            
            @if($createRoute)
                @if(!$createCan || (is_array($createCan) && auth()->user()->can($createCan[0], $createCan[1])))
                    <div class="pe-3">
                        <a href="{{ $createRoute }}" class="btn btn-sm bg-gradient-info mb-0">
                            <i class="material-symbols-rounded text-sm">add</i>
                            <span class="ms-1">Tambah</span>
                        </a>
                    </div>
                @endif
            @endif
        </div>
    </div>

    {{-- Card Body --}}
    <div class="card-body px-3 pb-2">
        
        {{-- Row Info & Actions (SEJAJAR) --}}
        <div class="row align-items-center mb-3">
            <div class="col-md-12">
                @include('components.alertion-message')

                @if($trash)
                    <div class="alert alert-warning text-dark mt-2 mb-0 py-2 border-warning">
                        <i class="material-symbols-rounded text-sm">report</i> Menampilkan data yang dihapus
                    </div>
                @endif
            </div>
            {{-- KIRI: Count Info --}}
            <div class="col-md-3">
                @if($count !== null)
                    <div class="card border shadow-none bg-gray-100 mb-0">
                        <div class="card-body p-2">
                            <div class="d-flex align-items-center">
                                <div class="icon icon-shape bg-gradient-primary shadow-primary text-center border-radius-md" style="width: 30px; height: 38px; min-width: 32px;">
                                    <i class="material-symbols-rounded text-sm opacity-10">table_rows</i>
                                </div>
                                <div class="ps-3">
                                    <p class="text-xs mb-0 text-capitalize font-weight-bold opacity-7">{{ $countLabel }}</p>
                                    <h5 class="font-weight-bolder mb-0">{{ $count }}</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>

            {{-- KANAN: Extra Filter & Search Box --}}
            <div class="col-md-9 d-flex justify-content-end align-items-center gap-2">
                
                {{-- RENDER EXTRA (SEJAJAR DI KANAN) --}}
             @if(count($extra) > 0)
                <div class="d-flex align-items-center gap-2 flex-grow-1 justify-content-end">
                    @foreach($extra as $slot)
                        {!! is_callable($slot) ? $slot() : $slot !!}
                    @endforeach
                </div>
            @endif

                {{-- FORM SEARCH DEFAULT --}}
                @if($searchRoute)
                    <form action="{{ $searchRoute }}" method="GET" class="d-flex align-items-center gap-2 mb-0 p-1" 
                          style="border:1px solid #ced4da; border-radius:6px; min-width: 250px;">
                        <input type="hidden" name="trash" value="{{ $trash }}">

                        @if($isSearch)
                            <input type="text" name="search"
                                value="{{ request('search') }}"
                                placeholder="Cari..."
                                style="border:none; outline:none; flex:1; padding:2px 6px; font-size:12px; background:transparent;">

                            <button type="submit" title="Cari"
                                style="width:28px; height:28px; display:inline-flex; align-items:center; justify-content:center; border-radius:50%; border:none; background:#007bff; color:white;">
                                <i class="material-symbols-rounded" style="font-size:14px;">search</i>
                            </button>

                            <a href="{{ $searchRoute }}" title="Refresh"
                                style="width:28px; height:28px; display:inline-flex; align-items:center; justify-content:center; border-radius:50%; border:1px solid #6c757d; background:white; color:#6c757d;">
                                <i class="material-symbols-rounded" style="font-size:14px;">refresh</i>
                            </a>
                        @endif
                    </form>
                @endif
            </div>
        </div>

        {{-- Alerts --}}

        {{-- Table --}}
        <div class="table-responsive p-0 mt-3">
            <table class="table align-items-center mb-0">
                <thead>
                    <tr>
                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-3">No</th>
                        @foreach($columns as $col)
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">{{ $col['label'] }}</th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    @if($isEmpty)
                        <tr>
                            <td colspan="{{ count($columns)+1 }}" class="text-center py-4">
                                @include('components.notfound')
                            </td>
                        </tr>
                    @else
                        @foreach($data as $index => $item)
                            <tr>
                                <td class="ps-3 text-sm">
                                    {{ $isPaginated ? ($data->firstItem() + $index) : ($loop->iteration) }}
                                </td>
                                @foreach($columns as $col)
                                    <td class="text-sm">
                                        @php
                                            $value = '-';
                                            if(isset($col['field'])) {
                                                $value = is_callable($col['field']) ? $col['field']($item) : data_get($item, $col['field'], '-');
                                            }
                                        @endphp
                                        @if(isset($col['slot']) && is_callable($col['slot']))
                                            {!! $col['slot']($item) !!}
                                        @else
                                            {!! $value !!}
                                        @endif
                                    </td>
                                @endforeach
                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
        </div>

        @if($isPaginated)
            <div class="row p-3">
                {{ $data->links() }}
            </div>
        @endif
    </div>
</div>
@endif

<style>
    .gap-1 { gap: 0.25rem !important; }
    .gap-2 { gap: 0.5rem !important; }
</style>