@props([
    'rangeName' => 'range',
    'startName' => 'start_at',
    'endName'   => 'end_at',
])

@php
    use Carbon\Carbon;

    $today = Carbon::today();

    $ranges = [
        'today' => [
            'label' => 'Hari ini',
            'start' => $today->copy(),
            'end'   => $today->copy(),
        ],
        'yesterday' => [
            'label' => 'Kemarin',
            'start' => $today->copy()->subDay(),
            'end'   => $today->copy()->subDay(),
        ],
        'this_week' => [
            'label' => 'Minggu ini',
            'start' => $today->copy()->startOfWeek(),
            'end'   => $today->copy()->endOfWeek(),
        ],
        'last_7_days' => [
            'label' => '7 hari terakhir',
            'start' => $today->copy()->subDays(6),
            'end'   => $today->copy(),
        ],
        'this_month' => [
            'label' => 'Bulan ini',
            'start' => $today->copy()->startOfMonth(),
            'end'   => $today->copy()->endOfMonth(),
        ],
        'prev_month' => [
            'label' => 'Bulan kemarin',
            'start' => $today->copy()->subMonth()->startOfMonth(),
            'end'   => $today->copy()->subMonth()->endOfMonth(),
        ],
        'this_year' => [
            'label' => 'Tahun ini',
            'start' => $today->copy()->startOfYear(),
            'end'   => $today->copy()->endOfYear(),
        ],
        'custom' => [
            'label' => 'Custom',
            'start' => null,
            'end'   => null,
        ],
    ];

    $selected = request($rangeName, 'this_month');

    $startAt = $ranges[$selected]['start']
        ? $ranges[$selected]['start']->format('Y-m-d')
        : request($startName, $today->format('Y-m-d'));

    $endAt = $ranges[$selected]['end']
        ? $ranges[$selected]['end']->format('Y-m-d')
        : request($endName, $today->format('Y-m-d'));

    $rangeJs = [];
    foreach ($ranges as $key => $r) {
        $rangeJs[$key] = [
            'start' => $r['start']?->format('Y-m-d'),
            'end'   => $r['end']?->format('Y-m-d'),
        ];
    }

    $isCustom = $selected === 'custom';
@endphp

{{-- <div class="row g-2 align-items-end"> --}}

    {{-- SELECT RANGE --}}
    <div class="col-12">
        <x-select
            :name="$rangeName"
            :options="collect($ranges)->map(fn($r,$k)=>[
                'value' => $k,
                'label' => $r['label']
            ])->values()"
            :value="$selected"
        />
    </div>

    {{-- START DATE --}}
    <div class="input-group input-group-dynamic">
        <div class="col-md-6">
            <x-label value="Tanggal Awal" />
            <x-input
                type="date"
                size="sm"
                id="start_at"
                :name="$startName"
                :value="$startAt"
                :disabled="!$isCustom"
                required
            />

        </div>

        {{-- END DATE --}}
        <div class="col-md-6">
            <x-label value="Tanggal Akhir" />
            <x-input
                type="date"
                size="sm"
                id="end_at"
                :name="$endName"
                :value="$endAt"
                :disabled="!$isCustom"
                required
            />
        </div>
    </div>

    {{-- HIDDEN INPUT SUPAYA TETAP KEKIRIM SAAT DISABLED --}}
    @unless($isCustom)
        <input type="hidden" name="{{ $startName }}" value="{{ $startAt }}">
        <input type="hidden" name="{{ $endName }}" value="{{ $endAt }}">
    @endunless
{{-- </div> --}}

<script>
    const ranges = @json($rangeJs);

    document.addEventListener('change', function (e) {
        if (e.target.name !== '{{ $rangeName }}') return;

        const start = document.getElementById('start_at');
        const end   = document.getElementById('end_at');

        if (e.target.value !== 'custom') {
            start.value = ranges[e.target.value].start;
            end.value   = ranges[e.target.value].end;
            start.disabled = true;
            end.disabled   = true;
        } else {
            start.disabled = false;
            end.disabled   = false;
        }
    });
</script>
