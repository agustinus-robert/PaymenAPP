<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1.0">
    <title>Solo CMS</title>

    <style>
        /* Animasi Gear Berputar */
        .sync-spin {
            animation: spin 2s linear infinite;
        }
        @keyframes spin {
            100% { transform: rotate(360deg); }
        }

        /* FAB (Floating Action Button) - Di atas tombol gear menu */
        #sync-fab {
            z-index: 1055 !important;
            position: fixed !important;
            bottom: 100px;
            right: 30px;
        }

        /* Panel Melayang (Side Panel) Khusus Sync */
        #sync-panel {
            position: fixed !important;
            top: 0;
            right: 0;
            width: 350px;
            height: 100vh;
            z-index: 1065 !important;
            transform: translateX(100%);
            transition: transform 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
            background: #ffffff;
            border-left: 1px solid rgba(0,0,0,.125);
            display: block !important;
        }

        #sync-panel.show {
            transform: translateX(0);
        }

        #sync-task-container {
            padding: 1rem;
            overflow-y: auto;
            height: calc(100vh - 65px);
        }

        /* Styling Progress Bar modern */
        .progress {
            background-color: #e9ecef;
            border-radius: 0.25rem;
            height: 12px !important; /* Ditebelin dikit biar kelihatan cok */
        }

        .progress-bar {
            transition: width 0.4s ease; /* Biar gerakannya smooth */
        }
    </style>

    @if(config('theme.default') == 'material')
        @include('layouts.component.material-style')
    @elseif(config('theme.default') == 'skote')
        @include('layouts.component.skote-style')
    @endif

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@chgibb/css-spinners@2.2.1/css/spinners.min.css">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.css">
    @stack('style')
</head>

<body class="g-sidenav-show bg-gray-100" data-topbar="dark" data-layout="horizontal">

    @stack('nav')

    @if(config('theme.default') == 'material')
        <main class="main-content d-flex flex-column min-vh-100 position-relative border-radius-lg">
            @yield('body-content')
            @include('layouts.component.footer')
        </main>
    @elseif(config('theme.default') == 'skote')
        <div id="layout-wrapper">
            @yield('body-content')
        </div>
    @endif

    @if(config('theme.default') == 'material')
        @include('layouts.component.material-extra')
    @elseif(config('theme.default') == 'skote')
        @include('layouts.component.skote-extra')
    @endif

    <div id="sync-fab" class="d-none">
        <button type="button" class="btn btn-primary rounded-circle shadow-lg d-flex align-items-center justify-content-center"
                style="width: 60px; height: 60px; border: none;" onclick="toggleSyncPanel()">
            <span class="material-symbols-rounded fs-2" id="sync-icon-main">sync</span>
        </button>
    </div>

    <div id="sync-panel" class="shadow-lg">
        <div class="p-3 border-bottom d-flex justify-content-between align-items-center bg-dark text-white">
            <h6 class="m-0 fw-bold text-uppercase small" style="color: white !important;">Proses Sinkronisasi</h6>
            <div class="d-flex align-items-center">
                <button type="button" class="btn btn-link text-white p-0 me-3" title="Bersihkan yang selesai" onclick="clearFinishedTasks()">
                    <i class="material-symbols-rounded fs-5">delete_sweep</i>
                </button>
                <button type="button" class="btn-close btn-close-white" onclick="toggleSyncPanel()"></button>
            </div>
        </div>
        <div id="sync-task-container">
            <div id="no-task-msg" class="text-center text-muted mt-5">
                <i class="material-symbols-rounded fs-1 d-block mb-2">sync_disabled</i>
                <small>Menunggu proses...</small>
            </div>
        </div>
    </div>

    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.js"></script>

    <script>
        const notyf = new Notyf({
            duration: 5000,
            position: { x: 'right', y: 'top' },
            ripple: true
        });

        function toggleSyncPanel() {
            $('#sync-panel').toggleClass('show');
        }

        // Fungsi buat hapus yang udah centang hijau biar rapi
        function clearFinishedTasks() {
            $('.bg-success').closest('.card').fadeOut(function() {
                $(this).remove();
                if ($('#sync-task-container').children('.card').length === 0) {
                    $('#no-task-msg').removeClass('d-none');
                }
            });
        }
    </script>

    @stack('scripts')

    {{-- BROADCASTING CORE --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pusher/8.3.0/pusher.min.js"></script>
    <script src="https://unpkg.com/laravel-echo@1/dist/echo.iife.js"></script>


    <script>
        window.Pusher = Pusher;
        window.Echo = new Echo({
            broadcaster: 'reverb',
            key: 'twp26sryfc3ybirfqtm9',
            wsHost: window.location.hostname,
            wsPort: 8080,
            wssPort: 8080,
            forceTLS: false,
            enabledTransports: ['ws', 'wss'],
        });


        window.Echo.connector.pusher.connection.bind('state_change', function(states) {
            console.log("Koneksi Reverb (SSL):", states.current);
        });

        $(document).ready(function() {
            let initCheck = setInterval(() => {
                if (window.Echo && window.Echo.connector) {
                    clearInterval(initCheck);

                    window.Echo.channel('sync-channel')
                        .listen('.DataSynced', (e) => {
                            const p = e.payload;
                            console.log('Broadcast Received:', p);

                            if (typeof toggleSyncSidebar === "function") {
                                toggleSyncSidebar(true);
                            }

                            let container = $('#sidebar-sync-custom #sync-task-container');
                            container.find('.alert, #no-task-msg').remove();

                            let taskId = `task-${p.type.replace(/\s+/g, '-').toLowerCase()}`;

                            // 4. Update atau Tambah Progress Bar
                            if ($(`#${taskId}`).length === 0) {
                                const html = `
                                    <div id="${taskId}" class="card mb-3 border-0 shadow-sm bg-light">
                                        <div class="card-body p-3">
                                            <div class="d-flex justify-content-between align-items-center mb-2">
                                                <span class="small fw-bold text-uppercase text-primary" style="font-size: 10px;">${p.type}</span>
                                                <span class="badge bg-primary rounded-pill" id="${taskId}-percent">${p.percentage}%</span>
                                            </div>
                                            <div class="progress" style="height: 10px !important;">
                                                <div id="${taskId}-bar" class="progress-bar progress-bar-striped progress-bar-animated bg-primary"
                                                    role="progressbar" style="width: ${p.percentage}%"></div>
                                            </div>
                                        </div>
                                    </div>`;
                                container.append(html);
                            } else {
                                $(`#${taskId}-bar`).css('width', p.percentage + '%');
                                $(`#${taskId}-percent`).text(p.percentage + '%');
                            }

                            // 5. Kondisi Selesai & Penghapusan Elemen
                            if (p.status === 'completed' || p.percentage >= 100) {
                                $(`#${taskId}-bar`).removeClass('progress-bar-animated bg-primary').addClass('bg-success');
                                $(`#${taskId}-percent`).removeClass('bg-primary').addClass('bg-success').text('DONE');

                                if (typeof notyf !== 'undefined') notyf.success(`${p.type} Selesai!`);

                                // --- LOGIKA MENGHILANGKAN SATU PER SATU ---
                                setTimeout(() => {
                                    $(`#${taskId}`).fadeOut(500, function() {
                                        $(this).remove(); // Hapus dari DOM setelah fadeOut selesai

                                        // Jika sudah tidak ada kartu lagi, hentikan animasi spin icon
                                        if (container.children().length === 0) {
                                            $('#sync-icon-status').removeClass('sync-spin');
                                            // Opsional: munculkan pesan "Semua Tugas Selesai"
                                            container.html('<div id="no-task-msg" class="text-center small text-muted">Semua tugas selesai.</div>');
                                        }
                                    });
                                }, 3000); // 3000ms = kartu hilang 3 detik setelah DONE
                            }
                        });
                                    }
            }, 500);
        });
    </script>
</body>
</html>
