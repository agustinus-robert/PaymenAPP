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

    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- END Icons -->

    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@24,400,0,0" />
    <link rel="stylesheet" id="css-main" href="{{ asset('material/css/material-dashboard-full.min.css') }}">

    <!-- Stylesheets -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" id="bootstrap-style" href="{{ asset('skote/css/bootstrap.min.css') }}" type="text/css">
    <link href="{{ asset('skote/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- App Css-->
    <link href="{{ asset('skote/css/app.min.css') }}" id="app-style" rel="stylesheet" type="text/css" />
    <!-- App js -->
    <script>
        let BASE_URL = "{{ asset('skote') }}";
    </script>
    <script src="{{ asset('skote/js/plugin.js') }}"></script>

    {{-- <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script> --}}
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@chgibb/css-spinners@2.2.1/css/spinners.min.css">

    <!-- You can include a specific file from css/themes/ folder to alter the default color theme of the template. eg: -->
    <!-- <link rel="stylesheet" id="css-theme" href="assets/css/themes/xwork.min.css"> -->
    <!-- END Stylesheets -->
    <script src="{{ asset('skote/libs/jquery/jquery.min.js') }}"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.js"></script>
    <script src="{{ asset('skote/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    @stack('styles')
</head>

<body data-sidebar="dark">

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

    <!--
      Dashmix JS

      Core libraries and functionality
      webpack is putting everything together at assets/_js/main/app.js
    -->


    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script src="{{ asset('skote/libs/metismenu/metisMenu.min.js') }}"></script>
    <script src="{{ asset('skote/libs/simplebar/simplebar.min.js') }}"></script>
    <script src="{{ asset('skote/libs/node-waves/waves.min.js') }}"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/tom-select/2.4.3/js/tom-select.complete.js" integrity="sha512-cv8SyZZkoW3eB3rWs0JsM/wNxKZe59+tMN8ewVIu24I1EAeBOT6lqkdty/iMxo3OJGvrFRYIrrGwM5BJqAXsYw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <!-- apexcharts -->
    <script src="{{ asset('skote/libs/apexcharts/apexcharts.min.js') }}"></script>

    <!-- dashboard init -->
    <script src="{{ asset('skote/js/pages/dashboard.init.js') }}"></script>
    <script src="{{ asset('skote/libs/chart.js/chart.umd.js') }}"></script>

    <!-- App js -->
    {{-- <script src="{{ mix('js/app.js') }}"></script> --}}
    <script src="{{ asset('skote/js/app.js') }}"></script>
    <script src="{{ asset('js/scripts2.js') }}"></script>

    <script type="text/javascript">
        $(document).ready(function() {
            $('.select-2').select2({
                theme: 'bootstrap-5'
            });
        });
    </script>
    @include('web::electro.global.echos')
    @stack('scripts')
</body>

</html>
