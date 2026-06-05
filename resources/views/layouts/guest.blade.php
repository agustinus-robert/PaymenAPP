<!doctype html>
<html lang="en">

<head>

    <meta charset="utf-8" />
    <title>Payment System</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Payment Template" name="description" />
    <meta content="Payment" name="author" />
    <link rel="shortcut icon" href="{{ asset('favicon/favicon.ico') }}">
    <link rel="stylesheet" href="{{ asset('skote/libs/owl.carousel/assets/owl.carousel.min.css') }}">
    <link rel="stylesheet" href="{{ asset('skote/libs/owl.carousel/assets/owl.theme.default.min.css') }}">
    <link href="{{ asset('skote/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('skote/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('skote/css/app.min.css') }}" rel="stylesheet" type="text/css" />
    <script src="{{ asset('skote/js/plugin.js') }}"></script>

</head>

<body class="auth-body-bg">
    @yield('content')

    @livewireScripts
    <script src="{{ mix('js/app.js') }}" defer></script>
</body>

<script src="{{ asset('skote/libs/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('skote/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('skote/libs/metismenu/metisMenu.min.js') }}"></script>
<script src="{{ asset('skote/libs/simplebar/simplebar.min.js') }}"></script>
<script src="{{ asset('skote/libs/node-waves/waves.min.js') }}"></script>

<script src="{{ asset('skote/libs/owl.carousel/owl.carousel.min.js') }}"></script>
<script src="{{ asset('skote/js/pages/auth-2-carousel.init.js') }}"></script>
<script src="{{ asset('skote/js/app.js') }}"></script>

</html>
