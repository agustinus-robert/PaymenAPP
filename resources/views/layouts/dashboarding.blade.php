<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1.0">

    <title>Solo CMS</title>

    <meta name="description" content="Point Of Sale UMKM">
    <meta name="author" content="pixelcave">
    <meta name="robots" content="noindex, nofollow">

    <meta property="og:title" content="Point Of Sale UMKM">
    <meta property="og:site_name" content="POS">
    <meta property="og:description" content="Point Of Sale UMKM">
    <meta property="og:type" content="website">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta property="og:url" content="">
    <meta property="og:image" content="">


    @include('layouts.component.skote-style')

    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@chgibb/css-spinners@2.2.1/css/spinners.min.css">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    @stack('style')
</head>

<body class="g-sidenav-show bg-gray-100" data-topbar="dark" data-layout="horizontal">

    <div id="layout-wrapper">
        @yield('body-content')
    </div>


    @include('layouts.component.skote-extra')
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.js"></script>

    <!-- apexcharts -->


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
    @include('web::electro.global.echos')
    @stack('scripts')
</body>

</html>
