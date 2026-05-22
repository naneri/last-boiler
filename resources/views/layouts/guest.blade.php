<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="bg-light">
        <nav class="navbar navbar-light bg-white border-bottom shadow-sm">
            <div class="container-xl">
                <a class="navbar-brand" href="/">
                    <x-application-logo style="height: 2.25rem; width: auto;" />
                </a>
            </div>
        </nav>

        <div class="d-flex flex-column align-items-center justify-content-center py-5">
            <div class="card shadow-sm w-100" style="max-width: 28rem;">
                <div class="card-body p-4">
                    {{ $slot }}
                </div>
            </div>
        </div>
    </body>
</html>
