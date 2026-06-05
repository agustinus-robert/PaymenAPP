@if (env('TOURGUIDE_ENABLED') && isset($steps))
    @php
        $_route = Str::snake(str_replace(':', ' ', Route::currentRouteName()));
    @endphp

    @push('styles')
        <link rel="stylesheet" href="{{ asset('vendor/tourguide/tourguide.min.css') }}">
    @endpush

    @push('scripts')
        <div class="modal fade" id="tg-modal" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" role="dialog" aria-labelledby="modalTitleId" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-body pt-0 text-center">
                        <div>
                            <img class="w-100" src="{{ asset('img/manypixels/Customer_Service_Flatline.svg') }}" alt="">
                        </div>
                        <div>
                            <h3 class="fw-bold">Hai {{ Auth::user()->name }}!</h3>
                            Kenalin, aku Tour Guide kamu, mau gak, aku ajak jalan-jalan bentar aja?
                        </div>
                    </div>
                    <div class="modal-footer d-flex justify-content-center flex-column text-center">
                        <div class="mb-4">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Lain kali ya.</button>
                            <button type="button" class="btn btn-danger tg-start" onclick="startTourguide()">Yuk, gaskeun!</button>
                        </div>
                        <div class="d-flex justify-content-center text-muted">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="tg-never-show" onchange="setNeverShow('{{ $_route }}', event.target.checked)">
                                <label class="form-check-label" for="tg-never-show">Jangan tampilkan lagi</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script src="{{ asset('vendor/tourguide/tourguide.min.js') }}"></script>
        <script>
            const modal = new bootstrap.Modal(document.getElementById('tg-modal'), {})
            const setNeverShow = (key, value) => {
                let tourguide = JSON.parse(localStorage.getItem('tourguide') || '{}');
                tourguide[key] = Boolean(value);
                localStorage.setItem('tourguide', JSON.stringify(tourguide));
            };

            const startTourguide = async () => {
                const tourguide = new Tourguide({
                    align: 'top',
                    steps: @json($steps).map((v, k) => ({
                        ...v,
                        title: v.title || '',
                        step: k + 1
                    }))
                });
                await modal.hide();
                tourguide.start();
            }

            document.addEventListener('DOMContentLoaded', () => {
                if (!JSON.parse(localStorage.getItem('tourguide') || '{}')['{{ $_route }}']) {
                    modal.show();
                }
            })
        </script>
    @endpush
@endif
