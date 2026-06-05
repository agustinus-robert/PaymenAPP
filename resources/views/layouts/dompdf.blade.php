<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>@yield('title')</title>
    <style>
        @page {
            margin: 3cm 1cm;
        }

        table {
            border-spacing: 0;
            border-collapse: 0;
        }

        p,
        td {
            font-size: 11pt;
            line-height: 1.5rem;
        }

        th,
        td {
            vertical-align: top;
        }

        .bold {
            font-weight: bold;
        }

        .center {
            text-align: center;
        }

        .break {
            page-break-after: always;
        }
    </style>
    @stack('styles')
</head>

<body>
    @yield('content')

</body>

</html>
