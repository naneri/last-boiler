<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    </head>
    <body class="bg-light">
        <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
            <div class="container-xl">
                <span class="navbar-brand fw-semibold">{{ config('app.name', 'Laravel') }}</span>

                @if (Route::has('login'))
                    <div class="ms-auto d-flex gap-2">
                        @auth
                            <a href="{{ url('/dashboard') }}" class="btn btn-outline-secondary btn-sm">Dashboard</a>
                        @else
                            <a href="{{ route('login') }}" class="btn btn-outline-secondary btn-sm">Log in</a>

                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="btn btn-secondary btn-sm">Register</a>
                            @endif
                        @endauth
                    </div>
                @endif
            </div>
        </nav>

        <main class="container-xl py-5 text-center">
            <h1>Welcome to Boiler</h1>
        </main>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    </body>
</html>
