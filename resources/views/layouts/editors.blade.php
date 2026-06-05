<!DOCTYPE HTML>
<html>

<head>
    <meta charset="utf-8">
    <title>Editor - Page</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <link rel="shortcut icon" href="#">
    <link rel="stylesheet" href="{{ asset('cbox/notyf.min.css') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="shortcut icon" href="{{ asset('backendPos/media/favicons/favicon.png') }}">
    <link href="{{ asset('cbox/contentbuilder/contentbuilder.css') }}" rel="stylesheet">
    <link href="{{ asset('cbox/contentbox/contentbox.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('cbox/jsuites.css') }}" type="text/css" />

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <link href="{{ asset('cbox/spinners.min.css') }}" rel="stylesheet">

    <style>
        /* Switch the device buttons to save space on smaller screen */
        .jloading {
            z-index: 99999;
        }

        @media all and (max-width: 1380px) {

            .custom-topbar .btn-device-desktop,
            .custom-topbar .btn-device-tablet,
            .custom-topbar .btn-device-tablet-landscape,
            .custom-topbar .btn-device-mobile {
                display: none !important
            }

            /* Hide the topbar buttons */

            .is-responsive-toolbar {
                display: inline-flex !important
            }

            /* Show the default buttons */
        }

        .topbar-shadow {
            position: fixed;
            left: 0;
            top: 47px;
            width: 100%;
            height: 5px;
            z-index: 1;
            box-shadow: rgba(0, 0, 0, 0.04) 0px 5px 5px 0px;
        }
    </style>
</head>

<body>

    @yield('content')

    <script src="{{ asset('cbox/jsuites.js') }}"></script>
    <script src="{{ asset('cbox/contentbox/lang/en.js') }}"></script>
    <script src="{{ asset('cbox/contentbox/contentbox.min.js') }}"></script>
    <script src="{{ asset('cbox/notyf.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>


    @stack('scripts')


    <!-- Required js for production -->
    <script src="{{ asset('cbox/box/box-flex.js') }}"></script> <!-- Box Framework js include -->

</body>

</html>
