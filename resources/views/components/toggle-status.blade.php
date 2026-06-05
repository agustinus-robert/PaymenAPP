<form action="{{ $route }}" method="POST" style="display:inline;">
    @csrf
    @method('PUT')
    <input type="hidden" name="open" value="{{ $item->open ? 0 : 1 }}">
    <button type="submit" class="btn btn-uniform m-0 py-2 {{ $item->open ? 'btn btn-outline-success' : 'btn btn-outline-danger' }}"
            title="{{ $item->open ? 'Nonaktifkan' : 'Aktifkan' }}">
        <i class="material-symbols-rounded">
            {{ $item->open ? 'close' : 'check' }}
        </i>    </button>
</form>
