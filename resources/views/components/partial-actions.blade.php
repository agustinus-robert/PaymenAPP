@props([
    'item',
    'routes' => [],
    'params' => [], // tambahkan ini
    'useModal' => false, // kalau true, edit pakai modal
])

@php
    $isTrashed = method_exists($item, 'trashed') ? $item->trashed() : false;
@endphp

<style>
    .btn-uniform {
        width: 32px;
        height: 32px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 6px;
        padding: 0;
        font-size: 14px;
    }

    .btn-flex {
        display: flex;
        align-items: center;
        justify-content: center;
        gap:4px;
    }
</style>

<div class="btn-flex">
    @if($isTrashed)
        @if(!empty($routes['restore']))
            <form action="{{ is_string($routes['restore']) && str_starts_with($routes['restore'], 'http') ? $routes['restore'] : route($routes['restore'], $item->id) }}" method="POST" class="d-inline">
                @csrf
                @method('PUT')
                <button type="submit" class="btn btn-primary btn-uniform" title="Pulihkan">
                    <i class="material-symbols-rounded">restore</i>
                </button>
            </form>
        @endif

        @if(!empty($routes['kill']))
            <form action="{{ is_string($routes['kill']) && str_starts_with($routes['kill'], 'http') ? $routes['kill'] : route($routes['kill'], $item->id) }}" method="POST" class="d-inline">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger btn-uniform" title="Hapus permanen">
                    <i class="material-symbols-rounded">delete_forever</i>
                </button>
            </form>
        @endif
    @else
        @if(!empty($routes['show']))
            @if(is_string($routes['show']) && str_starts_with($routes['show'], '#'))
                <button type="button"
                    class="btn btn-outline-info btn-uniform m-0 py-2"
                    data-bs-toggle="collapse"
                    data-bs-target="{{ $routes['show'] }}"
                    title="Detail">
                    <i class="material-symbols-rounded">apartment</i>
                </button>
            @else
                <a class="btn btn-outline-info btn-uniform m-0 py-2"
                href="{{ is_string($routes['show']) && str_starts_with($routes['show'], 'http')
                            ? $routes['show']
                            : route($routes['show'], $params['show'] ?? $item->id) }}"
                title="Detail">
                    <i class="material-symbols-rounded">visibility</i>
                </a>
            @endif

        @endif


        @if(!empty($routes['create']))
            <a class="btn btn-outline-success btn-uniform m-0 py-2"
               href="{{ is_string($routes['create']) && str_starts_with($routes['create'], 'http')
                        ? $routes['create']
                        : route($routes['create'], $params['create'] ?? $item->id) }}"
               title="Buat Baru">
                <i class="material-symbols-rounded">add_circle</i>
            </a>
        @endif

        @if(!empty($routes['edit']))
            @if($useModal)
                <button type="button"
                    class="btn btn-outline-warning btn-uniform m-0 py-2"
                    title="Edit"
                    data-bs-toggle="modal"
                    data-bs-target="#editModal"
                    data-id="{{ $item->id }}"
                    data-name="{{ $item->name }}"
                    data-action="{{ is_string($routes['edit']) && str_starts_with($routes['edit'], 'http') ? $routes['edit'] : route($routes['edit'], $item->id) }}">
                    <i class="material-symbols-rounded">edit</i>
                </button>
            @else
                <a class="btn btn-outline-warning btn-uniform m-0 py-2"
                   href="{{ is_string($routes['edit']) && str_starts_with($routes['edit'], 'http') ? $routes['edit'] : route($routes['edit'], $item->id) }}"
                   title="Edit">
                    <i class="material-symbols-rounded">edit</i>
                </a>
            @endif
        @endif

        @if(empty($routes['edit']) && !empty($routes['index']))
            <a class="btn btn-outline-warning btn-uniform m-0 py-2"
               href="{{ is_string($routes['index']) && str_starts_with($routes['index'], 'http')
                    ? $routes['index'].'?edit='.$item->id
                    : route($routes['index'], array_merge(request()->query(), ['edit' => $item->id]))
               }}"
               title="Edit">
                <i class="material-symbols-rounded">edit</i>
            </a>
        @endif


        @if(!empty($routes['destroy']))
            <form action="{{ is_string($routes['destroy']) && str_starts_with($routes['destroy'], 'http') ? $routes['destroy'] : route($routes['destroy'], $item->id) }}" method="POST" class="d-inline">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-outline-danger btn-uniform m-0 py-2" title="Hapus">
                    <i class="material-symbols-rounded">delete</i>
                </button>
            </form>
        @endif
    @endif

    @if(isset($extra) && is_callable($extra))
        {!! $extra($item) !!}
    @endif
</div>
