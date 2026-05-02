# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Setup

```bash
composer setup   # install deps, copy .env, generate key, migrate, npm install & build
```

## Development

```bash
composer dev     # starts all services concurrently: web server, queue worker, log viewer (pail), Vite
```

This runs four processes in parallel via `concurrently`: `php artisan serve`, `php artisan queue:listen`, `php artisan pail`, and `npm run dev`.

## Testing

```bash
composer test                          # clears config cache, then runs full test suite
php artisan test --filter=TestName     # run a single test or test class
php artisan test tests/Feature/ExampleTest.php  # run a specific file
```

Tests use SQLite in-memory (`DB_DATABASE=:memory:`), so no database setup is needed. Queue runs synchronously and cache/session use the array driver in tests.

## Code Style

```bash
./vendor/bin/pint        # fix code style (Laravel Pint / PSR-12-based)
./vendor/bin/pint --test # check without fixing
```

## Key Architecture Notes

- **Laravel 13 on PHP 8.3+** — uses the fluent `Application::configure()` bootstrap style in `bootstrap/app.php` instead of kernel classes.
- **Database defaults** — MySQL in development (`DB_DATABASE=last_boiler`). Session, cache, and queue all default to the `database` driver, so `php artisan migrate` must be run before the app works.
- **Frontend** — Vite with `laravel-vite-plugin` and Tailwind CSS v4 (via `@tailwindcss/vite`). Entry points: `resources/css/app.css` and `resources/js/app.js`.
- **No API routes** — only `routes/web.php` and `routes/console.php` are registered. Add `api: __DIR__.'/../routes/api.php'` in `bootstrap/app.php` to enable API routing.
- **Middleware and exception handling** — configured via closures directly in `bootstrap/app.php`, not in separate Kernel classes.
