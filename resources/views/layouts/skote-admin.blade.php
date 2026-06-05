<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1.0">

    <title>Solo CMS</title>

    <meta name="description" content="Point Of Sale UMKM">
    <meta name="author" content="pixelcave">
    <meta name="robots" content="noindex, nofollow">

    <!-- Open Graph Meta -->
    <meta property="og:title" content="Point Of Sale UMKM">
    <meta property="og:site_name" content="POS">
    <meta property="og:description" content="Point Of Sale UMKM">
    <meta property="og:type" content="website">
    <meta property="og:url" content="">
    <meta property="og:image" content="">

    <!-- Icons -->
    <!-- The following icons can be replaced with your own, they are used by desktop and mobile browsers -->
    <link rel="shortcut icon" href="{{ asset('skote/images/favicon.ico') }}">
    <link rel="icon" type="image/png" sizes="192x192" href="{{ asset('skote/images/favicon.ico') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('skote/images/favicon.ico') }}">
    <!-- END Icons -->

    <!-- Stylesheets -->
    <!-- Dashmix framework -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.css">
    <link rel="stylesheet" id="css-main" href="{{ asset('skote/css/bootstrap.min.css') }}">
    <link href="{{ asset('skote/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- App Css-->
    <link href="{{ asset('skote/css/app.min.css') }}" id="app-style" rel="stylesheet" type="text/css" />
    <!-- App js -->
    <script src="{{ asset('skote/js/plugin.js') }}"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@chgibb/css-spinners@2.2.1/css/spinners.min.css">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <!-- You can include a specific file from css/themes/ folder to alter the default color theme of the template. eg: -->
    <!-- <link rel="stylesheet" id="css-theme" href="assets/css/themes/xwork.min.css"> -->
    <!-- END Stylesheets -->
    @stack('style')
</head>

<body data-topbar="dark" data-layout="horizontal">

    <div id="layout-wrapper">
        @yield('body-content')
    </div>

    <!-- Right Sidebar -->
    <div class="right-bar">
        <div data-simplebar class="h-100">
            <div class="rightbar-title d-flex align-items-center px-3 py-4">

                <h5 class="m-0 me-2">Settings</h5>

                <a href="javascript:void(0);" class="right-bar-toggle ms-auto">
                    <i class="mdi mdi-close noti-icon"></i>
                </a>
            </div>

            <!-- Settings -->
            <hr class="mt-0" />
            <h6 class="mb-0 text-center">Choose Layouts</h6>

            <div class="p-4">
                <div class="mb-2">
                    <img src="assets/images/layouts/layout-1.jpg" class="img-thumbnail" alt="layout images">
                </div>

                <div class="form-check form-switch mb-3">
                    <input class="form-check-input theme-choice" type="checkbox" id="light-mode-switch" checked>
                    <label class="form-check-label" for="light-mode-switch">Light Mode</label>
                </div>

                <div class="mb-2">
                    <img src="assets/images/layouts/layout-2.jpg" class="img-thumbnail" alt="layout images">
                </div>
                <div class="form-check form-switch mb-3">
                    <input class="form-check-input theme-choice" type="checkbox" id="dark-mode-switch">
                    <label class="form-check-label" for="dark-mode-switch">Dark Mode</label>
                </div>

                <div class="mb-2">
                    <img src="assets/images/layouts/layout-3.jpg" class="img-thumbnail" alt="layout images">
                </div>
                <div class="form-check form-switch mb-3">
                    <input class="form-check-input theme-choice" type="checkbox" id="rtl-mode-switch">
                    <label class="form-check-label" for="rtl-mode-switch">RTL Mode</label>
                </div>

                <div class="mb-2">
                    <img src="assets/images/layouts/layout-4.jpg" class="img-thumbnail" alt="layout images">
                </div>
                <div class="form-check form-switch mb-5">
                    <input class="form-check-input theme-choice" type="checkbox" id="dark-rtl-mode-switch">
                    <label class="form-check-label" for="dark-rtl-mode-switch">Dark RTL Mode</label>
                </div>


            </div>

        </div> <!-- end slimscroll-menu-->
    </div>
    <!-- /Right-bar -->

    <!-- Right bar overlay-->
    <div class="rightbar-overlay"></div>
    <!-- END Page Container -->

    <div id="global-progress-wrapper"
        style="position: fixed; bottom: 20px; right: 20px; width: 250px; height: 25px;
                background: rgba(0,0,0,0.2); border-radius: 6px; display: none; z-index: 9999;">
        <div id="progress-bar"
            style="height: 100%; width: 0%; background: #4caf50; border-radius: 6px;">
        </div>
    </div>

    <!--
      Dashmix JS

      Core libraries and functionality
      webpack is putting everything together at assets/_js/main/app.js
    -->
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="{{ asset('skote/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('skote/libs/metismenu/metisMenu.min.js') }}"></script>
    <script src="{{ asset('skote/libs/simplebar/simplebar.min.js') }}"></script>
    <script src="{{ asset('skote/libs/node-waves/waves.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.js"></script>

    <!-- apexcharts -->
    <script src="{{ asset('skote/libs/chart.js/chart.umd.js') }}"></script>

    <!-- dashboard init -->
    {{-- <script src="{{ asset('skote/js/pages/dashboard.init.js') }}"></script> --}}

    <!-- App js -->
    <script src="{{ asset('skote/js/app.js') }}"></script>

    <script>
        const notyf = new Notyf();

        $(document).ready(function(){
            $('.select-2').select2({
                width: '100%',
                theme: 'bootstrap-5',
                placeholder: 'Pilih salah satu'
            });
        });

        window.addEventListener('alert-success', event => {
            notyf.success(event.detail.message);
        });

        window.addEventListener('alert-danger', event => {
            notyf.error(event.detail.message);
        });
    </script>

    @stack('scripts')

    <script>
        function startProgress(key) {
            document.getElementById('progress-box').style.display = 'block';

            let interval = setInterval(() => {
                fetch('/progress?schedule_key=' + key)
                    .then(r => r.json())
                    .then(data => {
                        document.getElementById('progress-bar').style.width = data.percent + '%';

                        if (data.percent >= 100) {
                            clearInterval(interval);
                            setTimeout(() => {
                                document.getElementById('progress-box').style.display = 'none';
                                document.getElementById('progress-bar').style.width = '0%';
                            }, 800);
                        }
                    });
            }, 1000);
        }
    </script>
    <?php if (session('progress_key')): ?>
        <script>
            startProgress("<?= session('progress_key'); ?>");
        </script>
    <?php endif; ?>

</body>

</html>
