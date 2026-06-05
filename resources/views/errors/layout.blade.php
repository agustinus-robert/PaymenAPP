<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f3f4f6;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            margin: 0;
            color: #1f2937;
        }
        .container {
            text-align: center;
            background: white;
            padding: 4rem 3rem;
            border-radius: 12px;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
            max-width: 500px;
            width: 90%;
        }
        h1 {
            font-size: 6rem;
            margin: 0;
            color: #3b82f6; /* Warna biru, bisa disesuaikan dengan tema aplikasi Anda */
            line-height: 1;
        }
        h2 {
            font-size: 1.5rem;
            margin-top: 1rem;
            margin-bottom: 0.5rem;
            color: #374151;
        }
        p {
            margin-bottom: 2rem;
            color: #6b7280;
            line-height: 1.5;
        }
        .btn {
            display: inline-block;
            padding: 0.75rem 1.5rem;
            background-color: #3b82f6;
            color: white;
            text-decoration: none;
            border-radius: 6px;
            font-weight: 600;
            transition: background-color 0.3s ease;
        }
        .btn:hover {
            background-color: #2563eb;
        }
    </style>
</head>
<body>
    <div class="container">
        @yield('content')
    </div>
</body>
</html>
